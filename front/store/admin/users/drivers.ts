import _default from "nuxt-icon/dist/module";
import { defineStore } from "pinia";
import { opFetch } from "~/composables/opFetch";

export const useUsersStore = defineStore("userStore", {
  state: () => ({
    users: [],
    loading: false,
  }),
  actions: {
    setLoading(value) {
      this.loading = value;
    },
  async getAllUsers() {

      this.setLoading(true);
      try {
        const {
          data: { _rawValue },
        } = await opFetch("/api/drivers", {
          method: "get",
        });
        this.users = _rawValue;

      } catch (error) {
        console.error(error);
      }
      this.setLoading(false);
    },
  },
});
