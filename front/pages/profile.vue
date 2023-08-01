<template>
  <div>
  </div>
</template>

<script setup>
useHead({title: 'Личный кабинет'});
definePageMeta({ middleware: 'auth' });
import { useConfigStore } from "~/store/config";
const configStore = useConfigStore();
const config = computed(() => configStore.config);
const getConfig = async () => {
  await configStore.getConfig();
}
getConfig();
</script>

<style lang="scss" scoped>

</style>
