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
        } = opFetch("/countries", { method: "get" });
        this.countries = _rawValue;
        console.log("country:", this.countries);
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
        } = opFetch("/car/right-uses", {
          method: "get",
        });
        this.rightUse = _rawValue;
        console.log("right:", this.rightUse);
      } catch (error) {
        console.error(error);
      }
      this.setLoading(false);
    },
    async getAllCars() {
      this.setLoading(true);
      try {
        const {
          data: { _rawValue },
        } = await opFetch("/api/cars", {
          method: "get",
        });
        this.cars = _rawValue;
      } catch (error) {
        console.error(error);
      }
      this.setLoading(false);
    },
    async addNewCar(formData) {
      try {
        const {
          data: { _rawValue },
        } = await opFetch("/api/cars", {
          method: "post",
          body: formData,
        });
      } catch (error) {
        console.error(error);
      }
    },
  },
});
