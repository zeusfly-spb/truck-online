import {defineStore} from 'pinia';
import details from "~/details.json";

export const useTranslatorStore = defineStore('translator', {
  state: () => ({
    details: details
  }),
  actions: {
    translate(word, mod) {
      const module = this[mod];
      const record = module.find(item => item.original === word);
      if (record) {
        return record.translation;
      }
      return word;
    }
  }
});
