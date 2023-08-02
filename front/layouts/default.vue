<template>
  <div>
    <v-app>
      <v-app-bar
        :title="appTitle"
      >
        <v-spacer/>
        <v-btn
          v-if="authenticated"
          @click="logOut"
          variant="tonal"
        >
          Выйти
        </v-btn>
        <v-btn
          v-if="!authenticated && 'login' !== routeName"
          @click="redirectLogin"
        >
          Войти
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
import { useAuthStore } from "~/store/auth";
const authStore = useAuthStore();
const authenticated = computed(() => authStore.authenticated);
const { logUserOut } = authStore;

const { currentRoute } = useRouter();
const routeName = computed(() => currentRoute.value.name);

const appTitle = computed(() => {
  let result = 'OnlinePort';
  if (['register', 'register2'].includes(routeName.value)) {
    result = result + ' - Регистрация';
  }
  return result;
});

const logOut = async () => {
  logUserOut();
  await navigateTo('/login');
}
const redirectLogin = async () => {
  await navigateTo('/login');
}
</script>
