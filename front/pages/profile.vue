<template>
  <div>
    <VTextField
      v-model="inn"
    />
    <v-btn
      @click="testSbis"
    >
      Test
    </v-btn>
  </div>
</template>

<script setup>
import {getSbis} from "~/composables/globals";
useHead({title: 'Личный кабинет'});
definePageMeta({ middleware: 'auth' });
// '7721175899'

const inn = ref('');

const testSbis = async () => {
  const { data, error } = await useFetch('https://api.sbis.ru/vok-demo/req?inn=' + inn.value);
  console.log(JSON.stringify(data))
}
</script>

<style lang="scss" scoped>

</style>
