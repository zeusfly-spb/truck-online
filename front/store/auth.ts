import {defineStore} from 'pinia';

//const detailsUrl = URI+'details';
//const registerUrl = URI+'auth/register';/
//const loginUrl = URI+'auth/login';
//const getCompanyByInnUrl = URI+'company/find_by_inn';

// const detailsUrl = 'http://localhost/api/details';
// const registerUrl = 'http://localhost/api/auth/register';
// const loginUrl = 'http://localhost/api/auth/login';
// const getCompanyByInnUrl = 'http://localhost/api/company/find_by_inn';

const detailsUrl = 'http://217.197.237.54/api/details';
const registerUrl = 'http://217.197.237.54/api/auth/register';
const loginUrl = 'http://217.197.237.54/api/auth/login';
const getCompanyByInnUrl = 'http://217.197.237.54/api/company/find_by_inn';

interface UserPayloadInterface {
	username: string;
	password: string;
}

interface UserRegisterPayloadInterface {
	username: string;
	password: string;
	passwordConfirm: string;
	company_id: bigint
}

export const useAuthStore = defineStore('auth', {
	state: () => ({
		dialogTitle: '',
		dialogMode: '',
		dialogText: '',
		dialog: false,
		authenticated: false,
		loading: false,
		token: null,
		user: null,
		company: null,
		companyConfirmed: false,
		emailConfirmed: false,
		phoneConfirmed: false,
	}),
	actions: {
		setValue({key, value}) {
			this[key] = value;
		},
		async getUserDetails() {
			const res = await useFetchApi(detailsUrl);
			// @ts-ignore
			this.user = res.data._rawValue;
			if (this.user) {
				this.authenticated = true;
			}
		},
		async registerUser({username, password, passwordConfirm, company_id}: UserRegisterPayloadInterface) {
			const {data, pending}: any = await useFetchApi(registerUrl, {
				method: 'post',
				body: {username, password, password_confirmation: passwordConfirm, company_id},
			});
			this.loading = pending;
			const {_rawValue: {success}} = data;
			return success;
		},
		async authenticateUser({username, password}: UserPayloadInterface) {
			const {data, pending}: any = await useFetchApi(loginUrl, {
				method: 'post',
				body: {username, password},
			});
			this.loading = pending;
			const {_rawValue: {success, data: {token}}} = data;
			if (success) {
				this.token = token;
				const token_cookie = useCookie('online_port_token');
				token_cookie.value = token;
				await this.getUserDetails();
			}
		},
		logUserOut() {
			const token_cookie = useCookie('online_port_token');
			this.authenticated = false;
			this.token = null;
			token_cookie.value = null;
		},
		async getCompanyByInn(inn) {
			const res = await useFetchApi(getCompanyByInnUrl, {method: 'post', body: {inn}});
			this.company = res.data._rawValue.company;
		}

	},
});
