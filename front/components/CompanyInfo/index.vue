<template>
  <v-col>
    <div
      v-if="companyInfo"
      class="d-flex justify-center"
    >
      <strong>{{ companyInfo[0].value || '' }}</strong>
    </div>
    <template
      v-if="companyDetails"
    >
      <div
        v-for="(item, index) in textDetails"
        :key="index"
      >
        <DetailItem :content="item" :title="index"/>
      </div>
      <div
        v-for="(item, index) in objectDetails"
        :key="index"
      >
        <DetailItem :content="item" :title="index"/>
      </div>
    </template>
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
const companyDetails = computed(() => {
  const unchanged = companyInfo.value && companyInfo.value[0] && companyInfo.value[0].data;
  if (!unchanged) {
    return null;
  }
  const changed = JSON.parse(JSON.stringify(unchanged));
  changed.ogrn_date = realDate(changed.ogrn_date);
  changed.state.registration_date = realDate(changed.state.registration_date);
  changed.state.actuality_date = realDate(changed.state.actuality_date);
  changed['company_name'] = unchanged.name;
  changed['company_type'] = unchanged.type;
  delete changed.type;
  delete changed.name;
  delete changed.address.data;
  delete changed.hid;
  return changed;
});
const realDate = timestamp => {
  const date = new Date(timestamp + 1000);
  let options = {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  };
  return date.toLocaleString("ru", options)
}
const textDetails = computed(() => {
  if (!companyDetails.value) {
    return {};
  }
  const result = {};
  for (let key in companyDetails.value) {
    const detail = companyDetails.value[key];
    const type = typeof detail;
    if (['string', 'number'].includes(type)) {
      result[key] = detail;
    }
  }
  return result;
})
const emptyObject = obj => {
  for (let key in obj) {
    if (!!obj[key]) {
      return false;
    }
  }
  return true;
}
const objectDetails = computed(() => {
  if (!companyDetails.value) {
    return {};
  }
  const result = {};
  for (let key in companyDetails.value) {
    const detail = companyDetails.value[key];
    const type = typeof detail;
    if (type === 'object' && !emptyObject(detail)) {
      result[key] = detail;
    }
  }
  return result;
})
watchEffect(async () => {
  if (companyInn.value) {
    await getInfo();
  }
})
</script>

<style lang="scss" scoped>

</style>
