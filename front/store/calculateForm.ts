import { defineStore } from "pinia";
import { opFetch } from "~/composables/opFetch";
const url = "orders/store";
export const useCalculate = defineStore("calculateStore", {
  state: () => ({
    price: null,
  }),
  actions: {
    async calculate(body) {
      const response = await opFetch(url, {
        method: "POST",
        body: { data: body },
        onRequest({ request, options }) {
          console.log("Запрос отправлен:", request);
        },
        onResponse({ response, options }) {
          console.log("ОТВЕТ:", response);
          if (response._status === 200) {
            this.price = response._data.data.price;
            console.log("New price:", this.price);
          } else {
            alert("Что-то не так с созданием заказа!");
          }
        },
      });
    },
  },
});
