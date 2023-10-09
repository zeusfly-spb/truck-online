import _default from "nuxt-icon/dist/module";
import { defineStore } from "pinia";
import { opFetch } from "~/composables/opFetch";

export const useRolesStore = defineStore("rolesStore", {
  state: () => ({
    roles: [],
    loading: false,
  }),
  actions: {
    setLoading(value) {
      this.loading = value;
    },
  async getAllRoles() {
    console.log("fdv");
      this.setLoading(true);
      try {
        const {
          data: { _rawValue },
        } = await opFetch("/roles", {
          method: "get",
        });
        this.roles = _rawValue;
        
      } catch (error) {
        console.error(error);
      }
      this.setLoading(false);
    },
  },
});
