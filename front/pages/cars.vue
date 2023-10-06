<template>
  <v-form @submit.prevent="addCars">
    <input type="file" ref="fileInput" @change="handleFileChange" />
    <button @click="addCar">do something</button>
  </v-form>
</template>
<script setup>
import { ref } from 'vue';
const files = ref()
const fileInput = ref(null);
function handleFileChange() {
    files.value = fileInput.value?.files
    console.log(files.value[0])
}




    async function addCar() {

      let formData = new FormData();
      formData.append('icon',files.value[0])




    const token_cookie = useCookie("online_port_token");
    const headers = new Headers();
    if (token_cookie.value) {
      headers.set("Authorization", `Bearer ${token_cookie.value}`);
    }
    const response = await useFetch(`http://127.0.0.1:8000/api/cars`, {
      method: "post",
      headers,
      body: formData,
      });
    console.log("filesADd:", response);
    }
  </script>
