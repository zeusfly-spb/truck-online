<template>
  <VRow
    align="center"
    class="fill-height pa-0 ma-0"
    justify="center"
    no-gutters
  >
    <VCol cols="10" md="6" sm="8">
      <VRow align="center" justify="center">
        <VCol cols="12" md="6" sm="10">
          <VForm
            :disabled="loading"
            class="mt-10"
            @submit.prevent="submit"
          >
            <FormLabel for="email">Email | Номер телефона</FormLabel>
            <VTextField
              id="username"
              v-model="username"
              type="username"
            />
            <label
              class="font-weight-medium mt-2 d-block mb-1 text-body-2"
              for="password"
            >
              Password
            </label>
            <VTextField
              id="password"
              v-model="password"
              name="password"
              type="password"
            />
            <p class="text-medium-emphasis text-body-2 mt-3">
              <p class="text-body-1 text-medium-emphasis mt-2">
                Нет аккаунта?
                <NuxtLink
                  class="font-weight-medium text-primary"
                  to="/register"
                >
                  Регистрация
                </NuxtLink>
              </p>
            </p>
            <div class="mt-10">
              <VBtn
                :disabled="!valid"
                :loading="loading"
                block
                class="gradient primary font-weight-bold text-body-2"
                flat
                min-height="45"
                type="submit"
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

<script lang="js" setup>
useHead({title: 'Вход'});
// definePageMeta({ middleware: 'auth' });
const router = useRouter();
import {useAuthStore} from "~/store/auth";

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
    router.push('/config');
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
const isUsernameEmail = computed(() => {
  const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
  return pattern.test(username.value);
});
const isUsernamePhone = computed(() => /^\d+$/.test(username.value) && username.value.toString().length > 9);
const valid = computed(() => (isUsernameEmail || isUsernamePhone) && !!password.value);

const submit = async () => {
  try {
    await authStore.authenticateUser({username, password});
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
