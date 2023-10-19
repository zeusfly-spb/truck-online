<template>
  <div>
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
    <div
      v-if="companies.length && !companyConfirmed"
    >
      <v-btn
        v-for="item in companies"
        color="#BBDEFB"
        @click="setCompany(item)"
        style="margin-top: .3em"
      >
        {{ item.short_name || '' }}
      </v-btn>
    </div>
  </div>
</template>

<script setup>
import {storeToRefs} from "pinia";
import {useConfigStore} from "~/store/config";
import {useAuthStore} from "~/store/auth";

const { companyConfirmed, companySearchMode } = storeToRefs(useConfigStore());
const { company } = storeToRefs(useAuthStore());
const str = ref('');
const companies = ref([]);
watch(str, val => val.length >= 3 ? find() : companies.value = []);
const setCompany = val => {
  company.value = val;
  companyConfirmed.value = true;
}
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
