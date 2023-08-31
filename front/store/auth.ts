import {defineStore} from 'pinia';
import {opFetch} from "~/composables/opFetch";

const detailsUrl = '/details';
const registerUrl = '/auth/register';
const loginUrl = '/auth/login';
const getCompanyByInnUrl = '/company/find_by_inn';

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
    loading: false,
    token: null,
    user: null,
    company: null,
    loaded: true,
    companyInfo: null,
    autostart: true,
    authDialog: false,
    registerDialog: false
  }),
  actions: {
    setValue({key, value}) {
      this[key] = value;
    },
    async getUserDetails() {
      const res = await opFetch(detailsUrl);
      // @ts-ignore
      this.user = res.data._rawValue;
    },
    async registerUser({username, password, passwordConfirm, company_id}: UserRegisterPayloadInterface) {
      const {data, pending}: any = await opFetch(registerUrl, {
        method: 'post',
        body: {username, password, password_confirmation: passwordConfirm, company_id},
      });
      this.loading = pending;
      const {_rawValue: {success}} = data;
      return success;
    },
    async authenticateUser({username, password}: UserPayloadInterface) {
      const {data, pending}: any = await opFetch(loginUrl, {
        method: 'post',
        body: {username, password},
      });
      this.loading = pending;
      const {_rawValue: {success, data: {token, user}}} = data;
      if (success) {
        this.token = token;
        const token_cookie = useCookie('online_port_token');
        token_cookie.value = token;
        this.user = user;
      }
    },
    async logUserOut() {
      this.autostart = false;
      const token_cookie = useCookie('online_port_token');
      token_cookie.value = null;
      this.user = null;
      this.token = null;
      await navigateTo('/')
    },
    async getCompanyByInn(inn) {
      const res = await opFetch(getCompanyByInnUrl, {method: 'post', body: {inn}});
      this.company = res.data._rawValue.company;
    },
    async getCompanyInfo() {
      const inn = this.user.company.inn || null;
      if (!inn) {
        console.log('Не определен инн компании пользователя');
        return;
      }
      console.log('Retrieving by :' + inn);
      const {data: {_rawValue}} = await opFetch('/dadata/info', {method: 'post', body: {inn}});
      // this.companyInfo = _rawValue && _rawValue[0] && _rawValue[0].data || null;
      console.log('From store: ' + _rawValue);
    }
  },
  getters: {
    authenticated: state => !!state.user,
    userName: state => state.user && state.user.first_name || state.user && state.user.email
  }
});
