<template>
  <h1
    v-if="allDrivers.length === 0"
    style="text-align: center; margin-top: 20px"
  >
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
                  @click="showDriverFiles(driver.id)"
                ></v-btn>
              </template>
              <template v-slot:default="{ isActive }">
                <v-card>
                  <v-toolbar
                    color="primary"
                    title="Документы водителя"
                  ></v-toolbar>
                  <v-card-text>
                    <v-carousel style="width: 100%; height: 100%">
                      <v-carousel-item
                        :src="
                          config.public.apiBase.slice(0, -3) +
                          'storage/' +
                          oneDriver.document.path
                        "
                        cover
                      ></v-carousel-item>

                      <v-carousel-item
                        :src="
                          config.public.apiBase.slice(0, -3) +
                          'storage/' +
                          oneDriver.files[0]
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
const showInfoModal = ref(false);
const config = useRuntimeConfig();

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

const showDriverFiles = async (id) => {
  await driverStore.showOneDriver(id);
  showInfoModal.value = true;
};

const oneDriver = computed(() => driverStore.oneDriver);
</script>
<style scoped></style>
