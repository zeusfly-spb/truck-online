import { defineStore } from "pinia";
import { opFetch } from "~/composables/opFetch";
const url = "orders/store";

export const useCalculate = defineStore("calculateStore", {
  state: () => ({
    price: null,
  }),
  actions: {
    resetPrice() {
      this.price = null;
    },
    async calculate(body) {
      try {
        const response = await opFetch(url, {
          method: "POST",
          body: { data: body },
        });

        console.log("Response:", response);

        if (response.status._rawValue === "success") {
          console.log("New price:", this.price);
          this.price = response._rawValue.data.price;
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
