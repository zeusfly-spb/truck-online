import { defineStore } from "pinia";

export const useIntermediateFormData = defineStore("intermediateData", {
  state: () => ({
    formData: null,
  }),
  actions: {
    setFormData(formIntermediateData) {
      this.formData = formIntermediateData;
    },
  },
  getters: {},
});
