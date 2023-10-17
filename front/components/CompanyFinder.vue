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

const str = ref('');
const { companyConfirmed, companySearchMode } = storeToRefs(useConfigStore())

</script>

<style lang="scss" scoped>

</style>
