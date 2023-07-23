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
  }),
  actions: {
    async authenticateUser({ username, password }: UserPayloadInterface) {
      const { data, pending }: any = await useFetchApi('http://localhost/api/auth/login', {
        method: 'post',
        headers: { 'Content-Type': 'application/json' },
        body: { username, password },
      });
      this.loading = pending;
      const { _rawValue : { success, data: { token } } } = data;
      if (success) {
        this.token = token;
        this.authenticated = true;
      }
    },
    logUserOut() {
      const token = useCookie('token'); // useCookie new hook in nuxt 3
      this.authenticated = false; // set authenticated  state value to false
      token.value = null; // clear the token cookie
    },
  },
});
