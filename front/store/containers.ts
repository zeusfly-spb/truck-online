import { defineStore } from "pinia";
import { opFetch } from "~/composables/opFetch";
export const useContainersStore = defineStore("containersStore", {
  state: () => ({
    containers: [],
  }),
  actions: {
    async getContainers() {
      try {
        const response = await fetch("http://217.197.237.54/api/containers", {
          method: "get",
        });
        const data = await response.json();
        this.containers = toRaw(data.data);
      } catch (error) {
        console.error(error);
      }
    },
  },
  getters: {},
});
