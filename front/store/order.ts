import { defineStore } from "pinia";
import { opFetch } from "~/composables/opFetch";

export const useOrdersStore = defineStore("ordersStore", {
  state: () => ({
    orders: [],
    loading: false,
  }),
  actions: {
    setLoading(value) {
      this.loading = value;
    },
    async getOrders() {
      this.setLoading(true);
      try {
        const {
          data: { _rawValue },
        } = await opFetch("/orders", { method: "get" });
        this.orders = _rawValue;
      } catch (error) {
        console.error(error);
      }
      this.setLoading(false);
    },
    async createOrder(body) {
      try {
        const {
          data: { _rawValue },
        } = await opFetch("/orders/store", {
          method: "post",
          body: { data: body },
        });
        if (_rawValue === "success") {
          useSnack({
            show: true,
            type: "success",
            title: "Заказ успешно создан!",
            message: "Заказ отображается в вашем профиле",
          });
        }
      } catch (error) {
        console.error(error);
      }
    },
  },
});
