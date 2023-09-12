import {defineStore} from "pinia";
import {opFetch} from "~/composables/opFetch";

const getAddressesUrl = "/addresses";

export const useAddressesStore = defineStore("addressesStore", {
  state: () => ({
    addresses: [],
  }),
  actions: {
    async getAddresses() {
      try {
        const response = await opFetch(getAddressesUrl, {method: "get"});
        const d = response.data._rawValue;
        this.addresses = d.map((item) => {
          const decodedName = item.name;
          return { ...item, name: decodedName };
        });
      } catch (error) {
        console.error(error);
      }
    },
  },
  getters: {},
});
