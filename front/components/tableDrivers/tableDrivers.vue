<template>
  <div>
    
  </div>
</template>
<script setup>
import { useDriversStore } from "~/store/drivers";
const driverStore = useDriversStore();

const allDrivers = computed(() => {
  if (!driverStore.drivers || driverStore.loading) return [];
  return driverStore.drivers;
});
</script>
<style lang=""></style>
