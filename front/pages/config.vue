<template>
  <v-row>
    <v-col>
      <v-text-field
        :model-value="mask.masked(userData.phone)"
        :readonly="true"
        label="Phone"
        @update:model-value="value => phone = mask.unmasked(value)"
      />
      <v-text-field
        v-model="userData.email"
        :readonly="true"
        label="Email"
      />
      <v-text-field
        v-model="userData.first_name"
        label="Имя"
        @keyup.enter="save"
      />
      <v-text-field
        v-model="userData.last_name"
        label="Фамилия"
        @keyup.enter="save"
      />
      <v-text-field
        v-model="userData.middle_name"
        label="Отчество"
        @keyup.enter="save"
      />
      <div
        class="d-flex justify-center"
      >
        <v-btn
          :disabled="!detailsChanged"
          @click="save"
        >
          Сохранить
        </v-btn>
      </div>
    </v-col>
    <CompanyInfo/>
  </v-row>
</template>

<script setup>
useHead({title: 'Настройки'});
definePageMeta({middleware: 'auth'});
import {storeToRefs} from "pinia";
import {useAuthStore} from "~/store/auth";
import CompanyInfo from "~/components/CompanyInfo.vue";
import {Mask} from "maska";

const mask = new Mask({mask: '+7 (###) ###-##-##'});
const email = ref('');
const phone = ref('');
const first_name = ref('');
const last_name = ref('');
const middle_name = ref('');
const company_id = ref('');
const authStore = useAuthStore();
const {user} = storeToRefs(authStore);
const userData = reactive({
  email, phone, first_name, last_name, middle_name, company_id
})
const spreadUserProps = () => {
  userData.email = user.value.email || '';
  userData.phone = user.value.phone || '';
  userData.first_name = user.value.first_name || '';
  userData.last_name = user.value.last_name || '';
  userData.middle_name = user.value.middle_name || '';
  userData.company_id = user.value.company_id || '';
}
const save = async () => {
  const body = {
    first_name: userData.first_name,
    last_name: userData.last_name,
    middle_name: userData.middle_name,
  };
  const options = {method: 'post', body};
  try {
    const {data: {_rawValue}} = await opFetch('/update_user', options);
    user.value = _rawValue;
    backup.value = JSON.stringify(userData)
  } catch (e) {
    console.error(e);
  }
}
watchEffect(async () => {
  user.value ? spreadUserProps() : null
});
const backup = ref('');
onMounted(async () => {
  backup.value = JSON.stringify(userData)
})
const detailsChanged = computed(() => backup.value !== JSON.stringify(userData));
</script>

