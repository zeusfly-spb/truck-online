import { defineStore } from "pinia";

export const useDadataStore = defineStore("dadataStore", {
  state: () => ({
    dadata: [],
    loading: false,
  }),
  actions: {
    setLoading(value) {
      this.loading = value;
    },
    async getDadata(bik) {
      this.setLoading(true);
      try {
        const token = "1f871a72833bf0acbdde9976e17aeb519149480d";
        const serviceUrl =
          "https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/bank";
        const request = {
          query: bik,
        };
        const headers = new Headers();
        headers.set("Authorization", `Token ${token}`);
        headers.set("Content-Type", "application/json");
        const response = await fetch(serviceUrl, {
          method: "post",
          headers,
          body: JSON.stringify(request),
        });
        const responseData = await response.json();
        this.dadata = responseData.suggestions;
        console.log("ssss:", this.dadata);
      } catch (error) {
        console.error;
      }
      this.setLoading(false);
    },
  },
});
