<template>
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
        <td>{{ car.car_type.name }}</td>
        <td>{{ car.max_weigth }}</td>
        <td>
          <v-col cols="auto">
            <v-dialog
              transition="dialog-bottom-transition"
              style="width: 100%; height: 100%"
              v-model="showInfoModal"
            >
              <template v-slot:activator="{ props }">
                <v-btn
                  text="Дополнительно"
                  v-bind="props"
                  @click="showSts(car.id)"
                ></v-btn>
              </template>
              <template v-slot:default="{ isActive }">
                <v-card>
                  <v-toolbar
                    color="primary"
                    title="СТС файлы машины"
                  ></v-toolbar>
                  <v-card-text>
                    <v-carousel style="width: 100%; height: 100%">
                      <v-carousel-item
                        :src="
                          config.public.apiBase.slice(0, -3) +
                          'storage/' +
                          oneCar.sts_file_1
                        "
                        cover
                      ></v-carousel-item>

                      <v-carousel-item
                        :src="
                          config.public.apiBase.slice(0, -3) +
                          'storage/' +
                          oneCar.sts_file_1
                        "
                        cover
                      ></v-carousel-item>
                    </v-carousel>
                  </v-card-text>
                  <v-card-actions class="justify-end">
                    <v-btn variant="text" @click="isActive.value = false"
                      >Закрыть</v-btn
                    >
                  </v-card-actions>
                </v-card>
              </template>
            </v-dialog>
          </v-col>
        </td>
        <v-dialog width="1500">
          <template v-slot:activator="{ props }">
            <td>
              <v-btn @click="changeEditFormCar(car.id)" v-bind="props"
                >Изменить</v-btn
              >
            </td>
          </template>
          <template v-slot:default="{ isActive }">
            <v-card title="Изменение данных машины">
              <v-card-text>
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
                        prepend-icon=""
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
                        prepend-icon=""
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
                        prepend-icon=""
                        variant="outlined"
                        hide-details="auto"
                        :rules="[rules.required]"
                      ></v-file-input>
                    </v-col>
                  </v-row>
                  <v-row no-gutters>
                    <v-col>
                      <v-btn
                        color="primary"
                        type="submit"
                        class="text-body-2 text-uppercase rounded font-weight-bold elevation-0"
                        >Обновить машину
                      </v-btn>
                    </v-col>
                    <v-btn
                      text="Отменить"
                      @click="isActive.value = false"
                      class="text-body-2 text-uppercase rounded font-weight-bold elevation-0"
                      color="primary"
                    ></v-btn>
                  </v-row>
                </v-form>
              </v-card-text>

              <v-card-actions>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </template>
        </v-dialog>
      </tr>
    </tbody>
  </v-table>
</template>
<script setup>
import { useCarsStore } from "~/store/companyConfig/cars";
const carStore = useCarsStore();
const oneCar = computed(() => carStore.oneCar);
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
const config = useRuntimeConfig();

const showInfoModal = ref(false);
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

const showSts = async (id) => {
  await carStore.showCar(id);
  console.log("vvvv;", carStore.oneCar.sts_file_1);
  showInfoModal.value = true;
};

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

const updateCar = async () => {
  const formData = new FormData();
  formData.append("_method", "PUT");
  formData.append("number", data.cars.number.value);
  formData.append("car_type_id", data.cars.types.value);
  formData.append("mark_model", data.cars.brand.value);
  formData.append("country_id", data.cars.country.value);
  formData.append("sts", data.cars.sts.number);
  formData.append("icon", icon.value && icon.value[0]);
  formData.append("sts_file_1", fileOne.value && fileOne.value[0]);
  formData.append("sts_file_2", fileTwo.value && fileTwo.value[0]);
  formData.append("right_use_id", data.cars.rightOfUse.value);
  formData.append("max_weigth", data.cars.weigth);
  await carStore.updateCar(data.cars.id, formData);
};
const allCars = computed(() => {
  if (!carStore.cars || carStore.loading) return [];
  return carStore.cars;
});

async function deleteCar(id) {
  await carStore.deleteCar(id);
}
</script>
<style scoped></style>
