<template>
  <div>
    <v-dialog
      v-model="authDialog"
      :persistent="true"
      width="40%"
    >
      <v-card>
        <v-card-title>
          <v-row
            class="flex-row-reverse"
          >
            <v-icon
              class="ma-3 close"
              @click="authDialog = false"
            >
              mdi-close
            </v-icon>
          </v-row>
        </v-card-title>
        <v-card-text>
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
            Пароль
          </label>
          <VTextField
            id="password"
            v-model="password"
            name="password"
            type="password"
            @keyup.enter="submit"
          />
          <p class="text-medium-emphasis text-body-2 mt-3">
            <p class="text-body-1 text-medium-emphasis mt-2">
              Нет аккаунта?
              <a
                class="font-weight-medium text-primary"
                href=""
                @click.prevent="goRegister"
              >
                Регистрация
              </a>
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
              @click="submit"
            >
              Вход
            </VBtn>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script setup>
import {storeToRefs} from "pinia";
import {useAuthStore} from "~/store/auth";
import {navigateTo} from "#app";

const {authDialog, registerDialog} = storeToRefs(useAuthStore());
const authStore = useAuthStore();
const username = ref('');
const password = ref('');
const loading = computed(() => authStore.loading);
const authenticated = computed(() => authStore.authenticated);
const valid = computed(() => (isUsernameEmail.value || isUsernamePhone.value) && !!password.value);
const isUsernameEmail = computed(() => {
  const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
  return pattern.test(username.value);
});
const isUsernamePhone = computed(() => /^\d+$/.test(username.value) && username.value.toString().length > 9);
const goRegister = () => {
  registerDialog.value = true;
  authDialog.value = false;
}
const submit = async () => {
  try {
    await authStore.authenticateUser({username, password});
    await redirect();
    authDialog.value = false;
  } catch (e) {
    showError();
  }
};
const showError = async () => {
  useSnack({
    show: true,
    type: 'error',
    title: 'Ошибка авторизации!',
    message: 'Проверьте правильность введенных данных',
  });
  const passwordInput = document.getElementById('password');
  passwordInput.removeEventListener('input', evt => console.log(evt));
  passwordInput.removeEventListener('change', evt => console.log(evt));
}
const redirect = async () => {
  if (authenticated.value) {
    useSnack({
      show: true,
      type: 'success',
      title: 'Авторизован',
      message: 'Вы успешно авторизовались в системе',
    });
    await navigateTo('/profile');
  }
}

</script>
