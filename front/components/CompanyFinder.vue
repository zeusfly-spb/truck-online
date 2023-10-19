<template>
  <v-text-field
    v-model="str"
    :readonly="companyConfirmed"
    hide-details
    label="Начните вводить название..."
    maxLength="12"
    placeholder='ООО "РиК"'
  >
    <template
      v-if="!companyConfirmed"
      v-slot:append-inner
    >
      <v-icon
        @click="companySearchMode = 'inn'"
        color="blue"
        icon="mdi-file-find"
        style="cursor: pointer"
        title="Найти компанию по ИНН"
      />
    </template>
  </v-text-field>
</template>

<script setup>
import {storeToRefs} from "pinia";
import {useConfigStore} from "~/store/config";

const { companyConfirmed, companySearchMode } = storeToRefs(useConfigStore());
const str = ref('');
const companies = ref([]);
watch(str, val => val.length >= 3 ? find() : null);
const find = async () => {
  const {data: { _rawValue }} = await opFetch('/company/find_by_str', {
    method: 'POST',
    body: {
      str: str.value
    }
  });
  companies.value = _rawValue;
};

</script>

<style lang="scss" scoped>

</style>
