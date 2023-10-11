<template>
  <v-form>
    <v-row no-gutters>
      <v-col md :cols="12" class="mr-3 mb-3">
        <v-text-field
          v-model="data.main.number"
          label="Общий номер"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
        >
        </v-text-field>
      </v-col>
      <v-col md :cols="12" class="mb-3">
        <v-text-field
          v-model="data.main.email"
          label="Общая почта"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
        ></v-text-field>
      </v-col>
    </v-row>
    <v-row no-gutters>
      <v-col md :cols="12" class="mr-3 mb-3">
        <v-file-input
          v-model="data.main.rulereglamento.file"
          label="Устав (скан)"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
        ></v-file-input>
      </v-col>
      <v-col md :cols="12" class="mb-3">
        <v-text-field
          label="Реквизиты для договора"
          v-model="data.main.rulereglamento.dataForContract"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
        ></v-text-field>
      </v-col>
    </v-row>
    <v-row no-gutters>
      <v-col md :cols="12" class="mr-3 mb-3">
        <v-text-field
          v-model="data.main.rulereglamento.number"
          label="Номер документа"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
        ></v-text-field>
      </v-col>
      <v-col md :cols="12" class="mb-3">
        <v-text-field
          v-model="data.main.rulereglamento.date"
          label="Дата документа"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
        ></v-text-field>
      </v-col>
    </v-row>
    <v-row no-gutters>
      <v-col md :cols="12" class="mr-3 mb-3">
        <v-text-field
          v-model="data.main.rulereglamento.signatoryPersone"
          label="Подписант"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
        ></v-text-field>
      </v-col>
      <v-col md :cols="12" class="mb-3">
        <v-file-input
          v-model="data.main.attorney.file"
          label="Приказ/Решение/Доверенность"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
        ></v-file-input>
      </v-col>
    </v-row>
    <v-row no-gutters>
      <v-col md :cols="12" class="mr-3 mb-3">
        <v-text-field
          v-model="data.main.attorney.number"
          label="Номер документа"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
        ></v-text-field>
      </v-col>
      <v-col md :cols="12" class="mb-3">
        <v-text-field
          v-model="data.main.attorney.date"
          label="Дата документа"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
        ></v-text-field>
      </v-col>
    </v-row>
  </v-form>
</template>
<script setup>
const data = reactive({
  main: {
    number: "",
    email: "",
    rulereglamento: {
      file: "",
      dataForContract: "",
      number: "",
      date: "",
      signatoryPersone: "",
    },
    attorney: {
      file: "",
      number: "",
      date: "",
    },
  },
});
</script>
<style scoped></style>
