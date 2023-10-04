import _default from "nuxt-icon/dist/module";
import { defineStore } from "pinia";
import { opFetch } from "~/composables/opFetch";

export const useCarTypesStore = defineStore("carTypesStore", {
  state: () => ({
    carTypes: [],
    loading: false,
  }),
  actions: {
    setLoading(value) {
      this.loading = value;
    },
  async getAllCarTypes() {

      this.setLoading(true);
      try {
        const {
          data: { _rawValue },
        } = await opFetch("/car/types", {
          method: "get",
        });
        this.carTypes = _rawValue;
      } catch (error) {
        console.error(error);
      }
      this.setLoading(false);
    },
  },
});
