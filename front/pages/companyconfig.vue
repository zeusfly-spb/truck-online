<template>
  <div class="h-100 pt-10 container basic-data">
    <h2 class="text-h2 font-weight-bold mb-6">Основные данные:</h2>
    <h4 class="text-h4 mb-6">{{ data.inn }}</h4>
    <v-tabs v-model="tab">
      <v-tab value="main" class="font-weight-medium text-body-1 text-uppercase"
        >Общие данные</v-tab
      >
      <v-tab value="rec" class="font-weight-medium text-body-1 text-uppercase"
        >Реквизиты</v-tab
      >
      <v-tab value="cars" class="font-weight-medium text-body-1 text-uppercase"
        >Машины</v-tab
      >
      <v-tab
        value="drivers"
        class="font-weight-medium text-body-1 text-uppercase"
        >Водители</v-tab
      >
      <v-tab
        value="managers"
        class="font-weight-medium text-body-1 text-uppercase"
        >Менеджеры</v-tab
      >
    </v-tabs>
    <v-window v-model="tab" class="pt-6">
      <v-window-item value="main">
        <v-row no-gutters>
          <v-col md :cols="12" class="mr-3 mb-3">
            <v-text-field
              v-model="data.main.number"
              label="Общий номер"
              class="text-body-1"
              variant="outlined"
              hide-details="auto"
            >
            </v-text-field>
          </v-col>
          <v-col md :cols="12" class="mb-3">
            <v-text-field
              v-model="data.main.email"
              label="Общая почта"
              class="text-body-1"
              variant="outlined"
              hide-details="auto"
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row no-gutters>
          <v-col md :cols="12" class="mr-3 mb-3">
            <v-file-input
              v-model="data.main.rulereglamento.file"
              label="Устав (скан)"
              class="text-body-1"
              variant="outlined"
              hide-details="auto"
            ></v-file-input>
          </v-col>
          <v-col md :cols="12" class="mb-3">
            <v-text-field
              label="Реквизиты для договора"
              v-model="data.main.rulereglamento.dataForContract"
              class="text-body-1"
              variant="outlined"
              hide-details="auto"
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row no-gutters>
          <v-col md :cols="12" class="mr-3 mb-3">
            <v-text-field
              v-model="data.main.rulereglamento.number"
              label="Номер документа"
              class="text-body-1"
              variant="outlined"
              hide-details="auto"
            ></v-text-field>
          </v-col>
          <v-col md :cols="12" class="mb-3">
            <v-text-field
              v-model="data.main.rulereglamento.date"
              label="Дата документа"
              class="text-body-1"
              variant="outlined"
              hide-details="auto"
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row no-gutters>
          <v-col md :cols="12" class="mr-3 mb-3">
            <v-text-field
              v-model="data.main.rulereglamento.signatoryPersone"
              label="Подписант"
              class="text-body-1"
              variant="outlined"
              hide-details="auto"
            ></v-text-field>
          </v-col>
          <v-col md :cols="12" class="mb-3">
            <v-file-input
              v-model="data.main.attorney.file"
              label="Приказ/Решение/Доверенность"
              class="text-body-1"
              variant="outlined"
              hide-details="auto"
            ></v-file-input>
          </v-col>
        </v-row>
        <v-row no-gutters>
          <v-col md :cols="12" class="mr-3 mb-3">
            <v-text-field
              v-model="data.main.attorney.number"
              label="Номер документа"
              class="text-body-1"
              variant="outlined"
              hide-details="auto"
            ></v-text-field>
          </v-col>
          <v-col md :cols="12" class="mb-3">
            <v-text-field
              v-model="data.main.attorney.date"
              label="Дата документа"
              class="text-body-1"
              variant="outlined"
              hide-details="auto"
            ></v-text-field>
          </v-col>
        </v-row>
      </v-window-item>
      <v-window-item value="rec">
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
      </v-window-item>

      <v-window-item value="cars">
        <cars-form />
      </v-window-item>
      <v-window-item value="drivers">
        <driver-form />
      </v-window-item>
      <v-window-item value="managers">
        <managers-form />
      </v-window-item>
    </v-window>
  </div>
</template>
<script setup>
import driverForm from "~/components/companyConfig/drivers/driverForm.vue";
import carsForm from "~/components/companyConfig/cars/carsForm.vue";
import managersForm from "~/components/companyConfig/managers/managersForm.vue";
const tab = ref("main");
const data = reactive({
  inn: "ИНН организации",
  main: {
    number: "",
    email: "",
    rulereglamento: {
      file: "",
      dataForContract: "",
      number: "",
      date: "",
      signatoryPersone: "",
    },
    attorney: {
      file: "",
      number: "",
      date: "",
    },
  },
  requisites: {
    bik: "",
    bankName: "",
    corporateAccount: "",
    paymentAccount: "",
  },
});
</script>

<style lang="scss" scoped>
.basic-data {
  :deep(.v-file-input) {
    position: relative;
  }
  :deep(.v-file-input .v-input__prepend) {
    position: absolute;
    left: 12px;
    top: 16px;
  }
  :deep(.v-file-input .v-field-label) {
    margin-left: 40px;
  }
  :deep(.v-file-input .v-field__input) {
    margin-left: 40px;
  }
}
</style>
