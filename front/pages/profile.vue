<template>
  <div>
    <VTextField
      v-model="inn"
    />
    <v-btn
      :disabled="inn.length < 10"
      @click="makeNSend"
    >
      Получить данные
    </v-btn>
  </div>
</template>

<script setup>
useHead({title: 'Личный кабинет'});
definePageMeta({ middleware: 'auth' });
// import { useConfigStore } from "~/store/config";
// const configStore = useConfigStore();
// const config = computed(() => configStore.config);
const config = useRuntimeConfig();
console.log(config.API_BASE_URL);

const inn = ref('');
// const getConfig = async () => {
//   await configStore.getConfig();
// }
const makeNSend = async () => {
  const res = await postDadata({query: inn.value});
  console.log(res);
}
const testEnv = () => {
  console.log('ENV_DATA:', process.env.API_BASE_URL);
};
testEnv();

</script>

<style lang="scss" scoped>

</style>
