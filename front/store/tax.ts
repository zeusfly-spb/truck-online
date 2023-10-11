import { defineStore } from "pinia";
import { opFetch } from "~/composables/opFetch";
export const useTaxesStore = defineStore("taxesStore", {
  state: () => ({
    taxes: [],
    loading: false,
  }),
  actions: {
    setLoading(value) {
      this.loading = value;
    },
    async getTaxes() {
      this.setLoading(true);
      try {
        const {
          data: { _rawValue },
        } = await opFetch("/taxes", { method: "GET" });
        this.taxes = _rawValue;
      } catch (error) {
        console.error(error);
      }
      this.setLoading(false);
    },
  },
});
