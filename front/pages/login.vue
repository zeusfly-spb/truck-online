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
          <VForm
            :disabled="loading"
            @submit.prevent="submit"
            class="mt-10"
          >
            <FormLabel for="email">Email | Номер телефона</FormLabel>
            <VTextField
              :rules="[rules.requiredUsername, rules.usernameRule]"
              v-model="username"
              id="username"
              type="username"
            />
            <label
              class="font-weight-medium mt-2 d-block mb-1 text-body-2"
              for="password"
            >
              Password
            </label>
            <VTextField
              :rules="[rules.requiredPassword]"
              v-model="password"
              id="password"
              type="password"
              name="password"
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
const usernameType = computed(() => /^\d+$/.test(username.value) ? 'phone' : 'email');
const rules = {
  requiredUsername: value => !!value || 'Введите email или номер телефона для авторизации',
  email: value => {
    const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    return pattern.test(value) || 'Неправильный формат e-mail.'
  },
  requiredPassword: value => !!value || 'Введите пароль',
  usernameRule: value => {
    if (!value) {
      return null;
    }
    if (usernameType === 'email') {
      const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
      return pattern.test(value) || 'Неправильный формат e-mail.';
    } else {
      return /^\d+$/.test(value) && value.length > 9 || 'Неправильный формат номера телефона';
    }
  }
}
const submit = async () => {
  try {
    await authStore.authenticateUser({ username, password });
  } catch (e) {
    showError();
  }
};

</script>
<style scoped>
a, u {
  text-decoration: none;
}
</style>
