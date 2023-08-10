<template>
  <div>
    <v-app>
      <v-app-bar
        :title="appTitle"
      >
        <v-spacer/>
        <v-btn
          v-if="authenticated"
          variant="tonal"
          @click="logOut"
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
      <v-main class="bg">
        <ConfirmDialog/>
        <Snack></Snack>
        <slot/>
      </v-main>
    </v-app>
  </div>
</template>


<script lang="ts" setup>
import {useAuthStore} from "~/store/auth";
import ConfirmDialog from "~/components/dialogs/ConfirmDialog.vue";

const authStore = useAuthStore();
const authenticated = computed(() => authStore.authenticated);
const {logUserOut} = authStore;

const {currentRoute} = useRouter();
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
<style>
.bg {
  background-image: url('/bg.jpg');
  background-size: cover;
}
</style>
