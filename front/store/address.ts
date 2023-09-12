import { defineStore } from "pinia";
import { opFetch } from "~/composables/opFetch";

const getAddressesUrl = "/addresses";

export const useAddressesStore = defineStore("addressesStore", {
  state: () => ({
    addresses: [],
  }),
  actions: {
    async getAddresses() {
      try {
        const response = await opFetch(getAddressesUrl, {
          method: "get",
        });
        const d = response.data.value.data;
        this.addresses = d.map((item) => {
          const decodedName = JSON.parse(item.name).ru;
          return { ...item, name: decodedName };
        });
        console.log("АДРЕСА:", this.addresses);
      } catch (error) {
        console.error(error);
      }
    },
  },
  getters: {},
});
