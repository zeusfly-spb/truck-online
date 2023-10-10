import _default from "nuxt-icon/dist/module";
import { defineStore } from "pinia";
import { opFetch } from "~/composables/opFetch";

export const useCalcHistoryStore = defineStore("calcHistoryStore", {
  state: () => ({
    calcHistories: [],
    history: [],
    loading: false,
  }),
  actions: {
    setLoading(value) {
      this.loading = value;
    },
  async getAllCalcHistories() {

      this.setLoading(true);
      try {
        const {
          data: { _rawValue },
        } = await opFetch("/calc/histories", {
          method: "get",
        });
        this.calcHistories = _rawValue;
        console.log(this.calcHistories);
      } catch (error) {
        console.error(error);
      }
      this.setLoading(false);
    },
  async getHistory(id) {
      try {
        const {
          data: { _rawValue },
        } = await opFetch(`/calc/histories/${id}`, {
          method: "get",
        });
        this.history = _rawValue;
      } catch (error) {
        console.error(error);
      }
      this.setLoading(false);
  },
  },
});
