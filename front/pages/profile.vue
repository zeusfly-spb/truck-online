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
useHead({title: 'Личный кабинет'});
definePageMeta({ middleware: 'auth' });

const testSbis = async () => {

}
</script>

<style lang="scss" scoped>

</style>
