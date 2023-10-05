<template>
  <v-form @submit.prevent="addCar">
    <v-row no-gutters class="align-center">
      <v-col md :cols="12" class="mr-3 mb-3">
        <v-select
          v-model="data.cars.types.value"
          :items="typesCar"
          item-title="name"
          item-value="id"
          label="Тип машины"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
        ></v-select>
      </v-col>
      <v-col md :cols="12" class="mb-3">
        <v-text-field
          v-model="data.cars.number.value"
          label="Номер машины"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
          style="margin-right: 10px"
        ></v-text-field>
      </v-col>
    </v-row>
    <v-row no-gutters class="align-center">
      <v-col md :cols="12" class="mr-3 mb-3">
        <v-select
          v-model="data.cars.country.value"
          :items="countries"
          item-title="name"
          item-value="id"
          label="Страна"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
        ></v-select>
      </v-col>
      <v-col md :cols="12" class="mb-3">
        <v-text-field
          v-model="data.cars.brand.value"
          label="Марка машины"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
        ></v-text-field>
      </v-col>
    </v-row>
    <v-row no-gutters>
      <v-col md :cols="12" class="mr-3 mb-3">
        <v-select
          label="Право использования"
          v-model="data.cars.rightOfUse.value"
          :items="rightUse"
          item-value="id"
          item-title="name"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
        ></v-select>
      </v-col>
      <v-col md :cols="12" class="mb-3">
        <v-file-input
          v-model="data.cars.icon"
          label="Иконка"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
          style="margin-right: 10px"
        >
          </v-file-input>
      </v-col>
      <v-col md :cols="12" class="mb-3">
        <v-text-field
          v-model="data.cars.weigth"
          label="Грузоподъемность (кг)"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
        ></v-text-field>
      </v-col>
    </v-row>
    <v-row no-gutters>
      <v-col md :cols="12" class="mb-3">
        <v-text-field
          v-model="data.cars.sts.number"
          label="Cерия и номер СТС"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
        ></v-text-field>
      </v-col>
      <v-col class="mb-3">
        <v-file-input
          label="СТС Основная Сторона"
          v-model="data.cars.sts.fileOne"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
          style="margin-right: 6px; margin-left: 7px"
        ></v-file-input>
      </v-col>
      <v-col class="mb-3">
        <v-file-input
          label="СТС Обратная Сторона"
          v-model="data.cars.sts.fileTwo"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
        ></v-file-input>
      </v-col>
    </v-row>
    <v-row no-gutters>
      <v-col class="">
        <v-btn
          color="primary"
          type="submit"
          class="text-body-2 text-uppercase rounded font-weight-bold elevation-0"
          >Добавить машину
        </v-btn>
      </v-col>
    </v-row>
  </v-form>
  <div style="margin-top: 15px">
    <cars-table />
  </div>
</template>
<script setup>
import { computed } from "vue";
import { useCarsStore } from "~/store/companyConfig/cars";
import carsTable from "./carsTable.vue";
const carStore = useCarsStore();
const data = reactive({
  cars: {
    types: {
      value: null,
    },
    number: {
      value: null,
    },
    brand: {
      value: null,
    },
    rightOfUse: {
      value: null,
    },
    country: {
      value: null,
    },
    icon: null,
    weigth: null,
    sts: {
      fileOne: [],
      fileTwo: [],
      number: [],
    },
  },
});

onBeforeMount(async () => {
  await carStore.getTypesCar();
  await carStore.getCountries();
  await carStore.getRightUse();
  await carStore.getAllCars();
});
watch(
  () => data.cars.types.value,
  (newVal) => {
    console.log("выбранное значение:", newVal);
  },
);
watch(
  () => data.cars.rightOfUse.value,
  (newVal) => {
    console.log("выбранное значение:", newVal);
  },
);

watch(
  () => data.cars.country.value,
  (newVal) => {
    console.log("выбранное значение:", newVal);
  },
);
const typesCar = computed(() => {
  if (!carStore.typesCars || carStore.loading) return [];
  return (
    carStore.typesCars.map((item) => ({
      ...item,
      tittle: item.name,
      value: item.id,
    })) || []
  );
});

const countries = computed(() => {
  if (!carStore.typesCars || carStore.loading) return [];
  return (
    carStore.countries.map((item) => ({
      ...item,
      tittle: item.name,
      value: item.id,
    })) || []
  );
});

const rightUse = computed(() => {
  if (!carStore.rightUse || carStore.loading) return [];
  return (
    carStore.rightUse.map((item) => ({
      ...item,
      tittle: item.name,
      value: item.id,
    })) || []
  );
});

async function addCar() {
  const formdata = new FormData();
  formdata.append("number", data.cars.number.value);
  formdata.append("car_type_id", data.cars.types.value);
  formdata.append("mark_model", data.cars.brand.value);
  formdata.append("country_id", data.cars.country.value);
  formdata.append("sts", data.cars.sts.number);
  formdata.append("icon", data.cars.icon);
  formdata.append("sts_file_1", data.cars.sts.fileOne);
  formdata.append("sts_file_2", data.cars.sts.fileTwo);
  formdata.append("right_use_id", data.cars.rightOfUse.value);
  formdata.append("max_weigth", data.cars.weigth);
  await carStore.addNewCar(formdata);
}
</script>
<style scoped></style>
