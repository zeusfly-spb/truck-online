import { defineStore } from "pinia";
import { opFetch } from "~/composables/opFetch";

export const useDriversStore = defineStore("driversStore", {
  state: () => ({
    drivers: [],
  }),
  actions: {
    async getDrivers() {
      try {
        const {
          data: { _rawValue },
        } = await opFetch("/drivers", { method: "get" });
        this.drivers = _rawValue;
      } catch (error) {
        console.error(error);
      }
    },
    async addDriver(body) {
      try {
        const data = await opFetch("/drivers", { method: "post", body: body });
        this.drivers = [...this.drivers, data];
        console.log("data:", data);
      } catch (error) {
        console.error(error);
      }
    },
  },
});
