<template>
  <div id="app">
    <NuxtLayout>
      <NuxtLoadingIndicator />
      <NuxtPage />
    </NuxtLayout>
  </div>
</template>
<script setup>
import { storeToRefs } from "pinia";
import { useAuthStore } from "~/store/auth";
import "@fontsource/saira";

const authStore = useAuthStore();
const authenticated = computed(() => authStore.authenticated);
const { user, autostart } = storeToRefs(authStore);
const token = computed(() => {
  const tokenCookie = useCookie("online_port_token");
  return tokenCookie.value || null;
});
const config = useRuntimeConfig();
watchEffect(async () => {
  if (token.value && !authenticated.value && autostart.value) {
    const headers = new Headers();
    headers.set("Content-Type", "application/json");
    headers.set("Accept", "application/json");
    headers.set("Authorization", `Bearer ${token.value}`);
    const detailsPath = config.public.apiBase + "/details";
    const {
      data: { _rawValue },
    } = await useFetch(detailsPath, { method: "GET", headers });
    user.value = _rawValue;
  }
});
</script>
<style>
#app {
  height: 100%;
  font-family: "Saira";
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
</style>
