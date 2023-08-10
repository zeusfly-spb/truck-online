<template>
  <v-layout class="rounded rounded-md">
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
                  :readonly="companyConfirmed"
                />
                <div
                  v-if="company && companyConfirmed"
                >
                  <v-icon
                    icon="mdi-check-bold"
                    color="green"
                  />
                  {{ company.short_name }}
                </div>
                <v-btn
                  v-if="company && !companyConfirmed"
                  color="#BBDEFB"
                  @click="confirmCompany"
                >
                  {{ company.short_name }}
                </v-btn>
                <v-radio-group
                  class="mt-4"
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
                  :rules="[rules.required, rules.phoneLength, rules.digits]"
                  label="Мобильный телефон"
                  v-model="phone"
                  placeholder="+7 900 000-00-00"
                  density="compact"
                  :readonly="phoneConfirmed"
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
                  :rules="[rules.required, rules.email]"
                  label="E-mail"
                  v-model="email"
                  placeholder="example@mail.ru"
                  density="compact"
                  :readonly="emailConfirmed"
                >
                  <template v-slot:append-inner>
                    <v-icon
                      v-if="email.length && isEmail(email)"
                      @click.prevent="emailAppendClick"
                      :color="emailConfirmed ? 'green' : null "
                      style="cursor: pointer"
                      icon="mdi-check-bold"
                    />
                  </template>
                </v-text-field>
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
                  :disabled="!termsNConditions || !processPersonal || !credentialsConfirmed"
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
const { getCompanyByInn, setModalConfigField, setRegistrationStepsField } = authStore;
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
const company = computed(() => authStore.company);
const phoneConfirmed = computed(() => authStore.registrationSteps.phoneConfirmed);
const emailConfirmed = computed(() => authStore.registrationSteps.emailConfirmed);
const companyConfirmed = computed({
  get () {
    return authStore.registrationSteps.companyConfirmed;
  },
  set(val) {
    setRegistrationStepsField({key: 'companyConfirmed', value: val})
  }
});
const credentialsConfirmed = computed(() => phoneConfirmed.value && emailConfirmed.value && companyConfirmed.value);
const username = computed(() => email.value || phone.value);


const { registerUser } = authStore;

const registered = async () => {
  useSnack({
    show: true,
    type: 'success',
    title: 'Авторизован',
    message: 'Вы успешно зарегистрировались в системе',
  });
  await navigateTo('/login');
}
const company_id = computed(() => company.value && company.value.id);

const smartRegister = async () => {
  const success = await
      registerUser({username, password, passwordConfirm, company_id });
  success ? registered() : null;
}



const phoneCode = '9898';
const emailCode = '9898';

const dialog = computed({
  get() {
    return authStore.confirmDialog.dialog;
  },
  set (val) {
    setModalConfigField({key: 'dialog', value: val});
  }
});

const dialogMode = computed({
  get() {
    return authStore.confirmDialog.dialogMode;
  },
  set(val) {
    setModalConfigField({key: 'confirmDialog', value: val});
  }
});

const dialogTitle = computed({
  get() {
    return authStore.confirmDialog.dialogTitle
  },
  set(val) {
    setModalConfigField({key: 'dialogTitle', value: val})
  }
});

const dialogEnter = () => {
  // if (dialogMode.value === 'phone' && dialogText.value === phoneCode) {
  //   phoneConfirmed.value = true;
  //   return dialog.value = false;
  // }
  // if (dialogMode.value === 'email' && dialogText.value === emailCode) {
  //   emailConfirmed.value = true;
  //   return dialog.value = false;
  // }
}
const phoneAppendClick = () => {
  if (phoneConfirmed.value) {
    return phoneConfirmed.value = false;
  }
  dialogMode.value = 'phone';
  dialogTitle.value = 'Введите код подтверждения телефона: ';
  dialog.value = true;
}

const emailAppendClick = () => {
  if (emailConfirmed.value) {
    return emailConfirmed.value = false;
  }
  dialogMode.value = 'email';
  dialogTitle.value = 'Введите код подтверждения электронной почты';
  dialog.value = true;
}


const confirmCompany = () => {
  company_id.value = company.value.id;
  companyConfirmed.value = true;
}

watch(inn, async val => {
  !!val && val.length >= 10 ? await getCompanyByInn(val) : null;
});

const isEmail = (val) => {
  return String(val)
    .toLowerCase()
    .match(
      /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );
};

const rules = {
    required: value => !!value || 'Поле обязательно для заполнения',
    phoneLength: value => value.toString().length === 10 || 'Телефон должен быть длиной 10 цифр',
    digits: value => /^\d+$/.test(value) || 'Допустимы только цифровые значения',
    email: value =>  /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value) || 'Неверный формат email'
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
