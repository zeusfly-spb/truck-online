<template>
  <v-row>
    <v-col>
      <v-text-field
        v-model="email"
        label="Email"
      />
      <v-text-field
        v-model="phone"
        label="Phone"
      />
      <v-text-field
        v-model="first_name"
        label="First Name"
      />
      <v-text-field
        v-model="last_name"
        label="Last Name"
      />
      <v-text-field
        v-model="middle_name"
        label="Middle name"
      />
      <v-text-field
        v-model="company_id"
        label="Company ID"
      />
      <v-text-field
        v-model="company_inn"
        label="Company INN"
        readonly
      />
      <div
        class="d-flex justify-center"
      >
        <v-btn
          @click="save"
        >
          Сохранить
        </v-btn>
      </div>

    </v-col>
    <v-col>
      <v-btn
        @click="getCompanyInfo(company_inn)"
      >
        Get Company Details
      </v-btn>
    </v-col>
  </v-row>
</template>

<script setup>
import {useAuthStore} from "~/store/auth";

useHead({title: 'Настройки'});
// definePageMeta({middleware: 'auth'});
const email = ref('');
const phone = ref('');
const first_name = ref('');
const last_name = ref('');
const middle_name = ref('');
const company_id = ref('');
const authStore = useAuthStore();
const company_inn = computed(() => user.value.company.inn);
const user = computed(() => authStore.user);
const {getCompanyInfo} = authStore;

const spreadUserProps = () => {
  email.value = user.value.email || '';
  phone.value = user.value.phone || '';
  first_name.value = user.value.first_name || '';
  last_name.value = user.value.last_name || '';
  middle_name.value = user.value.middle_name || '';
  company_id.value = user.value.company_id || '';
}
const save = async () => {
  const body = {
    email: email.value,
    phone: phone.value,
    first_name: first_name.value,
    last_name: last_name.value,
    middle_name: middle_name.value,
    company_id: company_id.value
  };
  const options = {method: 'post', body};
  await opFetch('/update_user', options);
}
watchEffect(async () => {
  user.value ? spreadUserProps() : null
});
spreadUserProps();
</script>

<style lang="scss" scoped>

</style>
