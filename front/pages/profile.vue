<template>
  <div class="flex-col">
    <VTextField
      v-model="inn"
    />
    <v-btn
      :disabled="inn.length < 10"
      @click="makeNSend"
    >
      Получить данные
    </v-btn>
    <div class="mt-1">
      <v-chip
        v-if="innValue"
      >
        {{ innValue }}
      </v-chip>
    </div>
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
