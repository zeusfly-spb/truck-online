import {defineStore} from 'pinia';
import {opFetch} from "~/composables/opFetch";

export const useConfigStore = defineStore('config', {
	state: () => ({
		config: [],
		phoneConfirmCode: '9898',
		newEmailConfirm: false,
		emailConfirmCode: '',
		confirmedEmailConfirm: false,
		confirmation: {},
		companyConfirmed: false,
		phoneConfirmed: false,
		emailConfirmed: false,
	}),
	actions: {
		async setValue({key, value}) {
			this[key] = value;
		},
		async getConfig() {
			const {data: {_rawValue}} = await opFetch('/config', {method: 'get'});
			this.config = _rawValue;
		},
		async getEmailConfirm(param) {
			const res =
				await opFetch('/confirmation/get_email_confirm', {method: 'post', body: {email: param}});
			if (!res) {
				return;
			}
			const {data: {_rawValue: {confirmation, fresh}}} = res;
			this.confirmation = confirmation;
			if (confirmation.confirmed) {
				this.emailConfirmed = true;
			}
			this.emailConfirmCode = confirmation.code;
			this.newEmailConfirm = fresh;
		},
		async markEmailConfirmation(param) {
			console.log(param);
			const result =
				await opFetch('/confirmation/mark_email_confirm', {method: 'post', body: {email: param}});
			if (result) {
				this.emailConfirmed = true;
			}
		}
	}
});
