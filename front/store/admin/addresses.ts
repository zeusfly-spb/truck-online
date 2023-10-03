import _default from "nuxt-icon/dist/module";
import { defineStore } from "pinia";
import { opFetch } from "~/composables/opFetch";

export const useAddressesStore = defineStore("addressStore", {
  state: () => ({
    addresses: [],
    loading: false,
  }),
  actions: {
    setLoading(value) {
      this.loading = value;
    },
  async getAllAddresses() {

      this.setLoading(true);
      try {
        const {
          data: { _rawValue },
        } = await opFetch("/api/addresses", {
          method: "get",
        });
        this.addresses = _rawValue;
      } catch (error) {
        console.error(error);
      }
      this.setLoading(false);
    },
  },
});
