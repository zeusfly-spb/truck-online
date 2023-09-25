import { defineStore } from "pinia";
import { opFetch } from "~/composables/opFetch";

export const useDriversStore = defineStore("driversStore", {
  state: () => ({
    drivers: [],
    driverId: null,
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
        const {
          data: { _rawValue },
        } = await opFetch("/drivers", {
          method: "post",
          body: body,
        });
        this.driverId = _rawValue.data.id;
        console.log("id:", this.driverId);
        console.log("data:", _rawValue);
      } catch (error) {
        console.error(error);
      }
    },
    async addDocumentsDriver(body) {
      try {
        const {
          data: { _rawValue },
        } = await opFetch(`/drivers/${this.driverId}`, {
          method: "post",
          body: body,
        });
        console.log(_rawValue);
      } catch (error) {
        console.error(error);
      }
    },
  },
});
