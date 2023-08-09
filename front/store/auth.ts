import { defineStore } from 'pinia';

const detailsUrl = URI+'details';
const registerUrl = URI+'auth/register';
const loginUrl = URI+'auth/login';
const getCompanyByInnUrl = URI+'company/find_by_inn';

// const detailsUrl = 'http://217.197.237.54/api/details';
// const registerUrl = 'http://217.197.237.54/api/auth/register';
// const loginUrl = 'http://217.197.237.54/api/auth/login';

interface UserPayloadInterface {
  username: string;
  password: string;
}
interface UserRegisterPayloadInterface {
  username: string;
  password: string;
  passwordConfirm: string;
  inn: string;
  value: string;
}

export const useAuthStore = defineStore('auth', {
  state: () => ({
    authenticated: false,
    loading: false,
    token: null,
    user: null,
    innInfo: null
  }),
  actions: {
    removeInnInfo() {
      this.innInfo = null;
    },
    async getUserDetails() {
      const res = await useFetchApi(detailsUrl);
      // @ts-ignore
      this.user = res.data._rawValue;
      if (this.user) {
        this.authenticated = true;
      }
    },
    async registerUser({ username, password, passwordConfirm, inn, value }: UserRegisterPayloadInterface) {
      const { data, pending }: any = await useFetchApi(registerUrl, {
        method: 'post',
        body: { username, password, password_confirmation: passwordConfirm, inn, value },
      });
      this.loading = pending;
      const { _rawValue : { success } } = data;
      return success;
    },
    async authenticateUser({ username, password }: UserPayloadInterface) {
      const { data, pending }: any = await useFetchApi(loginUrl, {
        method: 'post',
        body: { username, password },
      });
      this.loading = pending;
      const { _rawValue : { success, data: { token } } } = data;
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
      const res = await useFetchApi(getCompanyByInnUrl, { method: 'post', body: { inn }});
      console.log('RES =' + JSON.stringify(res));
      // const res = await postDadata({query: inn});
      // this.innInfo = res.data._rawValue.suggestions[0].value;
    }
  },
});
