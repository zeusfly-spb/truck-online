<template>
  <v-row>
    <v-col cols="12">
      <v-autocomplete
        v-model="selectedAddress"
        :items="addressesFrom"
        label="Откуда везем контейнер"
        item-title="name"
        item-value="id"
        ref="textFieldFrom"
        placeholder="ВВЕДИТЕ АДРЕС"
        variant="solo"
        @update:modelValue="selectAddressFrom"
        :rules="[rules.required]"
      >
      </v-autocomplete>
    </v-col>
  </v-row>
</template>
<script setup>
import { useAddressesStore } from "~/store/address";

const emit = defineEmits(["updateSelectAddressFrom"]);
const addressesStore = useAddressesStore();
const selectedAddress = ref([]);

onBeforeMount(async () => {
  watch(selectedAddress, (coordinates) => {
    if (coordinates) {
      emit("updateSelectAddressFrom", selectedAddress.value);
    }
  });
  await addressesStore.getAddresses();
});

const addressesFrom = computed(() => {
  if (!addressesStore.addresses || addressesStore.loading) return [];

  return addressesStore.addresses.filter((el) => el.from == true);
});
const selectAddressFrom = (id) => {
  const address = addressesFrom.value.find((addr) => addr.id === id);
  if (address) {
    selectedAddress.value = toRaw({
      id: address.id,
      name: address.name,
      coordinates: address.location.coordinates,
    });
    console.log("ВЫБРАННЫЙ АДРЕС:", selectedAddress.value);
  }
};
const clearInput = () => {
  selectedAddress.value = "";
};

const rules = {
  required: (value) =>
    !selectedAddress.value || "Поле обязательно для заполнения",
};
defineExpose({
  clearInput,
});
</script>
<style scoped></style>
