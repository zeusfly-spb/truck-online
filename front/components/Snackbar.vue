<template>
  <v-snackbar v-model="show" :color="color">
    {{ message }}
    <v-btn text @click="show = false"> Закрыть </v-btn>
  </v-snackbar>
</template>

<script setup>
const show = ref(false);
const color = ref("");
const message = ref("");
</script>

<style lang="scss" scoped></style>
