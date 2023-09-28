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
      <tr v-for="driver in allDrivers" :key="driver.name">
        <td>
          {{ driver.first_name }} {{ driver.middle_name }}
          {{ driver.last_name }}
        </td>
        <td>{{ driver.email }}</td>
        <td>{{ driver.phone }}</td>
      </tr>
    </tbody>
  </v-table>
</template>
<script setup>
import { onBeforeMount } from "vue";
import { useDriversStore } from "~/store/drivers";
const driverStore = useDriversStore();
onBeforeMount(() => {
  await driverStore.getDrivers()
})
const allDrivers = computed(() => {
  if (!driverStore.drivers || driverStore.loading) return [];
  return driverStore.drivers;
});
</script>
<style lang=""></style>
