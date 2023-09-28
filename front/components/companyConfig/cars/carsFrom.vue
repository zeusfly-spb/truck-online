<template>
  <v-form>
    <v-row no-gutters class="align-center">
      <v-col md :cols="12" class="mr-3 mb-3">
        <v-select
          v-model="data.cars.types.value"
          :items="typesCar"
          theme="light"
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
          item-tittle="name"
          item-value="id"
          :items="rightUse"
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
        ></v-file-input>
      </v-col>
      <v-col md :cols="12" class="mb-3">
        <v-text-field
          v-model="data.cars.weight"
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
</template>
<script setup>
import { computed } from "vue";
import { useCarsStore } from "~/store/companyConfig/cars";
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
    icon: null,
    weight: null,
    sts: {
      fileOne: "",
      fileTwo: "",
      number: "",
    },
  },
});

onBeforeMount(async () => {
  await carStore.getTypesCar();
  await carStore.getCountries();
  await carStore.getRightUse();
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
const typesCar = computed(() => {
  if (!carStore.typesCars || carStore.loading) return [];
  return carStore.typesCars;
});

const countries = computed(() => {
  if (!carStore.typesCars || carStore.loading) return [];
  return carStore.countries;
});

const rightUse = computed(() => {
  if (!carStore.rightUse || carStore.loading) return [];
  return carStore.rightUse;
});

console.log("right:", rightUse);

async function addNewCar() {
  const formdata = new FormData();
}
</script>
<style></style>
