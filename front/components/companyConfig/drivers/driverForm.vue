<template>
  <v-form @submit.prevent="addDriver">
    <v-row no-gutters class="align-center">
      <v-col md :cols="12" class="mr-3 mb-3" style="display: flex">
        <v-text-field
          v-model="data.drivers.first_name.value"
          :items="data.drivers.first_name.list"
          auto-select-first
          density="comfortable"
          theme="light"
          item-props
          menu-icon=""
          label="ИМЯ"
          class="text-body-1"
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
          class="text-body-1"
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
          class="text-body-1"
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
          :rules="[rules.required]"
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
          v-model="data.drivers.driveLicense.file"
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
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
          :rules="[rules.required]"
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
import tableDrivers from "./tableDrivers.vue";
const driverStore = useDriversStore();

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
    files: null,
    passport: {
      main: null,
      second: null,
      number: null,
    },
    driveLicense: {
      file: null,
      date: null,
      number: null,
    },
  },
});

async function addDriver() {
  const body = {
    first_name: data.drivers.first_name.value,
    middle_name: data.drivers.middle_name.value,
    last_name: data.drivers.last_name.value,
    email: data.drivers.email,
    phone: data.drivers.phone,
    password: data.drivers.password,
  };
  await driverStore.addDriver(body);

  const driverLicense = {
    document: data.drivers.driveLicense.file,
    document_date: data.drivers.driveLicense.date,
    document_number: data.drivers.driveLicense.number,
  };

  await driverStore.addDriverLicense(driverLicense);

  const filesdata = new FormData();
  const files = data.drivers.files;
  console.log("files:", files);
  for (let i = 0; i < files.length; i++) {
    filesdata.append("files[]", files[i]);
  }

  for (const [key, value] of filesdata.entries()) {
    console.log("aaaaaaмммммм:", key, value);
  }
  console.log("type:", typeof filesdata);
  await driverStore.addPassportDriver(filesdata);
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
};

const rulesFile = [(v) => !!v || "Выберите файл"];
</script>
<style scoped>
.btnDriverForm {
  display: flex;
  justify-content: space-around;
}
</style>
