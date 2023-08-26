<template>
  <div>
    <NuxtLayout>
      <NuxtLoadingIndicator/>
      <NuxtPage/>
    </NuxtLayout>
  </div>
</template>
<script setup>
import {useAuthStore} from "~/store/auth";
import {storeToRefs} from "pinia";

const authStore = useAuthStore();
const {user} = storeToRefs(authStore);
const token = computed(() => {
  const tokenCookie = useCookie('online_port_token');
  return tokenCookie.value || null;
});
const config = useRuntimeConfig();
watchEffect(async () => {
  if (token.value) {
    const headers = new Headers();
    headers.set('Content-Type', 'application/json');
    headers.set('Accept', 'application/json');
    headers.set("Authorization", `Bearer ${token.value}`);
    const detailsPath = config.public.apiBase + '/details';
    const {data: {_rawValue}} = await useFetch(detailsPath, {method: 'GET', headers});
    user.value = _rawValue;
  }
})
</script>
