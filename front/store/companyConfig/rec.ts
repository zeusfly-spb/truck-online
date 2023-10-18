import _default from "nuxt-icon/dist/module";
import { defineStore } from "pinia";
import { opFetch } from "~/composables/opFetch";

export const useRecsStore = defineStore("recStore", {
  state: () => ({
    recs: [],
    loading: false,
  }),
  actions: {
    setLoading(value) {
      this.loading = value;
    },
    async getAllRecs() {
      this.setLoading(true);
      try {
        const {
          data: { _rawValue },
        } = await opFetch("/bank_details", {
          method: "get",
        });
        this.recs = _rawValue;
      } catch (error) {
        console.error(error);
      }
      this.setLoading(false);
    },
    async addNewRec(formData) {
      try {
        const {
          data: { _rawValue },
        } = await opFetch("/bank_details", {
          method: "post",
          body: formData,
        });
        console.log("BankDetailsAdd",_rawValue);
        if (_rawValue) {
          this.recs.unshift(_rawValue);
          useSnack({
            show: true,
            type: "success",
            title: "Новый реквизит успешно добавлен!",
            message: "Поздравляем",
          });
        }
      } catch (error) {
        console.error(error);
      }
    },
    async deleteRec(id) {
      try {
        const {
          data: { _rawValue },
        } = opFetch(`/bank_details/${id}`, {
          method: "delete",
        });
        this.recs = this.recs.filter((rec) => rec.id !== id);
      } catch (error) {
        console.error(error);
      }
    },
  },
});
