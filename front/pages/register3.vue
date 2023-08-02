<template>
  <VRow
    no-gutters
    justify="center"
    align="center"
    class="fill-height pa-0 ma-0"
  >
    <VCol cols="10" md="6" sm="8">
      <VRow justify="center" align="center">
        <VCol cols="12" md="6" sm="10">
          <VForm :disabled="loading" @submit.prevent="submit" class="mt-10">
            <FormLabel for="email">Email | Номер телефона</FormLabel>
            <VTextField
              v-model="username"
              id="username"
              type="username"
            />
            <label
              class="font-weight-medium mt-2 d-block mb-1 text-body-2"
              for="password"
            >
              Пароль
            </label>
            <VTextField
              v-model="password"
              id="password"
              type="password"
            />
            <label
              class="font-weight-medium mt-2 d-block mb-1 text-body-2"
              for="password"
            >
              Подтверждение пароля
            </label>
            <VTextField
              v-model="passwordConfirm"
              id="password_confirm"
              type="password"
            />

            <div class="mt-10">
              <VBtn
                :loading="loading"
                type="submit"
                flat
                class="gradient primary font-weight-bold text-body-2"
                min-height="45"
                block
              >
                Регистрировать
              </VBtn>
            </div>
          </VForm>
        </VCol>
      </VRow>
    </VCol>
  </VRow>
</template>

<script setup lang="js">
useHead({title: 'Регистрация'});
import { useAuthStore } from "~/store/auth";
const authStore = useAuthStore();
const username = ref('');
const password = ref('');
const passwordConfirm = ref('');

const loading = computed(() => authStore.loading);
const registered = async () => {
  useSnack({
    show: true,
    type: 'success',
    title: 'Авторизован',
    message: 'Вы успешно зарегистрировались в системе',
  });
  await navigateTo('/login');
}
const submit = async () => {
  const success = await authStore.registerUser({ username, password, passwordConfirm });
  success ? registered() : null;
};
</script>
<style scoped>
a, u {
  text-decoration: none;
}
</style>
