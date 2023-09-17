<template>
  <v-row>
    <v-col cols="12">
      <v-text-field
        v-if="!addingNewAddress"
        v-model="inputTextFrom"
        label="Откуда везем контейнер"
        @focus="showDropdownAndClearInput('from')"
        @blur="hideDropdownFrom"
        placeholder="ВВЕДИТЕ АДРЕС"
        variant="solo"
        type="text"
        name="from_address_id"
        autocomplete="off"
        ref="textFieldFrom"
      ></v-text-field>
      <v-text-field
        v-else
        v-model="newAddress"
        label="ОТКУДА"
        @focus="showDropdownAndClearInput('new')"
        @blur="hideDropdownNew"
        placeholder="ДОБАВИТЬ НОВЫЙ АДРЕС"
        @input="searchAddress"
        variant="solo"
        type="text"
        name="fromAddress"
        autocomplete="off"
        ref="textFieldFrom"
      ></v-text-field>
      <v-list
        v-if="showDropdownFrom || showDropdownNew"
        class="dropdown-list"
        :style="{
          minWidth: textFieldFrom
            ? textFieldFrom.$el.offsetWidth + 'px'
            : 'auto',
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
        v-if="showDropdownFrom"
        class="dropdown-list"
        :style="{
          minWidth: textFieldFrom
            ? textFieldFrom.$el.offsetWidth + 'px'
            : 'auto',
        }"
      >
        <v-list-item @click="addNewAddress" v-if="showDropdownFrom">
          Точка неизвестна
        </v-list-item>
        <v-list-item
          v-for="address in addressesFrom"
          :key="address.id"
          @click="selectAddressFrom(address)"
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

const emit = defineEmits(["updateSelectAddressFrom", "clear"]);
const addressesStore = useAddressesStore();
const inputTextFrom = ref("");
const showDropdownFrom = ref(false);
const selectedAddress = ref([]);
const addingNewAddress = ref(false);
const newAddress = ref("");
const listNewAddresses = ref([]);
const showDropdownNew = ref(false);
const textFieldFrom = ref(null);

onBeforeMount(async () => {
  watch(selectedAddress, (coordinates) => {
    if (coordinates) {
      emit("updateSelectAddressFrom", selectedAddress.value);
    }
  });
  await addressesStore.getAddresses();
});
console.log("АДРЕСА IN FROM:", addressesStore.addresses);
watch(newAddress, (newValue) => {
  if (!newValue.trim()) {
    listNewAddresses.value = [];
  }
});

const addressesFrom = computed(() => {
  const allAdressesFrom = addressesStore.addresses.filter(
    (el) => el.from == true,
  );
  return allAdressesFrom.filter((address) =>
    address.name
      .trim()
      .toLowerCase()
      .includes(inputTextFrom.value.trim().toLowerCase()),
  );
});

const showDropdownAndClearInput = (type) => {
  if (type === "from") {
    inputTextFrom.value = "";
    showDropdownFrom.value = true;
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

const hideDropdownFrom = () => {
  setTimeout(() => {
    showDropdownFrom.value = false;
  }, 200);
};

const selectAddressFrom = (address) => {
  inputTextFrom.value = address.name;
  showDropdownFrom.value = false;
  selectedAddress.value = toRaw({
    id: address.id,
    name: address.name,
    coordinates: toRaw(address.coordinates.coordinates),
  });
};

const selectNewAddress = (address) => {
  newAddress.value = address.full_name;
  showDropdownNew.value = false;
  selectedAddress.value = toRaw(address.point); //сперва коректно отображалось с reverse, но потом стало неправильно
};

const addNewAddress = () => {
  showDropdownFrom.value = false;
  addingNewAddress.value = true;
};

const addListAddress = () => {
  showDropdownNew.value = false;
  addingNewAddress.value = false;
};

const clearInput = () => {
  inputTextFrom.value = "";
};

defineExpose({
  clearInput,
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
  color: black;
  z-index: 1000;
  width: 90%;
}
.v-col {
  position: relative;
}
</style>
