<template>
  <v-row>
    <v-col>
      <v-text-field
        v-model="userData.email"
        :readonly="true"
        label="Email"
      />
      <v-text-field
        v-model="userData.phone"
        :readonly="true"
        label="Phone"
      />
      <v-text-field
        v-model="userData.first_name"
        label="First Name"
      />
      <v-text-field
        v-model="userData.last_name"
        label="Last Name"
      />
      <v-text-field
        v-model="userData.middle_name"
        label="Middle name"
      />
      <v-text-field
        v-model="userData.company_id"
        :readonly="true"
        label="Company ID"
      />
      <v-text-field
        v-model="company_inn"
        :readonly="true"
        label="Company INN"
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
import {storeToRefs} from "pinia";

useHead({title: 'Настройки'});
import {useAuthStore} from "~/store/auth";
import CompanyInfo from "~/components/CompanyInfo/index.vue";
const email = ref('');
const phone = ref('');
const first_name = ref('');
const last_name = ref('');
const middle_name = ref('');
const company_id = ref('');
const authStore = useAuthStore();
const {user} = storeToRefs(authStore);
const company_inn = computed(() => user.value && user.value.company && user.value.company.inn || null);

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

