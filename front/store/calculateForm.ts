import { defineStore } from "pinia";
import { opFetch } from "~/composables/opFetch";
const url = "orders/store";

export const useCalculate = defineStore("calculateStore", {
  state: () => ({
    price: null,
  }),
  actions: {
    async calculate(body) {
      try {
        const response = await opFetch(url, {
          method: "POST",
          body: { data: body },
        });

        console.log("Response:", response);

        if (response.status._rawValue === "success") {
          this.price = response.data._rawValue.data.price;
          console.log("New price:", this.price);
        } else {
          alert("Что-то не так с созданием заказа!");
        }
      } catch (error) {
        console.error("Error fetching:", error);
        alert("Произошла ошибка во время запроса!");
      }
    },
  },
});
