<template>
  <div>
    <NuxtLayout>
      <NuxtLoadingIndicator />
      <NuxtPage />
    </NuxtLayout>
  </div>
</template>
<script setup lang="js">
import { useAuthStore } from "~/store/auth";
const authStore = useAuthStore();
const authenticated = computed(() => authStore.authenticated);
const token_cookie = useCookie('online_port_token');
token_cookie.value ? await authStore.getUserDetails() : null;
watch(authenticated, async val => val ? await navigateTo('/profile') : await navigateTo('/login'));
</script>
