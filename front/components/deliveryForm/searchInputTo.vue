<template>
  <v-row>
    <v-col cols="12">
      <v-text-field
        v-if="!addingNewAddress"
        v-model="inputTextTo"
        label="КУДА"
        @focus="showDropdownAndClearInput('to')"
        @blur="hideDropdownTo"
        placeholder="ВВЕДИТЕ АДРЕС"
        variant="solo"
        type="text"
        name="delivery_address_id"
        autocomplete="off"
        ref="textFieldTo"
        :rules="[rules.required]"
      ></v-text-field>
      <v-text-field
        v-else
        v-model="newAddress"
        label="КУДА"
        @blur="hideDropdownNew"
        @focus="showDropdownAndClearInput('new')"
        placeholder="ДОБАВИТЬ НОВЫЙ АДРЕС"
        @input="searchAddress"
        variant="solo"
        type="text"
        name="inputTo"
        autocomplete="off"
        ref="textFieldTo"
      ></v-text-field>
      <v-list
        v-if="showDropdownTo || showDropdownNew"
        class="dropdown-list"
        :style="{
          minWidth: textFieldTo ? textFieldTo.$el.offsetWidth + 'px' : 'auto',
        }"
      >
        <v-list-item @click="addListAddress" v-if="showDropdownNew">
          Точка известна
        </v-list-item>
        <v-list-item
          v-for="address in listNewAddresses"
          :key="address.id"
          @click="selectNewAddress(address)"
        >
          {{ address.full_name }}
        </v-list-item>
      </v-list>

      <v-list
        v-if="showDropdownTo"
        class="dropdown-list"
        :style="{
          minWidth: textFieldTo ? textFieldTo.$el.offsetWidth + 'px' : 'auto',
        }"
      >
        <v-list-item @click="addNewAddress"> Точка неизвестна </v-list-item>

        <v-list-item
          v-for="address in addressesTo"
          :key="address.id"
          @click="selectAddressTo(address)"
        >
          {{ address.name }}
        </v-list-item>
      </v-list>
    </v-col>
  </v-row>
</template>
<script setup>
import { useAddressesStore } from "~/store/address";
import { defineEmits, defineExpose } from "vue";
const emit = defineEmits(["updateSelectedAddressTo", "inputErrorTo"]);

const addressesStore = useAddressesStore();
const inputTextTo = ref("");
const showDropdownTo = ref(false);
const selectedAddress = ref([]);
const addingNewAddress = ref(false);
const newAddress = ref("");
const listNewAddresses = ref([]);
const showDropdownNew = ref(false);
const textFieldTo = ref(null);

watch(selectedAddress, (coordinates) => {
  if (coordinates) {
    emit("updateSelectedAddressTo", selectedAddress.value);
  }
});

const rules = {
  required: (value) => !!inputTextTo.value || "Поле обязательно для заполнения",
};

const addressesTo = computed(() => {
  if (!addressesStore.addresses || addressesStore.loading) return [];

  const allAddressesTo = addressesStore.addresses.filter((el) => el.to == true);
  return allAddressesTo.filter((address) =>
    address.name
      .trim()
      .toLowerCase()
      .includes(inputTextTo.value.trim().toLowerCase()),
  );
});

const showDropdownAndClearInput = (type) => {
  if (type === "to") {
    inputTextTo.value = "";
    showDropdownTo.value = true;
  } else if (type === "new") {
    newAddress.value = "";
    showDropdownNew.value = true;
  }
};

const hideDropdownNew = () => {
  setTimeout(() => {
    showDropdownNew.value = false;
  }, 200);
};
const hideDropdownTo = () => {
  setTimeout(() => {
    showDropdownTo.value = false;
  }, 200);
};
const selectAddressTo = (address) => {
  inputTextTo.value = address.name;
  showDropdownTo.value = false;
  selectedAddress.value = toRaw({
    id: address.id,
    name: address.name,
    coordinates: toRaw(address.coordinates.coordinates),
  });
};

const selectNewAddress = (address) => {
  newAddress.value = address.full_name;
  showDropdownNew.value = false;
  selectedAddress.value = toRaw(address.point.reverse());
};

const addNewAddress = () => {
  showDropdownTo.value = false;
  addingNewAddress.value = true;
};

const addListAddress = () => {
  showDropdownNew.value = false;
  addingNewAddress.value = false;
};

const clearInput = () => {
  inputTextTo.value = "";
};
const focusInput = () => {
  selectedAddress.value.focus();
};

defineExpose({
  clearInput,
  focusInput,
});

const searchAddress = async () => {
  try {
    const response = await fetch(
      `https://catalog.api.2gis.com/3.0/suggests?q=${newAddress.value}&key=cb315652-4a77-4656-b55c-2485e210e675&suggest_type=address&fields=items.point`,
    );
    const data = await response.json();
    const r = data.result.items.map((el) => ({
      id: el.id,
      full_name: el.full_name,
      point: [el.point.lat, el.point.lon],
    }));
    listNewAddresses.value = toRaw(r);
    console.log(listNewAddresses.value);
  } catch (error) {
    console.error(error);
  }
};
</script>
<style scoped>
.dropdown-list {
  position: absolute;
  overflow-y: auto;
  max-height: 150px;
  cursor: pointer;
  background-color: white;
  border: 1px solid white;
  z-index: 1000;
  color: black;
  width: 90%;
}
.v-col {
  position: relative;
}
</style>
