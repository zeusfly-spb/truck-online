<template>
  <h1 v-if="allDrivers.length === 0" style="text-align: center; margin-top: 20px;" >
    У вас нет еще ни одного водителя
  </h1>
  <v-table fixed-header v-else>
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
        <v-dialog width="400">
          <template v-slot:activator="{ props }">
            <v-btn v-bind="props" text="Удалить водителя"> </v-btn>
          </template>

          <template v-slot:default="{ isActive }">
            <v-card title="Подтвердите удаление водителя">
              <v-card-text
                style="
                  display: flex;
                  justify-content: space-around;
                  margin-top: 15px;
                "
              >
                <td>
                  <v-btn @click="deleteDriver(driver.id)">Удалить</v-btn>
                </td>
                <v-btn text="Отменить" @click="isActive.value = false"></v-btn>
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

</script>
<style scoped></style>
