import { defineStore } from 'pinia';
const configURI = '/api/get_config'
// const configURL = process.env.API_BASE_URL + configURI
const configURL = 'http://localhost' + configURI

export const useConfigStore = defineStore('config', {
  state: () => ({
    config: {}
  }),
  actions: {
    async getConfig() {
      const { data } = await useFetchApi(configURL);
      this.config = data._rawValue;
    }
  }
});
