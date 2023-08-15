import {defineStore} from 'pinia';

const getConfigUrl = 'http://localhost/api/config';

export const useConfigStore = defineStore('config', {
	state: () => ({
		config: [],
		phoneConfirmCode: '9898',
		emailConfirmCode: '9898',
	}),
	actions: {
		async getConfig() {
			const {data: {_rawValue}} = await useFetchApi(getConfigUrl, {method: 'get'});
			this.config = _rawValue;
		},
	},
	getters: {
		baseUrl: () => process.env.NUXT_PUBLIC_API_BASE,
	}
});
