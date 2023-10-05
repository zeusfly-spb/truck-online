<template>
  <v-table fixed-header height="300px">
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
        <td>{{ car.id || ''}}</td>
        <td>{{ car.mark_model || ''}}</td>
        <td>{{ car.number || ''}}</td>
        <td>{{ car.sts || ''}}</td>
        <td>{{ car.country.name || ''}}</td>
        <td>{{ car.car_type || '' }}</td>
        <td>{{ car.max_weigth || ''}}</td>
        <td><v-btn @click="deleteCar(car.id)">Удалить</v-btn></td>
      </tr>
    </tbody>
  </v-table>
</template>
<script setup>
import { useCarsStore } from "~/store/companyConfig/cars";
const carStore = useCarsStore();
onBeforeMount(async () => {
  await carStore.getAllCars();
});
const allCars = computed(() => {
  if (!carStore.cars || carStore.loading) return [];
  return carStore.cars;
});

async function deleteCar(id) {
  await carStore.deleteCar(id);
}

console.log("cars:", allCars);
</script>
<style scoped></style>
