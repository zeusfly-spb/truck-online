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
        const response = await opFetch(getAddressesUrl, {
          method: "get",
        });
        const res = response.data._rawValue.data;
        this.addresses = res;
      } catch (error) {
        console.error(error);
      }
    },
  },
  getters: {},
});
