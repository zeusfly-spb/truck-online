<template>
  <v-row class="mb-3" justify="end">
    <v-col>
      <v-btn @click="changeShowFormRec">Добавить</v-btn>
    </v-col>
  </v-row>
  <v-form @submit.prevent="addBank" v-if="data.showFormRec">
    <v-row no-gutters>
      <v-col md :cols="12" class="mr-3 mb-3">
        <v-text-field v-model="data.requisites.corporateAccount" label="Кор. Счет" class="text-body-1" variant="outlined"
          hide-details="auto" :rules="[rules.corporateAccount]"></v-text-field>
      </v-col>
      <v-col class="mb-3">
        <v-autocomplete
          v-model="bik"
          label="БИК"
          :items="allDadata"
          item-title="data.bic"
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
        <v-text-field v-model="data.requisites.paymentAccount" label="Р/счет" class="text-body-1" variant="outlined"
          hide-details="auto" :rules="[rules.paymentAccount]"></v-text-field>
      </v-col>
      <v-col md :cols="12" class="mb-3">
        <v-autocomplete v-model="bankName" label="Название банка" @update:search="handleInputBankName"
          @input="updateNameBank" item-title="value" class="text-body-1" :items="dadataStore.dadata" hide-details="auto"
          no-data-text="Введите название банка" :rules="[rules.required]"></v-autocomplete>
      </v-col>
    </v-row>
    <v-btn color="primary" class="text-body-2 text-uppercase rounded font-weight-bold elevation-0" type="submit">Добавить
      реквизиты
    </v-btn>
  </v-form>
  <recsTable />
</template>
<script setup>
import recsTable from "~/components/companyconfig/rec/recsTable";
import { useDadataStore } from "~/store/companyConfig/dadata";
import { useRecsStore } from "~/store/companyConfig/rec";
const dadataStore = useDadataStore();
const recStore = useRecsStore();

const bik = ref();
const bankName = ref();
const data = reactive({
  showFormRec: false,
  inn: "ИНН организации",
  requisites: {
    corporateAccount: null,
    paymentAccount: "",
  },
  dadata: [],
});

const rules = {
  required: (value) => !!value || "Поле обязательно для заполнения",
  bic: (value) => String(value).length === 9 || "Номер машины должен быть длиной 9 знаков",
  corporateAccount: (value) => String(value).length === 20 || "Номер машины должен быть длиной 20 знаков",
  paymentAccount: (value) => String(value).length === 20 || "Номер машины должен быть длиной 20 знаков",
};
const changeShowFormRec = () => {
  data.showFormRec = !data.showFormRec;
};
watch(() => bik.value);

const updateBik = (event) => {
  bik.value = event.target.value;
};

const addBank = async () => {

  const formdata = new FormData();
  formdata.append("bik", bik.value);
  formdata.append("bank_name", bankName.value);
  formdata.append("account", data.requisites.paymentAccount);
  formdata.append("k_account", data.requisites.corporateAccount);
  const validate =
    bik.value &&
    bankName.value &&
    data.requisites.paymentAccount &&
    data.requisites.corporateAccount
  if (validate) {
    await recStore.addNewRec(formdata);
    resetData();
    changeShowFormRec();
  } else {
    useSnack({
      show: true,
      type: "error",
      title: "Новый реквизит не добавлен!",
      message: "Проверьте все ли поля заполнены",
    });
  }
}
async function resetData() {
  bik.value = null;
  bankName.value = null;
  data.requisites.paymentAccount = null;
  data.requisites.corporateAccount = null;
}
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
  console.log(dadataStore.dadata[0]);
  bik.value = dadataStore.dadata[0].data.bic;
  data.requisites.corporateAccount =
    dadataStore.dadata[0].data.correspondent_account;
};

const allDadata = computed(() => {
  if (!dadataStore.dadata || dadataStore.loading) return [];
  return dadataStore.dadata;
});
</script>
<style scoped></style>
