<template>
  <div>
    <VTextField
      v-model="inn"
    />
    <v-btn
      @click="makeNSend"
    >
      Test!
    </v-btn>
  </div>
</template>

<script setup>
useHead({title: 'Личный кабинет'});
definePageMeta({ middleware: 'auth' });
import { useConfigStore } from "~/store/config";
const configStore = useConfigStore();
const config = computed(() => configStore.config);
const inn = ref('');
const getConfig = async () => {
  await configStore.getConfig();
}
const makeNSend = async () => {
  const res = await postDadata({query: inn.value});
  console.log(res);
}
getConfig();
</script>

<style lang="scss" scoped>

</style>
