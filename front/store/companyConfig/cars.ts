import _default from "nuxt-icon/dist/module";
import { defineStore } from "pinia";
import { opFetch } from "~/composables/opFetch";

export const useCarsStore = defineStore("cardStore", {
  state: () => ({
    typesCars: [],
    countries: [],
    rightUse: [],
    cars: [],
    loading: false,
    oneCar: null,
  }),
  actions: {
    setLoading(value) {
      this.loading = value;
    },
    async getAllCars() {
      this.setLoading(true);
      try {
        const {
          data: { _rawValue },
        } = await opFetch("/cars", {
          method: "get",
        });
        this.cars = _rawValue;
      } catch (error) {
        console.error(error);
      }
      this.setLoading(false);
    },
    async getTypesCar() {
      this.setLoading(true);
      try {
        const {
          data: { _rawValue },
        } = await opFetch("/car/types", { method: "get" });
        this.typesCars = _rawValue;
      } catch (error) {
        console.error(error);
      }
      this.setLoading(false);
    },
    async getCountries() {
      this.setLoading(true);
      try {
        const {
          data: { _rawValue },
        } = await opFetch("/countries", { method: "get" });
        this.countries = _rawValue;
      } catch (error) {
        console.error(error);
      }
      this.setLoading(false);
    },
    async getRightUse() {
      this.setLoading(true);
      try {
        const {
          data: { _rawValue },
        } = await opFetch("/car/right-uses", {
          method: "get",
        });
        this.rightUse = _rawValue;
      } catch (error) {
        console.error(error);
      }
      this.setLoading(false);
    },

    async addNewCar(formData) {
      try {
        const {
          data: { _rawValue },
        } = await opFetch("/cars", {
          method: "post",
          body: formData,
        });
        if (_rawValue) {
          this.cars.unshift(_rawValue);
          useSnack({
            show: true,
            type: "success",
            title: "Новая машина успешно добавлена!",
            message: "Поздравляем",
          });
        }
      } catch (error) {
        console.error(error);
      }
    },
    async updateCar(id, formData) {
      try {
        const {
          data: { _rawValue },
        } = await opFetch(`/cars/${id}`, {
          method: "post",
          body: formData,
        });
        if (_rawValue) {
          await this.getAllCars();
          useSnack({
            show: true,
            type: "success",
            title: "Машина успешно обновлена!",
            message: "Поздравляем",
          });
        } else {
          useSnack({
            show: true,
            type: "error",
            title: "При обновлении произошла ошибка!",
            message: "Попробуйте попытку позже",
          });
        }
      } catch (error) {
        console.error(error);
      }
    },
    async showCar(id) {
      this.setLoading(true);
      try {
        const {
          data: { _rawValue },
        } = await opFetch(`/cars/${id}`, { method: "get" });
        if (_rawValue) {
          this.oneCar = _rawValue;
          console.log("onecar:", _rawValue);
        }
      } catch (error) {
        console.error(error);
      }
      this.setLoading(false);
    },
    async deleteCar(id) {
      try {
        const {
          data: { _rawValue },
        } = opFetch(`/car/${id}`, {
          method: "delete",
        });
        this.cars = this.cars.filter((car) => car.id !== id);
      } catch (error) {
        console.error(error);
      }
    },
  },
});
