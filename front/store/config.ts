import { defineStore } from 'pinia';

const getConfigUrl = 'http://localhost/api/config';

export const useConfigStore = defineStore('config', {
  state: () => ({
    config: [],
    validatorRules: {
      required: value => !!value || 'Обязательно для заполнения'
    }
  }),
  actions: {
    async getConfig() {
      const { data: { _rawValue} } = await useFetchApi(getConfigUrl, {method: 'get'});
      this.config = _rawValue;
    }
  }
});
