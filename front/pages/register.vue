<template>
  <v-layout class="rounded rounded-md">
    <v-main
      class="d-flex align-center justify-center flex-column"
      style="margin-top: 3em!important;"
    >
      <v-card
        class="pa-md-4 mx-lg-auto register-class register-card"
      >
        <v-card-text
          class="register-class"
        >
          <v-row>
            <v-col>
              <img src="/register_logo.png" alt="register_logo" class="logo">
              <v-radio-group
                label="Зарегистрируйте меня как"
                v-model="accountType"
              >
                <v-radio label="Заказчик" value="customer"/>
                <v-radio label="Перевозчик" value="transporter"/>
                <v-radio label="Владелец уборочной техники" value="equipment_owner"/>
                <v-radio label="Агент терминала" value="terminal_agent"/>
              </v-radio-group>
            </v-col>
            <v-col>
              <v-combobox
                label="ИНН организации"
                :items="innItems"
                v-model="inn"
                placeholder="0000 0000 0000"
              />
              <v-radio-group
                inline
                label="Являетесь ли вы плательщиком НДС?"
                v-model="ndsPayer"
              >
                <v-radio label="Да" value="yes"/>
                <v-radio label="Нет" value="no"/>
              </v-radio-group>
              <v-text-field
                label="Контактное лицо"
                v-model="contactPerson"
                placeholder="Иванов Иван Иванович"
                density="compact"
              />
              <v-text-field
                label="Мобильный телефон"
                v-model="phone"
                placeholder="+7 900 000-00-00"
                density="compact"
              />
              <v-text-field
                label="E-mail"
                v-model="email"
                placeholder="example@mail.ru"
                density="compact"
              />
              <v-text-field
                label="Пароль"
                v-model="password"
                type="password"
                density="compact"
              />
              <v-text-field
                label="Повтор пароля"
                v-model="passwordConfirm"
                type="password"
                density="compact"
              />
              <v-checkbox
                label="Даю согласие на обработку персональных данных"
                v-model="processPersonal"
              />
              <v-checkbox
                label="Принимаю пользовательское соглашение и политику конфиденциальности"
                v-model="termsNConditions"
              />
              <v-btn
                :disabled="!termsNConditions || !processPersonal"
                @click="smartRegister"
                class="mb-2"
              >
                Зарегистрироваться
              </v-btn>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </v-main>
  </v-layout>
</template>

<script setup>
import { useAuthStore } from "~/store/auth";
const authStore = useAuthStore();
const { getCompanyByInn } = authStore;
const accountType = ref('');
const inn = ref('');
const ndsPayer = ref('no');
const contactPerson = ref('');
const phone = ref('');
const email = ref('');
const password = ref('');
const passwordConfirm = ref('');
const processPersonal = ref(false);
const termsNConditions = ref(false);
const innItems = ref([]);
const innInfo = computed(() => authStore.innInfo);
watch(innInfo, val => !!val ? innItems.value.push(val) : null)
watch(inn, async val => !!val && val.length >= 10 ? await getCompanyByInn(val) : null);
const { registerUser } = authStore;
const username = email.value || phone.value;
registerUser({ username, password,
    password_confirmation: passwordConfirm, inn });
</script>

<style lang="css" scoped>
.logo {
  width: 300px;
}
.register-class {
  margin: 0!important;
  padding: 0!important;
}
.register-card {
  width: 650px;
}
</style>
