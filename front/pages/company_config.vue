<template>
  <div class="bg-white h-100 pt-10 container basic-data">
    <h2 class="text-h2 font-weight-bold mb-6">Основные данные:</h2>
    <h4 class="text-h4 mb-6">{{ data.inn }}</h4>
    <v-tabs
      v-model="tab"
      bg-color="white"
      color="primary"
    >
      <v-tab value="main" class="font-weight-medium text-body-1 text-uppercase ">Общие данные</v-tab>
      <v-tab value="rec" class="font-weight-medium text-body-1 text-uppercase ">Реквизиты</v-tab>
      <v-tab value="cars" class="font-weight-medium text-body-1 text-uppercase ">Машины</v-tab>
      <v-tab value="drivers" class="font-weight-medium text-body-1 text-uppercase ">Водители</v-tab>
      <v-tab value="menegers" class="font-weight-medium text-body-1 text-uppercase ">Менеджеры</v-tab>
    </v-tabs>
    <v-window v-model="tab" class="pt-6 bg-white">
      <v-window-item value="main">
        <v-row no-gutters>
          <v-col md :cols="12" class="mr-3 mb-3">
            <v-text-field v-model="data.main.number" label="Общий номер" class="text-body-1" variant="outlined"
                          hide-details="auto"></v-text-field>
          </v-col>
          <v-col md :cols="12" class="mb-3">
            <v-text-field v-model="data.main.email" label="Общая почта" class="text-body-1" variant="outlined"
                          hide-details="auto"></v-text-field>
          </v-col>
        </v-row>
        <v-row no-gutters>
          <v-col md :cols="12" class="mr-3 mb-3">
            <v-file-input v-model="data.main.rulereglamento.file" label="Устав (скан)" class="text-body-1"
                          variant="outlined" hide-details="auto"></v-file-input>
          </v-col>
          <v-col md :cols="12" class="mb-3">
            <v-text-field label="Реквизиты для договора"
                          v-model="data.main.rulereglamento.dataForContract"
                          class="text-body-1" variant="outlined" hide-details="auto"></v-text-field>
          </v-col>
        </v-row>
        <v-row no-gutters>
          <v-col md :cols="12" class="mr-3 mb-3">
            <v-text-field v-model="data.main.rulereglamento.number" label="Номер документа" class="text-body-1"
                          variant="outlined" hide-details="auto"></v-text-field>
          </v-col>
          <v-col md :cols="12" class="mb-3">
            <v-text-field v-model="data.main.rulereglamento.date" label="Дата документа" class="text-body-1"
                          variant="outlined" hide-details="auto"></v-text-field>
          </v-col>
        </v-row>
        <v-row no-gutters>
          <v-col md :cols="12" class="mr-3 mb-3">
            <v-text-field v-model="data.main.rulereglamento.signatoryPersone" label="Подписант" class="text-body-1"
                          variant="outlined" hide-details="auto"></v-text-field>
          </v-col>
          <v-col md :cols="12" class="mb-3">
            <v-file-input
              v-model="data.main.attorney.file"
              label="Приказ/Решение/Доверенность" class="text-body-1" variant="outlined"
              hide-details="auto"></v-file-input>
          </v-col>
        </v-row>
        <v-row no-gutters>
          <v-col md :cols="12" class="mr-3 mb-3">
            <v-text-field v-model="data.main.attorney.number" label="Номер документа" class="text-body-1"
                          variant="outlined" hide-details="auto"></v-text-field>
          </v-col>
          <v-col md :cols="12" class="mb-3">
            <v-text-field v-model="data.main.attorney.date" label="Дата документа" class="text-body-1"
                          variant="outlined" hide-details="auto"></v-text-field>
          </v-col>
        </v-row>
      </v-window-item>

      <v-window-item value="rec">
        <v-row no-gutters>
          <v-col md :cols="12" class="mr-3 mb-3">
            <v-text-field v-model="data.requisites.bik" label="БИК" class="text-body-1" variant="outlined"
                          hide-details="auto"></v-text-field>
          </v-col>
          <v-col md :cols="12" class="mb-3">
            <v-text-field v-model="data.requisites.bankName" label="Название банка" class="text-body-1"
                          variant="outlined" hide-details="auto"></v-text-field>
          </v-col>
        </v-row>
        <v-row no-gutters>
          <v-col md :cols="12" class="mr-3 mb-3">
            <v-text-field v-model="data.requisites.corporateAccount" label="Кор. Счет" class="text-body-1"
                          variant="outlined" hide-details="auto"></v-text-field>
          </v-col>
          <v-col md :cols="12" class="mb-3">
            <v-text-field v-model="data.requisites.paymentAccount" label="Р/счет" class="text-body-1" variant="outlined"
                          hide-details="auto"></v-text-field>
          </v-col>
        </v-row>
      </v-window-item>

      <v-window-item value="cars">
        <v-row no-gutters class="align-center">
          <v-col md :cols="12" class="mr-3 mb-3">
            <v-select v-model="data.cars.types.value"
                      :items="data.cars.types.list" theme="light"
                      label="Тип машины" class="text-body-1" variant="outlined" hide-details="auto"></v-select>
          </v-col>
          <v-col md="auto" :cols="12" class="mb-3">
            <v-btn color="error" class="text-body-2 text-uppercase rounded font-weight-bold elevation-0">Убрать</v-btn>
          </v-col>
        </v-row>
        <v-row no-gutters>
          <v-col md :cols="12" class="mr-3 mb-3">
            <v-select label="Право использование" v-model="data.cars.rightOfUse.value"
                      :items="data.cars.rightOfUse.list" class="text-body-1" variant="outlined"
                      hide-details="auto"></v-select>
          </v-col>
          <v-col md :cols="12" class="mb-3">
            <v-text-field v-model="data.cars.loadСapacity" label="Грузоподъемность (кг)" class="text-body-1"
                          variant="outlined" hide-details="auto"></v-text-field>
          </v-col>
        </v-row>
        <v-row no-gutters>
          <v-col class="mb-3">
            <v-file-input label="Скан СТС на тягач и полуприцеп"
                          v-model="data.cars.sts.file" class="text-body-1" variant="outlined"
                          hide-details="auto"></v-file-input>
          </v-col>
        </v-row>
        <v-row no-gutters>
          <v-col md :cols="12" class="mr-3 mb-3">
            <v-text-field v-model="data.cars.sts.number" label="Номер документа" class="text-body-1" variant="outlined"
                          hide-details="auto"></v-text-field>
          </v-col>
          <v-col md :cols="12" class="mb-6">
            <v-text-field v-model="data.cars.sts.date" label="Дата документа" class="text-body-1" variant="outlined"
                          hide-details="auto"></v-text-field>
          </v-col>
        </v-row>
        <v-row no-gutters>
          <v-col class="">
            <v-btn color="primary" class="text-body-2 text-uppercase rounded font-weight-bold elevation-0">Добавить
              машину
            </v-btn>
          </v-col>
        </v-row>
      </v-window-item>
      <v-window-item value="drivers">
        <v-row no-gutters class="align-center">
          <v-col md :cols="12" class="mr-3 mb-3">
            <v-autocomplete
              v-model="data.drivers.fullName.value" :items="data.drivers.fullName.list"
              auto-select-first
              density="comfortable"
              theme="light"
              item-props
              menu-icon=""
              append-inner-icon="mdi-magnify"
              label="ФИО"
              class="text-body-1" variant="outlined" hide-details="auto"
            ></v-autocomplete>
          </v-col>
          <v-col md="auto" :cols="12" class="mb-3">
            <v-btn color="error" class="text-body-2 text-uppercase rounded font-weight-bold elevation-0">Убрать</v-btn>
          </v-col>
        </v-row>
        <v-row no-gutters>
          <v-col md :cols="12" class="mr-3 mb-3">
            <v-text-field v-model="data.drivers.email" label="E-mail" class="text-body-1" variant="outlined"
                          hide-details="auto"></v-text-field>
          </v-col>
          <v-col md :cols="12" class="mb-3">
            <v-text-field v-model="data.drivers.phone" label="Телефон" class="text-body-1" variant="outlined"
                          hide-details="auto"></v-text-field>
          </v-col>
        </v-row>
        <v-row no-gutters>
          <v-col md :cols="12" class="mb-3">
            <v-text-field v-model="data.drivers.password" label="Пароль" class="text-body-1" variant="outlined"
                          hide-details="auto"></v-text-field>
          </v-col>
        </v-row>
        <v-row no-gutters>
          <v-col md :cols="12" class="mb-3 mr-3">
            <v-file-input v-model="data.drivers.paperFile" label="Скан паспорта" class="text-body-1" variant="outlined"
                          hide-details="auto"></v-file-input>
          </v-col>
          <v-col md :cols="12" class="mb-3">
            <v-file-input v-model="data.drivers.driveLicense.file" label="В/У водителя" class="text-body-1"
                          variant="outlined" hide-details="auto"></v-file-input>
          </v-col>
        </v-row>
        <v-row no-gutters>
          <v-col md :cols="12" class="mr-3 mb-3">
            <v-text-field v-model="data.drivers.driveLicense.number" label="Номер документа" class="text-body-1"
                          variant="outlined" hide-details="auto"></v-text-field>
          </v-col>
          <v-col md :cols="12" class="mb-6">
            <v-text-field v-model="data.drivers.driveLicense.date" label="Дата документа" class="text-body-1"
                          variant="outlined" hide-details="auto"></v-text-field>
          </v-col>
        </v-row>
        <v-row no-gutters>
          <v-col md :cols="12">
            <v-btn color="primary" class="text-body-2 text-uppercase rounded font-weight-bold elevation-0">Добавить
              водителя
            </v-btn>
          </v-col>
        </v-row>
      </v-window-item>
      <v-window-item value="menegers">
        <v-row no-gutters class="align-center">
          <v-col md :cols="12" class="mr-3 mb-3">
            <v-autocomplete
              v-model="data.manager.fullName.value" :items="data.manager.fullName.list"
              auto-select-first
              density="comfortable"
              theme="light"
              item-props
              menu-icon=""
              append-inner-icon="mdi-magnify"
              label="ФИО"
              class="text-body-1" variant="outlined" hide-details="auto"
            ></v-autocomplete>
          </v-col>
          <v-col md="auto" :cols="12" class="mb-3">
            <v-btn color="error" class="text-body-2 text-uppercase rounded font-weight-bold elevation-0">Убрать</v-btn>
          </v-col>
        </v-row>
        <v-row no-gutters>
          <v-col md :cols="12" class="mr-3 mb-3">
            <v-text-field v-model="data.manager.email" label="E-mail" class="text-body-1" variant="outlined"
                          hide-details="auto"></v-text-field>
          </v-col>
          <v-col md :cols="12" class="mb-3">
            <v-text-field label="Телефон"
                          v-model="data.manager.phone" class="text-body-1" variant="outlined"
                          hide-details="auto"></v-text-field>
          </v-col>
        </v-row>
        <v-row no-gutters>
          <v-col md :cols="12">
            <v-btn color="primary" class="text-body-2 text-uppercase rounded font-weight-bold elevation-0">Добавить
              менеджера
            </v-btn>
          </v-col>
        </v-row>
      </v-window-item>
    </v-window>
  </div>
</template>
<script setup>
import {ref} from 'vue';

const tab = ref('main')
const data = reactive({
  inn: 'ИНН организации',
  main: {
    number: '',
    email: '',
    rulereglamento: {
      file: '',
      dataForContract: '',
      number: '',
      date: '',
      signatoryPersone: ''
    },
    attorney: {
      file: '',
      number: '',
      date: ''
    }

  },
  requisites: {
    bik: '',
    bankName: '',
    corporateAccount: '',
    paymentAccount: ''
  },
  cars: {
    types: {
      value: null,
      list: [1, 2, 3]
    },
    rightOfUse: {
      value: null,
      list: [1],
    },
    loadСapacity: '',
    sts: {
      file: '',
      number: '',
      date: ''
    },
  },
  drivers: {
    fullName: {
      value: null,
      list: [1]
    },
    email: '',
    phone: '',
    password: '',
    paperFile: '',
    driveLicense: {
      file: '',
      number: '',
      date: ''
    },
  },
  manager: {
    fullName: {
      value: null,
      list: [1]
    },
    email: '',
    phone: ''
  }
})
</script>
<style lang='scss' scoped>
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
