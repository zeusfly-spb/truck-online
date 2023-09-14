<template>
  <v-row>
    <v-col cols="12">
      <v-text-field
        v-if="!addingNewAddress"
        v-model="inputTextReturn"
        label="Сдача контейнера"
        @focus="showDropdownAndClearInput('return')"
        @blur="hideDropdownReturn"
        placeholder="ВВЕДИТЕ АДРЕС"
        variant="solo"
        type="text"
        name="return_address_id"
        autocomplete="off"
      ></v-text-field>
      <v-text-field
        v-else
        v-model="newAddress"
        label="Сдача контейнера"
        @focus="showDropdownAndClearInput('new')"
        @blur="hideDropdownNew"
        placeholder="ДОБАВИТЬ НОВЫЙ АДРЕС"
        @input="searchAddress"
        variant="solo"
        type="text"
        name="inputReturn"
        autocomplete="off"
      ></v-text-field>
      <v-list
        v-if="showDropdownReturn || showDropdownNew"
        class="dropdown-list"
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

      <v-list v-if="showDropdownReturn" class="dropdown-list">
        <v-list-item @click="addNewAddress" v-if="showDropdownNew">
          Точка неизвестна
        </v-list-item>

        <v-list-item
          v-for="address in addressesReturn"
          :key="address.id"
          @click="selectAddressReturn(address)"
        >
          {{ address.name }}
        </v-list-item>
      </v-list>
    </v-col>
  </v-row>
</template>
<script>
import { useAddressesStore } from "~/store/address";
export default {
  setup(props, { emit }) {
    const addressesStore = useAddressesStore();
    const inputTextReturn = ref("");
    const showDropdownReturn = ref(false);
    const listNewAddresses = ref([]);
    const selectedAddress = ref([]);
    const addingNewAddress = ref(false);
    const newAddress = ref("");
    const showDropdownNew = ref(false);

    onBeforeMount(async () => {
      watch(selectedAddress, (coordinates) => {
        if (coordinates) {
          emit("updateSelectedAddressReturn", selectedAddress.value);
        }
      });
      await addressesStore.getAddresses();
    });

    watch(newAddress, (newValue) => {
      if (!newValue.trim()) {
        listNewAddresses.value = [];
      }
    });

    const addressesReturn = computed(() => {
      const allAddressesReturn = addressesStore.addresses.filter(
        (el) => el.return == true,
      );
      return allAddressesReturn.filter((address) =>
        address.name
          .trim()
          .toLowerCase()
          .includes(inputTextReturn.value.trim().toLowerCase()),
      );
    });

    const showDropdownAndClearInput = (type) => {
      if (type === "return") {
        inputTextReturn.value = "";
        showDropdownReturn.value = true;
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

    const hideDropdownReturn = () => {
      setTimeout(() => {
        showDropdownReturn.value = false;
      }, 200);
    };
    const selectAddressReturn = (address) => {
      inputTextReturn.value = address.name;
      showDropdownReturn.value = false;
      selectedAddress.value = toRaw({
        id: address.id,
        name: address.name,
        coordinates: toRaw(address.coordinates.coordinates),
      });
      console.log("REEETUUURN:", selectedAddress.value);
    };

    const selectNewAddress = (address) => {
      newAddress.value = address.full_name;
      showDropdownNew.value = false;
      selectedAddress.value = toRaw(address.point.reverse());
    };

    const addNewAddress = () => {
      showDropdownReturn.value = false;
      addingNewAddress.value = true;
    };

    const addListAddress = () => {
      showDropdownNew.value = false;
      addingNewAddress.value = false;
    };

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
    return {
      inputTextReturn,
      showDropdownReturn,
      hideDropdownReturn,
      selectAddressReturn,
      addressesReturn,
      selectedAddress,
      newAddress,
      addNewAddress,
      searchAddress,
      listNewAddresses,
      hideDropdownNew,
      showDropdownNew,
      addListAddress,
      selectNewAddress,
      addingNewAddress,
      showDropdownAndClearInput,
    };
  },
};
</script>
<style scoped>
.dropdown-list {
  position: absolute;
  overflow-y: auto;
  max-height: 150px;
  cursor: pointer;
  background-color: white;
  margin-top: 4px;
  color: black;
  z-index: 1000;
  width: 97%;
}
.v-col {
  position: relative;
}
</style>
