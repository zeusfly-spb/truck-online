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
        console.log("allcars:", this.cars);
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
          headers,
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
