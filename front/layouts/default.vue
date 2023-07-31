<template>
  <div>
    <v-app>
      <v-app-bar title="OnlinePort">
        <v-spacer/>
        <v-btn
          v-if="authenticated"
          @click="logOut"
          variant="tonal"
        >
          Выйти
        </v-btn>
      </v-app-bar>
      <v-main>
        <Snack></Snack>
        <slot />
      </v-main>
    </v-app>
  </div>
</template>

<script setup lang="ts">
import { storeToRefs } from 'pinia'
import { useAuthStore } from "~/store/auth";
const authStore = useAuthStore();
const { authenticated } = storeToRefs(useAuthStore());
const { logUserOut } = authStore;
const logOut = async () => {
  logUserOut();
  await navigateTo('/login');
}
</script>
