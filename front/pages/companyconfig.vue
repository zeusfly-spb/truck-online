<template>
  <div class="h-100 pt-10 container basic-data">
    <div class="mainConfig">
      <h2 class="mainName">Основные данные:</h2>
      <h4 class="innTag">{{ data.inn }}</h4>
      <v-tabs v-model="tab">
        <v-tab
          value="main"
          class="font-weight-medium text-body-1 text-uppercase"
          >Реквизиты</v-tab
        >
        <v-tab value="rec" class="font-weight-medium text-body-1 text-uppercase"
          >Общие данные</v-tab
        >
        <v-tab
          value="cars"
          class="font-weight-medium text-body-1 text-uppercase"
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
    </div>
    <v-window v-model="tab" class="pt-6 windows">
      <v-window-item value="main">
        <rec-form />
      </v-window-item>
      <v-window-item value="rec">
        <main-data-form />
      </v-window-item>
      <v-window-item value="cars" class="window-item">
        <div class="carForm">
          <cars-form />
        </div>
        <div class="carTable">
          <cars-table />
        </div>
      </v-window-item>
      <v-window-item value="drivers" class="window-item">
        <div class="driverForm">
          <driver-form />
        </div>
        <div class="driverTable"><table-drivers /></div>
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
import carsTable from "~/components/companyConfig/cars/carsTable.vue";
import tableDrivers from "~/components/companyConfig/drivers/tableDrivers.vue";
const tab = ref("main");

const data = reactive({
  inn: "Инн организации",
});
</script>

<style lang="scss" scoped>
.basic-data {
  height: 100%;
  .mainName {
    font-size: 60px;
  }
  .innTag {
    font-size: 30px;
    margin-left: 5px;
  }
  .window-item {
    display: flex;
    flex-direction: column;
    // height: 100%;
    .carForm {
      flex-shrink: 0;
      // max-height: 450px;
    }

    .carTable {
      flex-grow: 1;
      overflow: auto;
      height: 46vh;
      position: relative;
      width: 100%;
      margin-top: 15px;
    }

    .driverForm {
      flex-grow: 1;
      overflow: auto;
    }
    .driverTable {
      flex-grow: 1;
      overflow: auto;
      height: 39vh;
      position: relative;
      width: 100%;
      margin-top: 15px;
    }
  }
  @media (max-width: 960px) {
    .window-item {
      .carForm,
      .driverForm {
        height: auto;
        overflow: auto;
      }

      .driverTable {
        width: 100%;
        height: auto;
        overflow: auto;
      }
    }
  }

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

  @media (max-width: 508px) {
    .mainName {
      font-size: 50px;
    }
    .innTag {
      font-size: 25px;
    }
  }
  @media (max-width: 456px) {
    :deep(.v-file-input .v-input__prepend) {
      position: absolute;
      left: 1px;
      top: 16px;
    }
    :deep(.v-file-input .v-field-label) {
      margin-left: 27px;
    }
  }
  @media (max-width: 424px) {
    .mainName {
      font-size: 40px;
    }
    .innTag {
      font-size: 20px;
    }
  }
  @media (max-width: 339px) {
    .mainName {
      font-size: 30px;
    }
    .innTag {
      font-size: 15px;
    }
    :deep(.v-file-input .v-input__prepend) {
      position: absolute;
      left: 1px;
      top: 16px;
    }
    :deep(.v-file-input .v-field-label) {
      margin-left: 23px;
    }
  }
}
</style>
