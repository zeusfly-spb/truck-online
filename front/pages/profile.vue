<template>
  <div class="flex-col">
    <v-btn
      @click="makeTest"
    >
      test
    </v-btn>
  </div>
</template>

<script setup>
useHead({ title: "Личный кабинет" });
definePageMeta({ middleware: "auth" });
const text = ref("");
const makeTest = () => {
  const res = opFetch('/mango-roles');
  console.log(res);
}
</script>

<style lang="scss" scoped></style>
