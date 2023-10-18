import { defineStore } from "pinia";
import { opFetch } from "~/composables/opFetch";

export const useDriversStore = defineStore("driversStore", {
  state: () => ({
    drivers: [],
    driverId: null,
    loading: false,
    oneDriver: null,
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
        if (_rawValue) {
        }
        //this.driverId = _rawValue.data.id;
        console.log("dataAdd:", _rawValue);
      } catch (error) {
        console.error(error);
      }
    },
    async addPassportDriver(formData) {
      try {
        const {
          data: { _rawValue },
        } = await opFetch(`/driver/files/${this.driverId}`, {
          method: "post",
          body: formData,
        });
        if (_rawValue) {
          await this.getDrivers();
          useSnack({
            show: true,
            type: "success",
            title: "Новый водитель успешно добавлен!",
            message: "Поздравляем",
          });
        }
        console.log("filesADd:", response.status._rawValue);
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
    async showOneDriver(id) {
      try {
        const {
          data: { _rawValue },
        } = await opFetch(`/drivers/${id}`, {
          method: "get",
        });
        if (_rawValue) {
          this.oneDriver = _rawValue;
        }
      } catch (erorr) {
        console.error(erorr);
      }
    },
    async deleteDriver(id) {
      try {
        const {
          data: { _rawValue },
        } = await opFetch(`/drivers/${id}`, {
          method: "delete",
        });
        this.drivers = this.drivers.filter((driver) => driver.id !== id);
      } catch (eror) {
        console.error(eror);
      }
    },
  },
});
