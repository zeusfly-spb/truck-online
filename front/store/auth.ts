import { defineStore } from 'pinia';

interface UserPayloadInterface {
  username: string;
  password: string;
}
export const useAuthStore = defineStore('auth', {
  state: () => ({
    authenticated: false,
    loading: false,
    token: null,
    user: null,
  }),
  actions: {
    async getUserDetails() {
      const res = await useFetchApi('http://localhost/api/details');
      // @ts-ignore
      this.user = res.data._rawValue;
      this.user ? this.authenticated = true : null;
    },
    async authenticateUser({ username, password }: UserPayloadInterface) {
      const { data, pending }: any = await useFetchApi('http://localhost/api/auth/login', {
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
  },
});
