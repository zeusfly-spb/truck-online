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
        const response = await opFetch(getAddressesUrl, {
          method: "get",
        });
        this.addresses = response.data._rawValue.data;
      } catch (error) {
        console.error(error);
      }
      this.setLoading(false);
    },
  },
  getters: {},
});
