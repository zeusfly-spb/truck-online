<template>
  <div class="flex-col">
    <div>
    </div>
    <v-btn
      @click="login"
    >
      GO
    </v-btn>
  </div>
</template>

<script setup>
// const {signIn} = useAuth();
useHead({title: 'Личный кабинет'});
// definePageMeta({middleware: 'auth'});
const text = ref('');

</script>

<style lang="scss" scoped>

</style>
