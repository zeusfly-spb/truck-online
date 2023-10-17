<template>
  <v-form @submit.prevent="addDriver">
    <v-row no-gutters class="align-center">
      <v-col md :cols="12" class="mr-3 mb-3 mt-1" style="display: flex">
        <v-text-field
          v-model="data.drivers.first_name.value"
          :items="data.drivers.first_name.list"
          auto-select-first
          density="comfortable"
          theme="light"
          item-props
          menu-icon=""
          label="ИМЯ"
          class="mt-1 text-body-1"
          variant="outlined"
          hide-details="auto"
          style="margin-right: 10px"
          :rules="[rules.required]"
        ></v-text-field>
        <v-text-field
          v-model="data.drivers.middle_name.value"
          :items="data.drivers.middle_name.list"
          auto-select-first
          density="comfortable"
          theme="light"
          item-props
          menu-icon=""
          label="ФАМИЛИЯ"
          class="mt-1 text-body-1"
          variant="outlined"
          hide-details="auto"
          style="margin-right: 10px"
          :rules="[rules.required]"
        ></v-text-field>
        <v-text-field
          v-model="data.drivers.last_name.value"
          :items="data.drivers.last_name.list"
          auto-select-first
          density="comfortable"
          theme="light"
          item-props
          menu-icon=""
          label="ОТЧЕСТВО"
          class="mt-1 text-body-1"
          variant="outlined"
          hide-details="auto"
          :rules="[rules.required]"
        ></v-text-field>
      </v-col>
    </v-row>
    <v-row no-gutters>
      <v-col md :cols="12" class="mr-3 mb-3">
        <v-text-field
          v-model="data.drivers.email"
          label="E-mail"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
          :rules="[rules.required]"
        ></v-text-field>
      </v-col>
      <v-col md :cols="12" class="mb-3">
        <v-text-field
          v-model="data.drivers.phone"
          label="Телефон"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
          :rules="[rules.phoneLength]"
          placeholder="900-000-00-00"
        ></v-text-field>
      </v-col>
    </v-row>
    <v-row no-gutters>
      <v-col md :cols="12" class="mb-3">
        <v-text-field
          v-model="data.drivers.password"
          label="Пароль"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
          type="password"
          :rules="[rules.required]"
        ></v-text-field>
      </v-col>
    </v-row>
    <v-row no-gutters>
      <v-col md :cols="12" class="mr-3 mb-3">
        <v-file-input
          v-model="data.drivers.files"
          hide-details="auto"
          multiple
          label="Сканы паспорта"
          variant="outlined"
          :rules="rulesFile"
        >
        </v-file-input>
      </v-col>
    </v-row>
    <v-row no-gutters>
      <v-col md :cols="12" class="mb-3">
        <v-file-input
          v-model="licenseFile"
          label="В/У водителя"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
          style="margin-right: 10px"
          :rules="rulesFile"
        ></v-file-input>
      </v-col>
      <v-col md :cols="12" class="mr-3 mb-3">
        <v-text-field
          v-model="data.drivers.driveLicense.number"
          label="Номер В/У"
          class="text-body-1 inputNumber"
          variant="outlined"
          hide-details="auto"
          :rules="[rules.required]"
          type="number"
        ></v-text-field>
      </v-col>
      <v-col md :cols="12" class="mb-6">
        <v-text-field
          v-model="data.drivers.driveLicense.date"
          label="Дата выдачи В/У"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
          :rules="[rules.required]"
          type="date"
        ></v-text-field>
      </v-col>
    </v-row>
    <div class="btnDriverForm">
      <v-btn
        color="primary"
        class="text-body-2 text-uppercase rounded font-weight-bold elevation-0"
        type="submit"
        >Добавить водителя
      </v-btn>
      <v-btn
        color="primary"
        class="text-body-2 text-uppercase rounded font-weight-bold elevation-0"
        @click="resetData"
        >Cбросить
      </v-btn>
    </div>
  </v-form>
</template>
<script setup>
import { useDriversStore } from "~/store/companyConfig/drivers";
const driverStore = useDriversStore();
const licenseFile = ref();
const data = reactive({
  drivers: {
    first_name: {
      value: null,
    },
    middle_name: {
      value: null,
    },
    last_name: {
      value: null,
    },
    email: null,
    phone: null,
    password: null,
    files: [],
    passport: {
      number: null,
    },
    driveLicense: {
      date: null,
      number: null,
    },
  },
});

async function addDriver() {

  const formdata = new FormData();
  formdata.append("first_name", data.drivers.first_name.value);
  formdata.append("middle_name", data.drivers.middle_name.value);
  formdata.append("last_name", data.drivers.last_name.value);
  formdata.append("email", data.drivers.email);
  formdata.append("phone", data.drivers.phone);
  formdata.append("password", data.drivers.password);
  formdata.append("document", licenseFile.value[0]);
  formdata.append("document_date", data.drivers.driveLicense.date);
  formdata.append("document_number", data.drivers.driveLicense.number);

  var files = data.drivers.files;
  for (let i = 0; i < files.length; i++) {
    formdata.append("files[]", files[i]);
  }

  await driverStore.addDriver(formdata);

  // const body = {
  //   first_name: data.drivers.first_name.value,
  //   middle_name: data.drivers.middle_name.value,
  //   last_name: data.drivers.last_name.value,
  //   email: data.drivers.email,
  //   phone: data.drivers.phone,
  //   password: data.drivers.password,
  // };


  // const formdata = new FormData();
  // formdata.append("document", licenseFile.value[0]);
  // formdata.append("document_date", data.drivers.driveLicense.date);
  // formdata.append("document_number", data.drivers.driveLicense.number);
  // await driverStore.addDriverLicense(formdata);

  // const filesdata = new FormData();
  // const files = data.drivers.files;
  // for (let i = 0; i < files.length; i++) {
  //   filesdata.append("files[]", files[i]);
  // }
  // await driverStore.addPassportDriver(filesdata);
}

async function resetData() {
  data.drivers.first_name.value = null;
  data.drivers.middle_name.value = null;
  data.drivers.last_name.value = null;
  data.drivers.email = null;
  data.drivers.phone = null;
  data.drivers.password = null;
  data.drivers.driveLicense.file = null;
  data.drivers.driveLicense.date = null;
  data.drivers.driveLicense.number = null;
  data.drivers.files = null;
}

const rules = {
  required: (value) => !!value || "Поле обязательно для заполнения!",
  phoneLength: (value) =>
    String(value).length === 10 || "Телефон должен быть длинной 10 цифр",
};

const rulesFile = [(v) => !!v || "Выберите файл"];
</script>
<style scoped>
.btnDriverForm {
  display: flex;
  justify-content: space-around;
}
.inputNumber >>> input[type="number"] {
  -moz-appearance: textfield;
}

.inputNumber >>> input::-webkit-outer-spin-button,
.inputNumber >>> input::-webkit-inner-spin-button {
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
}
</style>
