<template>
  <div class="flex-col">

  </div>
</template>

<script setup>
useHead({title: 'Личный кабинет'});
definePageMeta({ middleware: 'auth' });
const inn = ref('');
const targetInfo = reactive({});

const makeNSend = async () => {
  const res = await postDadata({query: inn.value});
  targetInfo.value = res.data._rawValue;
}

const innValue = computed(() => targetInfo.value && targetInfo.value.suggestions[0]
  && targetInfo.value.suggestions[0].value || null);

</script>

<style lang="scss" scoped>

</style>
