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
        const response = await fetch("http://217.197.237.54/api/containers", {
          method: "get",
        });
        const data = await response.json();
        this.containers = toRaw(data.data);
      } catch (error) {
        console.error(error);
      }
      this.setLoading(false);
    },
  },
  getters: {},
});
