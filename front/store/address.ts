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
        const converting = response.data._rawValue.data;
        this.addresses = converting.map((address) => {
          const decodedName = JSON.parse(address.name).ru;
          return { ...address, name: decodedName };
        });
        console.log("АДРЕСА:", this.addresses);
      } catch (error) {
        console.error(error);
      }
    },
  },
  getters: {},
});
