<template>
  <v-form>
    <v-row no-gutters>
      <v-col md :cols="12" class="mr-3 mb-3">
        <v-autocomplete
          v-model="bik"
          label="БИК"
          :items="data.dadata"
          item-title="value"
          @update:search="handleInputBik"
          @input="updateBik"
          variant="solo"
        ></v-autocomplete>
      </v-col>
      <v-col md :cols="12" class="mb-3">
        <v-text-field
          v-model="data.requisites.bankName"
          label="Название банка"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
        ></v-text-field>
      </v-col>
    </v-row>
    <v-row no-gutters>
      <v-col md :cols="12" class="mr-3 mb-3">
        <v-text-field
          v-model="data.requisites.corporateAccount"
          label="Кор. Счет"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
        ></v-text-field>
      </v-col>
      <v-col md :cols="12" class="mb-3">
        <v-text-field
          v-model="data.requisites.paymentAccount"
          label="Р/счет"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
        ></v-text-field>
      </v-col>
    </v-row>
  </v-form>
</template>
<script setup>

const bik = ref();
const data = reactive({
  inn: "ИНН организации",
  requisites: {
    bik: "",
    bankName: "",
    corporateAccount: "",
    paymentAccount: "",
  },
  dadata: [],
});

const updateBik = (event) => {
  bik.value = event.target.value;
};

const handleInputBik = async () => {
  console.log("Input value changed:", bik.value);
  var token = "1f871a72833bf0acbdde9976e17aeb519149480d";
  var serviceUrl =
    "https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/bank";
  var request = {
    query: bik.value,
  };
  const headers = new Headers();
  headers.set("Authorization", `Token ${token}`);
  headers.set("Content-Type", "application/json");
  const response = await fetch(serviceUrl, {
    method: "post",
    headers,
    body: JSON.stringify(request),
  });
  const responseData = await response.json();
  data.dadata = responseData.suggestions;
  console.log("ssssss:", data.dadata);
};
</script>
<style scoped></style>
