<template>
  <v-form>
    <v-row no-gutters>
      <v-col md :cols="12" class="mr-3 mb-3">
        <v-text-field
          v-model="data.requisites.bik"
          label="БИК"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
        ></v-text-field>
      </v-col>
      <v-col md :cols="12" class="mb-3">
        <v-text-field
          v-model="data.requisites.bankName"
          label="Название банка"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
        ></v-text-field>
      </v-col>
    </v-row>
    <v-row no-gutters>
      <v-col md :cols="12" class="mr-3 mb-3">
        <v-text-field
          v-model="data.requisites.corporateAccount"
          label="Кор. Счет"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
        ></v-text-field>
      </v-col>
      <v-col md :cols="12" class="mb-3">
        <v-text-field
          v-model="data.requisites.paymentAccount"
          label="Р/счет"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
        ></v-text-field>
      </v-col>
    </v-row>
  </v-form>
</template>
<script setup>
const data = reactive({
  inn: "ИНН организации",
  requisites: {
    bik: "",
    bankName: "",
    corporateAccount: "",
    paymentAccount: "",
  },
});
</script>
<style scoped></style>
