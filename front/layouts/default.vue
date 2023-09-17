<template>
  <div>
    <v-app>
      <v-app-bar>
        <span
          class="ml-5 unselectable"
          style="cursor: pointer"
          title="На главную"
          @click="navigateTo('/')"
        >
          OnlinePort
        </span>
        <v-spacer />
        <MainMenu v-if="authenticated" />
        <template v-else>
          <v-btn v-if="!authDialog" @click="authDialog = true"> Войти </v-btn>
        </template>
      </v-app-bar>
      <v-main class="mt-2">
        <RegisterDialog />
        <LoginDialog />
        <ConfirmDialog />
        <Snack />
        <slot />
      </v-main>
    </v-app>
  </div>
</template>

<script lang="ts" setup>
import { storeToRefs } from "pinia";
import { useAuthStore } from "~/store/auth";
import ConfirmDialog from "~/components/dialogs/ConfirmDialog.vue";
import LoginDialog from "~/components/dialogs/LoginDialog.vue";
import RegisterDialog from "~/components/dialogs/RegisterDialog.vue";

const authStore = useAuthStore();
const authenticated = computed(() => authStore.authenticated);
const { logUserOut } = authStore;
const { authDialog, registerDialog } = storeToRefs(authStore);
const { currentRoute } = useRouter();
const routeName = computed(() => currentRoute.value.name);
const appTitle = computed(() => {
  let result = "OnlinePort";
  if (routeName.value === "register") {
    result = result + " - Регистрация";
  }
  return result;
});

const register = async () => {
  registerDialog.value = true;
};
</script>
<style>
a {
  text-decoration: none;
}
.unselectable {
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
</style>
