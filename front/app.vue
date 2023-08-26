<template>
  <div>
    <NuxtLayout>
      <NuxtLoadingIndicator/>
      <NuxtPage/>
    </NuxtLayout>
  </div>
</template>
<script setup>
const token = computed(() => {
  const tokenCookie = useCookie('online_port_token');
  return tokenCookie.value || null;
});
const config = useRuntimeConfig();
const startUp = async () => {
  console.log('Starting up...');
  if (token.value) {
    console.log('Token present');
    const headers = new Headers();
    headers.set('Content-Type', 'application/json');
    headers.set('Accept', 'application/json');
    headers.set("Authorization", `Bearer ${token.value}`);
    const detailsPath = config.public.apiBase + '/details';
    const {data: {_rawValue}} = await useFetch(detailsPath, {method: 'GET', headers});
  }
}
startUp();
</script>
