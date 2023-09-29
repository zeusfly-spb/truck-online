<template>
  <div class="h-100 pt-10 container basic-data">
    <h2 class="text-h2 font-weight-bold mb-6">Основные данные:</h2>
    <h4 class="text-h4 mb-6">{{ data.inn }}</h4>
    <v-tabs v-model="tab">
      <v-tab value="main" class="font-weight-medium text-body-1 text-uppercase"
        >Общие данные</v-tab
      >
      <v-tab value="rec" class="font-weight-medium text-body-1 text-uppercase"
        >Реквизиты</v-tab
      >
      <v-tab value="cars" class="font-weight-medium text-body-1 text-uppercase"
        >Машины</v-tab
      >
      <v-tab
        value="drivers"
        class="font-weight-medium text-body-1 text-uppercase"
        >Водители</v-tab
      >
      <v-tab
        value="managers"
        class="font-weight-medium text-body-1 text-uppercase"
        >Менеджеры</v-tab
      >
    </v-tabs>
    <v-window v-model="tab" class="pt-6">
      <v-window-item value="main">
        <rec-form />
      </v-window-item>
      <v-window-item value="rec"> <main-data-form /></v-window-item>
      <v-window-item value="cars">
        <cars-form />
      </v-window-item>
      <v-window-item value="drivers">
        <driver-form />
      </v-window-item>
      <v-window-item value="managers">
        <managers-form />
      </v-window-item>
    </v-window>
  </div>
</template>
<script setup>
import driverForm from "~/components/companyConfig/drivers/driverForm.vue";
import carsForm from "~/components/companyConfig/cars/carsForm.vue";
import managersForm from "~/components/companyConfig/managers/managersForm.vue";
import recForm from "~/components/companyConfig/rec/recForm.vue";
import mainDataForm from "~/components/companyConfig/mainData/mainDataForm.vue";
const tab = ref("main");

const data = reactive({
  inn: "Инн организации",
});
</script>

<style lang="scss" scoped>
.basic-data {
  :deep(.v-file-input) {
    position: relative;
  }
  :deep(.v-file-input .v-input__prepend) {
    position: absolute;
    left: 12px;
    top: 16px;
  }
  :deep(.v-file-input .v-field-label) {
    margin-left: 40px;
  }
  :deep(.v-file-input .v-field__input) {
    margin-left: 40px;
  }
}
</style>
