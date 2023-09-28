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
        } = await opFetch("http://217.197.237.54/api/containers");
        this.containers = _rawValue;
      } catch (error) {
        console.error(error);
      }
      this.setLoading(false);
    },
  },
});
