<template>
  <div class="flex-col">
  </div>
</template>

<script setup>
useHead({title: 'Личный кабинет'});
// definePageMeta({middleware: 'auth'});
const text = ref('');

const send = async () => {
  const res = await useFetch('http://localhost/send-code');
  console.log(res);
}

</script>

<style lang="scss" scoped>

</style>
