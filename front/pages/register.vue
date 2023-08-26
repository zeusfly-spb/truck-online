<template>
  <v-layout class="rounded rounded-md">
    <v-main
      class="d-flex align-center justify-center flex-column"
      style=" margin-top: 3em!important;"
    >
      <v-card
        class="pa-md-4 mx-lg-auto register-class register-card"
        style="background: transparent!important;"
      >
        <v-card-text
          class="register-class"
        >
          <v-row>
            <v-col>
              <img alt="register_logo" class="logo" src="/register_logo2.png">
              <v-radio-group
                v-model="accountType"
                label="Зарегистрируйте меня как"
              >
                <v-radio label="Заказчик" value="customer"/>
                <v-radio label="Перевозчик" value="transporter"/>
              </v-radio-group>
            </v-col>
            <v-col>
              <v-text-field
                v-model="inn"
                :readonly="companyConfirmed"
                hide-details
                label="ИНН организации"
                placeholder="0000 0000 0000"
              />
              <div
                v-if="company && companyConfirmed"
              >
                <v-icon
                  color="green"
                  icon="mdi-check-bold"
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
                v-model="ndsPayer"
                class="mt-4"
                inline
                label="Являетесь ли вы плательщиком НДС?"
              >
                <v-radio label="Да" value="yes"/>
                <v-radio label="Нет" value="no"/>
              </v-radio-group>
              <v-text-field
                v-model="contactPerson"
                :rules="[]"
                density="compact"
                label="Контактное лицо"
                placeholder="Иванов Иван Иванович"
                required
              />
              <v-text-field
                :model-value="mask.masked(phone)"
                :readonly="phoneConfirmed"
                :rules="[rules.required, rules.phoneLength, rules.digits]"
                density="compact"
                label="Мобильный телефон"
                maxlength="18"
                placeholder="+7 900 000-00-00"
                required
                @update:model-value="value => phone = mask.unmasked(value)"
              >
                <template v-slot:append-inner>
                  <v-icon
                    v-if="phone.length === 10"
                    :color="phoneConfirmed ? 'green' : 'black'"
                    :title="phoneConfirmed ? 'Номер телефона подтвержден' : 'Подтвердить номер телефона'"
                    icon="mdi-check-bold"
                    style="cursor: pointer"
                    @click.prevent="phoneAppendClick"
                  />
                </template>
              </v-text-field>

              <v-text-field
                v-model="email"
                :readonly="emailConfirmed"
                :rules="[rules.required, rules.email]"
                density="compact"
                label="E-mail"
                placeholder="example@mail.ru"
                required
              >
                <template v-slot:append-inner>
                  <v-icon
                    v-if="email.length && isEmail(email)"
                    :color="emailConfirmed ? 'green' : 'black'"
                    :title="emailConfirmed ? 'Адрес email подтвержден' : 'Подтвердить адрес email'"
                    icon="mdi-check-bold"
                    style="cursor: pointer"
                    @click.prevent="emailAppendClick"
                  />
                </template>
              </v-text-field>
              <v-text-field
                v-model="password"
                :rules="[]"
                density="compact"
                label="Пароль"
                required
                type="password"
              />
              <v-text-field
                v-model="passwordConfirm"
                :rules="[]"
                density="compact"
                label="Повтор пароля"
                required
                type="password"
              />
              <v-checkbox
                v-model="processPersonal"
                label="Даю согласие на обработку персональных данных"
              />
              <v-checkbox
                v-model="termsNConditions"
                label="Принимаю пользовательское соглашение и политику конфиденциальности"
              />
              <v-btn
                :disabled="!termsNConditions || !processPersonal || !credentialsConfirmed"
                class="mb-2"
                @click="smartRegister"
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
import {useAuthStore} from "~/store/auth";
import {useConfigStore} from "~/store/config";
import {Mask} from "maska";

const mask = new Mask({mask: '+7 (###) ###-##-##'});
const configStore = useConfigStore();
const authStore = useAuthStore();
const {getCompanyByInn, setValue, registerUser} = authStore;
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
const emailConfirmationStatus = ref('');
const company = computed(() => authStore.company);
const phoneConfirmed = computed({
  get() {
    return configStore.phoneConfirmed;
  },
  set(val) {
    configStore.setValue({key: 'phoneConfirmed', value: val})
  }
});
const emailConfirmed = computed({
  get() {
    return configStore.emailConfirmed;
  },
  set(val) {
    configStore.setValue({key: 'emailConfirmed', value: val})
  }
});
const companyConfirmed = computed({
  get() {
    return configStore.companyConfirmed;
  },
  set(val) {
    configStore.setValue({key: 'companyConfirmed', value: val});
  }
});
const credentialsConfirmed = computed(() => phoneConfirmed.value && emailConfirmed.value && companyConfirmed.value);
const username = computed(() => email.value || phone.value);

watch(email, () => emailConfirmationStatus.value = '');

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
    registerUser({username, password, passwordConfirm, company_id});
  success ? registered() : null;
}

const dialogMode = computed({
  get() {
    return authStore.dialogMode;
  },
  set(val) {
    authStore.setValue({key: 'dialogMode', value: val});
  }
});
const dialogTitle = computed({
  get() {
    return authStore.dialogTitle;
  },
  set(val) {
    authStore.setValue({key: 'dialogTitle', value: val});
  }
});
const dialog = computed({
  get() {
    return authStore.dialog;
  },
  set(val) {
    authStore.setValue({key: 'dialog', value: val});
  }
});

const phoneAppendClick = () => {
  if (phoneConfirmed.value) {
    return;
  }
  dialogMode.value = 'phone';
  dialogTitle.value = 'Код подтверждения телефона';
  dialog.value = true;
}

const emailAppendClick = async () => {
  if (emailConfirmed.value) {
    return;
  }
  if (!emailConfirmationStatus.value) {
    await configStore.getEmailConfirm(email.value);
    if (configStore.newEmailConfirm) {
      useSnack({
        show: true,
        type: 'success',
        title: 'Код подтверждения',
        message: 'На указанный адрес выслан код подтверждения',
      });
    }
    emailConfirmationStatus.value = 'requested';
  }
  if (emailConfirmed.value) {
    return;
  }
  dialogMode.value = 'email';
  dialogTitle.value = 'Код подтверждения email';
  dialog.value = true;
}

const confirmCompany = () => {
  company_id.value = company.value.id;
  configStore.setValue({key: 'companyConfirmed', value: true});
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
  email: value => /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value) || 'Неверный формат email'
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
