<template>
  <v-form>
    <v-row no-gutters>
      <v-col md :cols="12" class="mr-3 mb-3">
        <v-autocomplete
          v-model="bik"
          label="Autocomplete"
          :items="data.dadata"
          item-title="value"
          item-value="value"
          @update:search="handleInputBik"
          @input="updateBik"
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
  dadata: []
});
const updateBik = (event) => {
  bik.value = event.target.value;
}

const handleInputBik = async () => {

  console.log('Input value changed:', bik.value);
  var token = "1f871a72833bf0acbdde9976e17aeb519149480d";
  var serviceUrl = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/bank";
  var request = {
    "query": 22
  };
  const headers = new Headers();
  headers.set("Authorization", `Token ${ token }`);

  const { data: { _rawValue },} = await fetch(serviceUrl,{
    method: 'post',
    headers,
    body: request,
    async onResponse({ request, response, options }) {
      console.log(response?._data);
      data.dadata = response?._data.suggestions;
      data.requisites.bik = response?._data?.suggestions[0]?.data?.bic
      //console.log(response?._data?.suggestions[0])
    },
  });
   console.log("dadata");
   console.log(data.dadata);

};
  // var params = {
  //   type: "POST",
  //   contentType: "application/json",
  //   headers: {
  //     "Authorization": "Token " + token
  //   },
  //   data: JSON.stringify(request)
  // }

	// return $.ajax(serviceUrl, params);

  // You can perform additional actions with the updated value here
</script>
<style scoped></style>
