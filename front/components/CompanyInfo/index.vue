<template>
  <v-col>
    <span>{{ companyInfo[0].value || '' }}</span>
    <div
      v-for="(item, index) in companyDetails"
      :key="index"
    >
      <DetailItem :content="item" :title="index"/>
    </div>
  </v-col>
</template>

<script setup>
import {useAuthStore} from "~/store/auth";
import {storeToRefs} from "pinia";
import DetailItem from "~/components/CompanyInfo/DetailItem.vue";

const config = useRuntimeConfig();
const authStore = useAuthStore();
const user = computed(() => authStore.user);
const companyInn = computed(() => authStore.user && authStore.user.company && authStore.user.company.inn);
const {companyInfo} = storeToRefs(authStore);
const getInfo = async () => {
  const headers = new Headers();
  headers.set('Content-Type', 'application/json');
  headers.set('Accept', 'application/json');
  const cookie_token = useCookie('online_port_token');
  if (cookie_token.value) {
    headers.set("Authorization", `Bearer ${cookie_token.value}`);
  }
  const infoPath = config.public.apiBase + '/dadata/info';
  const {data: {_rawValue}} = await useFetch(infoPath, {method: 'POST', headers, body: {inn: companyInn.value}});
  companyInfo.value = _rawValue;
};
const companyDetails = computed(() => companyInfo.value && companyInfo.value[0] && companyInfo.value[0].data);
watchEffect(async () => {
  if (companyInn.value) {
    await getInfo();
  }
})
</script>

<style lang="scss" scoped>

</style>
