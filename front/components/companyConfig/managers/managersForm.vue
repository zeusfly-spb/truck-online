<template>
  <v-form>
    <v-row no-gutters class="align-center">
      <v-col md :cols="12" class="mr-3 mb-3">
        <v-autocomplete
          v-model="data.manager.fullName.value"
          :items="data.manager.fullName.list"
          auto-select-first
          density="comfortable"
          theme="light"
          item-props
          menu-icon=""
          append-inner-icon="mdi-magnify"
          label="ФИО"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
        >
        </v-autocomplete>
      </v-col>
      <v-col md="auto" :cols="12" class="mb-3">
        <v-btn
          color="error"
          class="text-body-2 text-uppercase rounded font-weight-bold elevation-0"
          >Убрать
        </v-btn>
      </v-col>
    </v-row>
    <v-row no-gutters>
      <v-col md :cols="12" class="mr-3 mb-3">
        <v-text-field
          v-model="data.manager.email"
          label="E-mail"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
        ></v-text-field>
      </v-col>
      <v-col md :cols="12" class="mb-3">
        <v-text-field
          label="Телефон"
          v-model="data.manager.phone"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
        ></v-text-field>
      </v-col>
    </v-row>
    <v-row no-gutters>
      <v-col md :cols="12">
        <v-btn
          color="primary"
          class="text-body-2 text-uppercase rounded font-weight-bold elevation-0"
          >Добавить менеджера
        </v-btn>
      </v-col>
    </v-row>
  </v-form>
</template>
<script setup>
const data = reactive({
  manager: {
    fullName: {
      value: null,
      list: [1],
    },
    email: "",
    phone: "",
  },
});
</script>
<style scoped></style>
