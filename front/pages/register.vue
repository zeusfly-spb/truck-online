<template>
  <v-layout class="rounded rounded-md">
    <v-dialog
      v-model="dialog"
      width="30%"
    >
      <v-card>
        <v-card-title>
          {{ dialogTitle }}
        </v-card-title>
        <v-card-text>
          <v-text-field
            v-model="dialogText"
            @keyup.enter="dialogEnter"
          />
        </v-card-text>
        <v-card-actions>
          <v-btn
            @click="dialogEnter"
          >
            Ok
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-main
        class="d-flex align-center justify-center flex-column"
        style="margin-top: 3em!important;"
      >
      <v-form>
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
                </v-radio-group>
              </v-col>
              <v-col>
                <v-text-field
                  hide-details
                  label="ИНН организации"
                  v-model="inn"
                  placeholder="0000 0000 0000"
                />
                <v-btn
                  v-if="innInfo"
                  color="#BBDEFB"
                >
                  {{ innInfo }}
                </v-btn>
                <v-radio-group
                  inline
                  label="Являетесь ли вы плательщиком НДС?"
                  v-model="ndsPayer"
                >
                  <v-radio label="Да" value="yes"/>
                  <v-radio label="Нет" value="no"/>
                </v-radio-group>
                <v-text-field
                  required
                  :rules="[]"
                  label="Контактное лицо"
                  v-model="contactPerson"
                  placeholder="Иванов Иван Иванович"
                  density="compact"
                />
                <v-text-field
                  required
                  :rules="[rules.required, rules.phoneLength]"
                  label="Мобильный телефон"
                  v-model="phone"
                  placeholder="+7 900 000-00-00"
                  density="compact"
                >
                  <template v-slot:append-inner>
                    <v-icon
                      v-if="phone.length === 10"
                      @click.prevent="phoneAppendClick"
                      :color="phoneConfirmed ? 'green' : null "
                      style="cursor: pointer"
                      icon="mdi-check-bold"
                    />
                  </template>
                </v-text-field>

                <v-text-field
                  required
                  :rules="[]"
                  label="E-mail"
                  v-model="email"
                  placeholder="example@mail.ru"
                  density="compact"
                />
                <v-text-field
                  required
                  :rules="[]"
                  label="Пароль"
                  v-model="password"
                  type="password"
                  density="compact"
                />
                <v-text-field
                  required
                  :rules="[]"
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
      </v-form>
    </v-main>

  </v-layout>
</template>

<script setup>
import {useAuthStore} from "~/store/auth";
const authStore = useAuthStore();
const {getCompanyByInn} = authStore;
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
const company_id = ref('');

const innInfo = computed(() => authStore.innInfo);

watch(inn, async val => {
  !!val && val.length >= 10 ? await getCompanyByInn(val) : null;
});
const {registerUser} = authStore;
const username = computed(() => email.value || phone.value);
const value = computed(() => authStore.innInfo);
const registered = async () => {
  useSnack({
    show: true,
    type: 'success',
    title: 'Авторизован',
    message: 'Вы успешно зарегистрировались в системе',
  });
  await navigateTo('/login');
}

const dialog = ref(false);

const smartRegister = async () => {
  const success = await
      registerUser({username, password, passwordConfirm, inn, value});
  success ? registered() : null;
}

const phoneConfirmed = ref(false);

const rules = {
  required: value => !!value || 'Поле обязательно для заполнения',
  phoneLength: value => value.toString().length === 10 || 'Телефон должен быть длинной 10 цифр'
}

const phoneCode = '9898';

const dialogTitle = ref('');
const dialogMode = ref('');
const dialogText = ref('');

const dialogEnter = () => {
  if (dialogMode.value === 'phone' && dialogText.value === phoneCode) {
    phoneConfirmed.value = true;
  }
}
const phoneAppendClick = () => {
  dialogMode.value = 'phone';
  dialogTitle.value = 'Введите код подтверждения телефона: ';
  dialog.value = true;
}

</script>

<style lang="css" scoped>
.logo {
  width: 300px;
}

.register-class {
  margin: 0 !important;
  padding: 0 !important;
}

.register-card {
  width: 650px;
}
</style>
