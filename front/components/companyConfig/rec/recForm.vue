<template>
  <v-form>
    <v-row no-gutters>
      <v-col class="mr-3 mb-3">
        <v-text-field
          v-model="data.requisites.corporateAccount"
          label="Кор. Счет"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
        ></v-text-field>
      </v-col>
      <v-col md :cols="12" class="mb-3">
        <v-autocomplete
          v-model="bik"
          label="БИК"
          :items="r"
          item-title="value"
          item-value="bik"
          @update:search="handleInputBik"
          @input="updateBik"
          variant="solo"
          no-data-text="Введите БИК"
        ></v-autocomplete>
      </v-col>
    </v-row>
    <v-row no-gutters>
      <v-col md :cols="12" class="mr-3 mb-3">
        <v-text-field
          v-model="data.requisites.paymentAccount"
          label="Р/счет"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
        ></v-text-field>
      </v-col>
      <v-col md :cols="12" class="mb-3">
        <v-autocomplete
          v-model="bankName"
          label="Название банка"
          @update:search="handleInputBankName"
          @input="updateNameBank"
          item-title="value"
          class="text-body-1"
          :items="dadataStore.dadata"
          variant="solo"
          hide-details="auto"
          no-data-text="Введите название банка"
        ></v-autocomplete>
      </v-col>
    </v-row>
  </v-form>
</template>
<script setup>
import { useDadataStore } from "~/store/companyConfig/dadata";
const dadataStore = useDadataStore();
const bik = ref();
const bankName = ref();
const data = reactive({
  inn: "ИНН организации",
  requisites: {
    corporateAccount: null,
    paymentAccount: "",
  },
});

watch(() => bik.value);

const updateBik = (event) => {
  bik.value = event.target.value;
};

const updateNameBank = (event) => {
  bankName.value = event.target.value;
};

const handleInputBik = async () => {
  await dadataStore.getDadata(bik.value);
  if (dadataStore.dadata.length > 0) {
    bankName.value = dadataStore.dadata[0].data.name.payment;
    data.requisites.corporateAccount =
      dadataStore.dadata[0].data.correspondent_account;
  } else {
    bankName.value = "";
    data.requisites.corporateAccount = "";
  }
};

const handleInputBankName = async () => {
  await dadataStore.getDadata(bankName.value);
  bik.value = dadataStore.dadata[0].data.bic;
  data.requisites.corporateAccount =
    dadataStore.dadata[0].data.correspondent_account;
};

const r = computed(() => {
  if (!dadataStore.dadata || dadataStore.loading) return [];
  return dadataStore.dadata;
});


</script>
<style scoped></style>
