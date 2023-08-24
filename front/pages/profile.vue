<template>
  <div class="flex-col">
    <v-btn
      @click="signIn"
    >
      GO
    </v-btn>
  </div>
</template>

<script setup>
import {useAuth} from "@sidebase/nuxt-auth/dist/runtime/composables/local/useAuth";

const {signIn} = useAuth();
useHead({title: 'Личный кабинет'});
// definePageMeta({middleware: 'auth'});
const text = ref('');

</script>

<style lang="scss" scoped>

</style>
