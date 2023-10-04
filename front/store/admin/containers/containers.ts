import _default from "nuxt-icon/dist/module";
import { defineStore } from "pinia";
import { opFetch } from "~/composables/opFetch";

export const useContainersStore = defineStore("containerStore", {
  state: () => ({
    containers: [],
    loading: false,
  }),
  actions: {
    setLoading(value) {
      this.loading = value;
    },
  async getAllContainers() {

      this.setLoading(true);
      try {
        const {
          data: { _rawValue },
        } = await opFetch("/containers", {
          method: "get",
        });
        this.containers = _rawValue;
      } catch (error) {
        console.error(error);
      }
      this.setLoading(false);
    },
  },
});
