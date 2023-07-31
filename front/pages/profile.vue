<template>
  <div>
    <VTextField
      v-model="inn"
    />

    <v-btn
      @click="action"
    >
      Action
    </v-btn>
  </div>
</template>

<script setup>
useHead({title: 'Личный кабинет'});
definePageMeta({ middleware: 'auth' });
const inn = ref('');

const action = async () => {
  const { data: { _rawValue } } = await useFetchApi('http://localhost/api/dadata/find_by_id', {
    method: 'post',
    body: {inn: inn.value}
  });
  console.log(_rawValue);
}

</script>

<style lang="scss" scoped>

</style>
