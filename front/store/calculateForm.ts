import { defineStore } from "pinia";
import { opFetch } from "~/composables/opFetch";
const url = "orders/store";

export const useCalculate = defineStore("calculateStore", {
  state: () => ({
    price: 0,
    intermediateData: null,
  }),
  actions: {
    resetPrice() {
      this.price = 0;
    },
    async calculate(body) {
      try {
        const {
          data: { _rawValue },
        } = await opFetch(url, {
          method: "POST",
          body: { data: body },
        });
        if (_rawValue) {
          this.price = _rawValue.price;
          console.log(_rawValue);
          this.intermediateData = _rawValue;
          useSnack({
            show: true,
            type: "success",
            title: "Предварительная стоимость произведена!",
            message: "Цена отображается внизу",
          });
        }
      } catch (error) {
        console.error("Error fetching:", error);
        alert("Произошла ошибка во время запроса!");
      }
    },
  },
});
