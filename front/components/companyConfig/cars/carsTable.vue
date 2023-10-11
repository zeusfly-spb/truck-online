<template>
  <v-form @submit.prevent="updateCar" v-if="data.showFormCar">
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
          :rules="[rules.required]"
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
          :rules="[rules.required]"
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
          :rules="[rules.required]"
        ></v-select>
      </v-col>
      <v-col md :cols="12" class="mb-3">
        <v-text-field
          v-model="data.cars.brand.value"
          label="Марка машины"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
          :rules="[rules.required]"
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
          :rules="[rules.required]"
        ></v-select>
      </v-col>
      <v-col md :cols="12" class="mb-3">
        <v-file-input
          v-model="icon"
          label="Иконка"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
          style="margin-right: 10px"
          :rules="[rules.required]"
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
          :rules="[rules.required]"
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
          :rules="[rules.required]"
        ></v-text-field>
      </v-col>
      <v-col class="mb-3">
        <v-file-input
          label="СТС Основная Сторона"
          v-model="fileOne"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
          style="margin-right: 6px; margin-left: 7px"
          :rules="[rules.required]"
        ></v-file-input>
      </v-col>
      <v-col class="mb-3">
        <v-file-input
          label="СТС Обратная Сторона"
          v-model="fileTwo"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
          :rules="[rules.required]"
        ></v-file-input>
      </v-col>
    </v-row>
    <v-row no-gutters>
      <v-col class="">
        <v-btn
          color="primary"
          type="submit"
          class="text-body-2 text-uppercase rounded font-weight-bold elevation-0"
          >Обнавить машину
        </v-btn>
      </v-col>
    </v-row>
  </v-form>
  <h1 v-if="allCars.length === 0" class="noCars">
    У вас еще нет ни одной машины
  </h1>
  <v-table fixed-header height="300px" v-else>
    <thead>
      <tr>
        <th class="text-left">ID</th>
        <th class="text-left">Марка модели</th>
        <th class="text-left">Номерной знак</th>
        <th class="text-left">Номер СТС</th>
        <th class="text-left">Страна</th>
        <th class="text-left">Тип машины</th>
        <th class="text-left">Грузоподъемность</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="car in allCars" :key="car.id">
        <td>{{ car.id }}</td>
        <td>{{ car.mark_model }}</td>
        <td>{{ car.number }}</td>
        <td>{{ car.sts }}</td>
        <td>{{ car.country.name }}</td>
        <td>{{ car.car_type || "" }}</td>
        <td>{{ car.max_weigth }}</td>
        <v-dialog width="400">
          <template v-slot:activator="{ props }">
            <td>
              <v-btn v-bind="props" text="Удалить машину"> </v-btn>
            </td>
          </template>

          <template v-slot:default="{ isActive }">
            <v-card title="Подтвердите удаление машины">
              <v-card-text
                style="
                  display: flex;
                  justify-content: space-around;
                  margin-top: 15px;
                "
              >
                <v-btn @click="deleteCar(car.id)">Удалить</v-btn>
                <v-btn text="Отменить" @click="isActive.value = false"></v-btn>
              </v-card-text>

              <v-card-actions>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </template>
        </v-dialog>
        <td><v-btn @click="changeEditFormCar(car.id)">Изменить</v-btn></td>
      </tr>
    </tbody>
  </v-table>
</template>
<script setup>
import { useCarsStore } from "~/store/companyConfig/cars";
const carStore = useCarsStore();
const data = reactive({
  showFormEditCar: false,
  cars: {
    id: null,
    types: {
      value: null,
    },
    number: {
      value: "",
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
    weigth: null,
    fileOne: null,
    fileTwo: null,
    sts: {
      number: "",
    },
  },
});
const rules = {
  required: (value) => !!value || "Поле обязательно для заполнения",
};
const icon = ref();
const fileOne = ref();
const fileTwo = ref();

onBeforeMount(async () => {
  await carStore.getTypesCar();
  await carStore.getCountries();
  await carStore.getRightUse();
  await carStore.getAllCars();
});

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
async function changeEditFormCar(id) {
  data.showFormCar = !data.showFormCar;
  const {
    data: { _rawValue },
  } = await opFetch(`/cars/${id}`, { method: "get" });
  data.cars.id = _rawValue["id"];
  data.cars.number.value = _rawValue["number"];
  data.cars.types.value = _rawValue["car_type"]["id"];
  data.cars.brand.value = _rawValue["mark_model"];
  data.cars.country.value = _rawValue["country"]["id"];
  data.cars.sts.number = _rawValue["sts"];
  data.cars.rightOfUse.value = _rawValue["right_use"]["id"];
  data.cars.weigth = _rawValue["max_weigth"];
}
const allCars = computed(() => {
  if (!carStore.cars || carStore.loading) return [];
  return carStore.cars;
});

async function deleteCar(id) {
  await carStore.deleteCar(id);
}

console.log("cars:", allCars);
</script>
<style scoped>
.noCars {
}
</style>
