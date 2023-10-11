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
        if (response.status._rawValue === "success") {
          this.price = response.data._rawValue.data.price;
        }
      } catch (error) {
        console.error("Error fetching:", error);
        alert("Произошла ошибка во время запроса!");
      }
    },
  },
});
