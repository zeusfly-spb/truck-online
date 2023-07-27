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
            >Password</label
            >
            <VTextField
              v-model="password"
              @click:append-inner="
                passwordType == 'password'
                  ? (passwordType = 'text')
                  : (passwordType = 'password')
              "
              :append-inner-icon="
                passwordType == 'password'
                  ? 'fluent:eye-24-regular'
                  : 'fluent:eye-off-24-regular'
              "
              id="password"
              :type="passwordType"
            />
            <p class="text-medium-emphasis text-body-2 mt-3">
              <p class="text-body-1 text-medium-emphasis mt-2">
                Нет аккаунта?
                <NuxtLink
                  to="/register"
                  class="font-weight-medium text-primary"
                >
                  Регистрация
                </NuxtLink>
              </p>
            </p>
            <div class="mt-10">
              <VBtn
                :loading="loading"
                type="submit"
                flat
                class="gradient primary font-weight-bold text-body-2"
                min-height="45"
                block
              >
                Вход
              </VBtn>
            </div>
          </VForm>
        </VCol>
      </VRow>
    </VCol>
  </VRow>
</template>

<script setup lang="js">
useHead({title: 'Вход'});
import { useAuthStore } from "~/store/auth";
const authStore = useAuthStore();
const username = ref('');
const password = ref('');
const passwordType = ref('password');
const loading = computed(() => authStore.loading);
const authenticated = computed(() => authStore.authenticated);
watch(authenticated, (val) => {
  const action = async () => {
    useSnack({
      show: true,
      type: 'success',
      title: 'Авторизован',
      message: 'Вы успешно авторизовались в системе',
    });
    await navigateTo('/profile');
  }
  val ? action() : null;
})
const showError = async () => {
  useSnack({
    show: true,
    type: 'error',
    title: 'Ошибка авторизации!',
    message: 'Проверьте правильность введенных данных',
  });
}
const submit = async () => {
  try {
    await authStore.authenticateUser({ username, password });
  } catch (e) {
    console.log('ERROR!');
    showError();
  }
};
</script>
<style scoped>
a, u {
  text-decoration: none;
}
</style>
