import { defineStore } from "pinia";
import { opFetch } from "~/composables/opFetch";

const getAddressesUrl = "/addresses";

export const useAddressesStore = defineStore("addressesStore", {
  state: () => ({
    addresses: [],
    loading: false,
  }),
  actions: {
    setLoading(value) {
      this.loading = value;
    },
    async getAddresses() {
      this.setLoading(true);
      try {
        const {data: {_rawValue}} = await opFetch(getAddressesUrl, {method: "get"});
        this.addresses = _rawValue;
      } catch (error) {
        console.error(error);
      }
      this.setLoading(false);
    },
  },
  getters: {},
});
