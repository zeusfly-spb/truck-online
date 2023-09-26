import { defineStore } from "pinia";
import { opFetch } from "~/composables/opFetch";
export const useContainersStore = defineStore("containersStore", {
  state: () => ({
    containers: [],
    loading: false,
  }),
  actions: {
    setLoading(value) {
      this.loading = value;
    },
    async getContainers() {
      this.setLoading(true);
      try {
        const {
          data: { _rawValue },
        } = await opFetch("/33");
        this.containers = _rawValue;
      } catch (error) {
        console.error(error);
      }
      this.setLoading(false);
    },
  },
});
