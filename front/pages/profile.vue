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
const config = useRuntimeConfig();
const inn = ref('');
const targetInfo = reactive({});

const makeNSend = async () => {
  const res = await postDadata({query: inn.value});
  targetInfo.value = res.data._rawValue;
}

const getInnValue = async (inn) => {
  const res = await postDadata({query: inn});
  return res.data._rawValue.suggestions[0].value;
}


const innValue = computed(() => targetInfo.value && targetInfo.value.suggestions[0]
  && targetInfo.value.suggestions[0].value || null);

</script>

<style lang="scss" scoped>

</style>
