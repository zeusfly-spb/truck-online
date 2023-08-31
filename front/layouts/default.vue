<template>
  <div>
    <v-app>
      <v-app-bar
        :title="appTitle"
      >
        <v-spacer/>
        <MainMenu
          v-if="authenticated"
        />
        <template
          v-else
        >
          <v-btn
            v-if="!authDialog"
            @click="authDialog = true"
          >
            Войти
          </v-btn>
        </template>
      </v-app-bar>
      <v-main
        class="bg"
      >
        <RegisterDialog/>
        <LoginDialog/>
        <ConfirmDialog/>
        <Snack/>
        <slot/>
      </v-main>
    </v-app>
  </div>
</template>

<script lang="ts" setup>
import {storeToRefs} from "pinia";
import {useAuthStore} from "~/store/auth";
import ConfirmDialog from "~/components/dialogs/ConfirmDialog.vue";
import LoginDialog from "~/components/dialogs/LoginDialog.vue";
import RegisterDialog from "~/components/dialogs/RegisterDialog.vue";

const authStore = useAuthStore();
const authenticated = computed(() => authStore.authenticated);
const {logUserOut} = authStore;
const {authDialog, registerDialog} = storeToRefs(authStore);
const {currentRoute} = useRouter();
const routeName = computed(() => currentRoute.value.name);
const appTitle = computed(() => {
  let result = 'OnlinePort';
  if (routeName.value === 'register') {
    result = result + ' - Регистрация';
  }
  return result;
});

const register = async () => {
  registerDialog.value = true
}
const logOut = async () => {
  logUserOut();
  await navigateTo('/');
}
</script>
<style>
a {text-decoration: none;}
.bg {
  background-image: url('/bg.jpg');
  background-size: cover;
}
</style>
