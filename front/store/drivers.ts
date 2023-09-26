import { defineStore } from "pinia";
import { opFetch } from "~/composables/opFetch";

export const useDriversStore = defineStore("driversStore", {
  state: () => ({
    drivers: [],
    driverId: null,
    loading: false,
  }),
  actions: {
    setLoading(value) {
      this.loading = value;
    },
    async getDrivers() {
      this.setLoading(true);
      try {
        const {
          data: { _rawValue },
        } = await opFetch("/drivers", { method: "get" });
        this.drivers = _rawValue;
      } catch (error) {
        console.error(error);
      }
      this.setLoading(false);
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
    async addPasspotrDriver(body) {
      try {
        const data = await opFetch(`/driver/files/${this.driverId}`, {
          method: "post",
          body: body,
        });
        console.log("files:", data);
      } catch (error) {
        console.error(error);
      }
    },
    async addDriverLicense(body) {
      try {
        const data = await opFetch(`/driver/documents/${this.driverId}`, {
          method: "post",
          body: body,
        });
        console.log("documents:", data);
      } catch (error) {
        console.error(error);
      }
    },
  },
});
