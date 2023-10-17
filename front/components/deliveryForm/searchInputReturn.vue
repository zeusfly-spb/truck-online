<template>
  <v-row>
    <v-col cols="12">
      <v-autocomplete
        v-model="selectedAddress"
        :items="addressesReturn"
        label="Куда вовзращаем контейнер"
        item-title="name"
        item-value="id"
        ref="textFieldFrom"
        placeholder="ВВЕДИТЕ АДРЕС"
        variant="solo"
        @update:modelValue="selectAddressReturn"
        :rules="[rules.required]"
      >
      </v-autocomplete>
    </v-col>
  </v-row>
</template>
<script setup>
import { useAddressesStore } from "~/store/address";
import {
  defineEmits,
  defineExpose,
  computed,
  ref,
  onBeforeMount,
  toRaw,
} from "vue";

const emit = defineEmits(["updateSelectAddressFrom"]);
const addressesStore = useAddressesStore();
const selectedAddress = ref(null);

onBeforeMount(async () => {
  watch(selectedAddress, (coordinates) => {
    if (coordinates) {
      emit("updateSelectedAddressReturn", selectedAddress.value);
    }
  });
  await addressesStore.getAddresses();
});

const addressesReturn = computed(() => {
  if (!addressesStore.addresses || addressesStore.loading) return [];

  return addressesStore.addresses.filter((el) => el.return == true);
});
const selectAddressReturn = (id) => {
  const address = addressesReturn.value.find((addr) => addr.id === id);
  if (address) {
    selectedAddress.value = toRaw({
      id: address.id,
      name: address.name,
      coordinates: address.coordinates.coordinates,
    });
    console.log("ВЫБРАННЫЙ АДРЕС RETURN:", selectedAddress.value);
  }
};
const clearInput = () => {
  selectedAddress.value = "";
};

const rules = {
  required: (value) =>
    !!selectedAddress.value || "Поле обязательно для заполнения",
};
defineExpose({
  clearInput,
});
</script>
<style scoped></style>
