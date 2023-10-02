<template>
  <div>
    <v-dialog v-model="authDialog" :persistent="true" :width="modalWidth" :height="modalHeight">
      <v-card>
        <v-card-title>
          <v-row class="flex-row-reverse">
            <v-icon title="Закрыть" class="ma-3 close" @click="close">
              mdi-close
            </v-icon>
          </v-row>
        </v-card-title>
        <v-card-text class="unselectable">
          <label
            class="font-weight-medium mt-2 d-block mb-1 text-body-2"
            for="username"
          >
            <span v-if="loginType==='email'">Email</span>
            <span v-else>Номер телефона</span>
          </label>
          <VTextField
            hide-details
            placeholder="email@email.ru"
            v-if="loginType === 'email'"
            id="username"
            v-model="username"
            type="email"
            density="compact"
          >
            <template v-slot:prepend-inner>
              <LoginTypeSwitcher/>
            </template>
          </VTextField>
          <VTextField
            hide-details
            placeholder="+7(900) 500-55-55"
            :model-value="mask.masked(username)"
            density="compact"
            maxlength="18"
            @update:model-value="(value) => (username = mask.unmasked(value))"
            v-if="loginType === 'phone'"
            id="username"
          >
            <template v-slot:prepend-inner>
              <LoginTypeSwitcher/>
            </template>
          </VTextField>
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
            @keyup.enter="submit"
            :type="show ? 'text' : 'password'"
            density="compact"
          >
            <template v-slot:append-inner>
              <v-icon
                :icon="show ? 'mdi-eye' : 'mdi-eye-off'"
                @click="show = !show"
              />
            </template>
          </VTextField>
          <p class="text-medium-emphasis text-body-2 mt-3">
            Нет аккаунта?
            <a
              class="font-weight-medium text-primary"
              href=""
              @click.prevent="goRegister"
            >
              Регистрация
            </a>
          </p>
          <div class="mt-10">
            <VBtn
              :disabled="!valid"
              :loading="loading"
              :block="true"
              class="gradient primary font-weight-bold text-body-2"
              :flat="true"
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
import {useConfigStore} from "~/store/config";
import {Mask} from "maska";
import {useDisplay} from "vuetify";

const mask = new Mask({mask: "+7 (###) ###-##-##"});
const show = ref(false);
const {loginType} = storeToRefs(useConfigStore());
const { name } = useDisplay();
const displayMode = computed(() => name.value);
const modalWidth = computed(() => wideScreen.value ? '30%' : '100%');
const wideScreen = computed(() => ['xl', 'xxl'].includes(displayMode.value));
watch(loginType, () => {
  username.value = "";
});
const {authDialog, registerDialog} = storeToRefs(useAuthStore());
const authStore = useAuthStore();
const username = ref("");
const password = ref("");
const loading = computed(() => authStore.loading);
const authenticated = computed(() => authStore.authenticated);
const valid = computed(() => (isUsernameEmail.value || isUsernamePhone.value) && !!password.value);
const isUsernameEmail = computed(() => {
  const pattern =
    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return pattern.test(username.value);
});
const close = () => authDialog.value = false;
const isUsernamePhone = computed(() => /^\d+$/.test(username.value) && username.value.toString().length > 9);
const goRegister = () => {
  authDialog.value = false;
  registerDialog.value = true;
};
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
    type: "error",
    title: "Ошибка авторизации!",
    message: "Проверьте правильность введенных данных",
  });
  const passwordInput = document.getElementById("password");
};
const redirect = async () => {
  if (authenticated.value) {
    useSnack({
      show: true,
      type: "success",
      title: "Авторизован",
      message: "Вы успешно авторизовались в системе",
    });
    await navigateTo("/profile");
  }
};
</script>
