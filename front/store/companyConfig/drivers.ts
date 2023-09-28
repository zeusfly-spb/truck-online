import { defineStore } from "pinia";
import { opFetch, opFetchMultiply } from "~/composables/opFetch";

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
        console.log("dataAdd:", _rawValue);
      } catch (error) {
        console.error(error);
      }
    },
    async addPassportDriver(formData) {
      try {
        const token_cookie = useCookie("online_port_token");
        const headers = new Headers();
        if (token_cookie.value) {
          headers.set("Authorization", `Bearer ${token_cookie.value}`);
        }
        const response = await useFetch(`/driver/files/${this.driverId}`, {
          method: "post",
          body: formData,
          headers,
          // processData: false,
        });
        console.log("filesADd:", response);
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
        console.log("documentsADD:", data);
      } catch (error) {
        console.error(error);
      }
    },
  },
});
