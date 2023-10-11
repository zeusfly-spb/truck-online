import _default from "nuxt-icon/dist/module";
import { defineStore } from "pinia";
import { opFetch } from "~/composables/opFetch";

export const useDriversStore = defineStore("driverStore", {
  state: () => ({
    drivers: [],
    loading: false,
  }),
  actions: {
    setLoading(value) {
      this.loading = value;
    },
  async getAllUsers() {

      this.setLoading(true);
      try {
        const {
          data: { _rawValue },
        } = await opFetch("/admin/drivers", {
          method: "get",
        });
        this.drivers = _rawValue;

      } catch (error) {
        console.error(error);
      }
      this.setLoading(false);
    },
  },
});
