import { defineStore } from "pinia";
import { opFetch } from "~/composables/opFetch";

export const useConfigStore = defineStore("config", {
  state: () => ({
    config: [],
    phoneConfirmCode: "",
    emailConfirmCode: "",
    newPhoneConfirm: false,
    newEmailConfirm: false,
    confirmedEmailConfirm: false,
    confirmedPhoneConfirm: false,
    emailConfirmation: {},
    phoneConfirmation: {},
    companyConfirmed: false,
    phoneConfirmed: false,
    emailConfirmed: false,
    activePanel: null,
    currentRoute: {},
  }),
  actions: {
    async setValue({ key, value }) {
      this[key] = value;
    },
    async getConfig() {
      const {
        data: { _rawValue },
      } = await opFetch("/config", { method: "get" });
      this.config = _rawValue;
    },
    async getPhoneConfirm(param) {
      const res = await opFetch("/confirmation/get_phone_confirm", {
        method: "post",
        body: { phone: param },
      });
      if (!res) {
        return;
      }
      const {
        data: {
          _rawValue: { confirmation, fresh, error },
        },
      } = res;
      if (error) {
        useSnack({
          show: true,
          type: "error",
          title: "Ошибка подтверждения",
          message: error,
        });
        return;
      } else {
        this.phoneConfirmation = confirmation;
        if (confirmation.confirmed) {
          this.phoneConfirmed = true;
          return;
        }
        this.phoneConfirmCode = confirmation.code;
        this.newPhoneConfirm = fresh;
      }
    },
    async getEmailConfirm(param) {
      const res = await opFetch("/confirmation/get_email_confirm", {
        method: "post",
        body: { email: param },
      });
      if (!res) {
        return;
      }
      const {
        data: {
          _rawValue: { confirmation, fresh, error },
        },
      } = res;
      if (error) {
        useSnack({
          show: true,
          type: "error",
          title: "Ошибка подтверждения",
          message: error,
        });
        return;
      } else {
        this.emailConfirmation = confirmation;
        if (confirmation.confirmed) {
          this.emailConfirmed = true;
          return;
        }
        this.emailConfirmCode = confirmation.code;
        this.newEmailConfirm = fresh;
      }
    },
    async markEmailConfirmation(param) {
      console.log(param);
      const result = await opFetch("/confirmation/mark_email_confirm", {
        method: "post",
        body: { email: param },
      });
      if (result) {
        this.emailConfirmed = true;
      }
    },
    async markPhoneConfirmation(param) {
      const result = await opFetch("/confirmation/mark_phone_confirm", {
        method: "post",
        body: { phone: param },
      });
      if (result) {
        this.phoneConfirmed = true;
      }
    },
  },
});
