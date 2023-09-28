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
          append-inner-icon="mdi-magnify"
          label="ИМЯ"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
          style="margin-right: 10px"
        ></v-text-field>
        <v-text-field
          v-model="data.drivers.middle_name.value"
          :items="data.drivers.middle_name.list"
          auto-select-first
          density="comfortable"
          theme="light"
          item-props
          menu-icon=""
          append-inner-icon="mdi-magnify"
          label="ФАМИЛИЯ"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
          style="margin-right: 10px"
        ></v-text-field>
        <v-text-field
          v-model="data.drivers.last_name.value"
          :items="data.drivers.last_name.list"
          auto-select-first
          density="comfortable"
          theme="light"
          item-props
          menu-icon=""
          append-inner-icon="mdi-magnify"
          label="ОТЧЕСТВО"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
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
        ></v-text-field>
      </v-col>
      <v-col md :cols="12" class="mb-3">
        <v-text-field
          v-model="data.drivers.phone"
          label="Телефон"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
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
        ></v-text-field>
      </v-col>
    </v-row>
    <v-row no-gutters>
      <v-col md :cols="12" class="mr-3 mb-3">
        <v-file-input
          v-model="data.drivers.passport.main"
          label="Скан паспорта. Главная страница"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
          name="files"
        ></v-file-input>
      </v-col>
      <v-col md :cols="12" class="mr-3 mb-3">
        <v-file-input
          v-model="data.drivers.passport.second"
          label="Скан паспорта. Вторая страница"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
          name="files"
        ></v-file-input>
      </v-col>
      <v-col md :cols="12">
        <v-text-field
          v-model="data.drivers.driveLicense.number"
          label="Серия и номер паспорта"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
        ></v-text-field>
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
        ></v-file-input>
      </v-col>
      <v-col md :cols="12" class="mr-3 mb-3">
        <v-text-field
          v-model="data.drivers.passport.value"
          label="Номер В/У"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
        ></v-text-field>
      </v-col>
      <v-col md :cols="12" class="mb-6">
        <v-text-field
          v-model="data.drivers.driveLicense.date"
          label="Дата выдачи В/У"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
        ></v-text-field>
      </v-col>
    </v-row>
    <v-row no-gutters>
      <v-col md :cols="12">
        <v-btn
          color="primary"
          class="text-body-2 text-uppercase rounded font-weight-bold elevation-0"
          type="submit"
          >Добавить водителя
        </v-btn>
      </v-col>
    </v-row>
  </v-form>
</template>
<script setup>
import { useDriversStore } from "~/store/companyConfig/drivers";
const driverStore = useDriversStore();

const data = reactive({
  drivers: {
    first_name: {
      value: null,
      list: [1],
    },
    middle_name: {
      value: null,
      list: [1],
    },
    last_name: {
      value: null,
      list: [1],
    },
    email: "",
    phone: "",
    password: "",
    passport: {
      main: null,
      second: null,
      number: "",
    },
    driveLicense: {
      file: "",
      date: "",
      number: "",
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
    path: data.drivers.driveLicense.file,
    date: data.drivers.driveLicense.date,
    number: data.drivers.driveLicense.number,
  };

  await driverStore.addDriverLicense(driverLicense);

  const filesdata = new FormData();
  const files = [data.drivers.passport.main, data.drivers.passport.second];
  console.log("files:", files);
  filesdata.append("file1", files[0]);
  filesdata.append("file2", files[1]);

  for (const [key, value] of filesdata.entries()) {
    console.log("aaaaaaмммммм:", key, value);
  }
  console.log("type:", typeof filesdata);
  await driverStore.addPassportDriver(filesdata);
}
</script>
<style scoped></style>
