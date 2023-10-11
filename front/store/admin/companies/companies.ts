import _default from "nuxt-icon/dist/module";
import { defineStore } from "pinia";
import { opFetch } from "~/composables/opFetch";

export const useCompanyStore = defineStore("companyStore", {
  state: () => ({
    companies: [],
    loading: false,
  }),
  actions: {
    setLoading(value) {
      this.loading = value;
    },
  async getAllCompanies() {

      this.setLoading(true);
      try {
        const {
          data: { _rawValue },
        } = await opFetch("/companies", {
          method: "get",
        });
        this.companies = _rawValue;

      } catch (error) {
        console.error(error);
      }
      this.setLoading(false);
    },
  },
});
