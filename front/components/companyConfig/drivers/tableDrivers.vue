<template>
  <v-table fixed-header height="300px">
    <thead>
      <tr>
        <th class="text-left">ID</th>
        <th class="text-left">ФИО</th>
        <th class="text-left">Email</th>
        <th class="text-left">Телефон</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="driver in allDrivers" :key="driver.id">
        <td>{{ driver.id }}</td>

        <td>
          {{ driver.middle_name }} {{ driver.first_name }}
          {{ driver.last_name }}
        </td>
        <td>{{ driver.email }}</td>
        <td>{{ driver.phone }}</td>
        <td><v-btn @click="deleteDriver(driver.id)">Удалить</v-btn></td>
      </tr>
    </tbody>
  </v-table>
</template>
<script setup>
import { useDriversStore } from "~/store/companyConfig/drivers";
const driverStore = useDriversStore();
onBeforeMount(async () => {
  await driverStore.getDrivers();
});
const allDrivers = computed(() => {
  if (!driverStore.drivers || driverStore.loading) return [];
  return driverStore.drivers;
});

const deleteDriver = async (id) => {
  await driverStore.deleteDriver(id);
};

console.log("drova:", allDrivers);
</script>
<style scoped></style>
