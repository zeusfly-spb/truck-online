<template>
  <div
    style="word-wrap: normal"
  >
    <v-dialog v-model="registerDialog" :persistent="true" :width="modalWidth">
      <v-card>
        <v-card-title>
          <v-row class="flex-row">
            <h3 class="ma-3">Регистрация</h3>
            <v-spacer/>
            <v-icon
              title="Отмена"
              class="ma-3 close"
              @click="registerDialog = false"
            >
              mdi-close
            </v-icon>
          </v-row>
        </v-card-title>
        <v-card-text>
          <v-layout class="rounded rounded-md justify-center"  id="reg-row" ref="reg-row">
              <v-card
                class="pa-md-4 mx-lg-auto register-class register-card unselect"
              >
                <v-card-text class="register-class">
                  <v-row>
                    <v-col  v-if="wideScreen">
                      <img
                        alt="register_logo"
                        class="logo"
                        src="/register_logo2.png"
                      />
                      <v-radio-group
                        v-model="accountType"
                        label="Зарегистрируйте меня как"
                      >
                        <v-radio label="Заказчик" value="customer" />
                        <v-radio label="Перевозчик" value="transporter" />
                      </v-radio-group>
                    </v-col>
                    <v-col>
                      <CompanyFinder
                        v-if="companySearchMode === 'str'"
                      />
                      <v-text-field
                        v-if="companySearchMode === 'inn'"
                        v-model="inn"
                        :readonly="companyConfirmed"
                        class="inputInn"
                        hide-details
                        label="ИНН организации"
                        maxLength="12"
                        placeholder="0000 0000 0000"
                        type="number"
                      >
                        <template
                          v-if="!companyConfirmed"
                          v-slot:append-inner
                        >
                          <v-icon
                            @click="companySearchMode = 'str'"
                            color="blue"
                            icon="mdi-file-find-outline"
                            style="cursor: pointer"
                            title="Найти компанию по названию"
                          />
                        </template>
                      </v-text-field>
                      <div v-if="company && companyConfirmed">
                        <v-icon color="green" icon="mdi-check-bold" />
                        {{ company.short_name }}
                      </div>
                      <v-btn
                        v-if="company && !companyConfirmed"
                        color="#BBDEFB"
                        @click="confirmCompany"
                      >
                        {{ company.short_name }}
                      </v-btn>
                      <v-checkbox
                        v-model="ndsPayer"
                        label="Плательщик НДС"
                      />
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
                        :rules="[
                          rules.required,
                          rules.phoneLength,
                          rules.digits,
                        ]"
                        density="compact"
                        label="Мобильный телефон"
                        maxlength="18"
                        placeholder="+7 900 000-00-00"
                        required
                        @update:model-value="
                          (value) => (phone = mask.unmasked(value))
                        "
                      >
                        <template
                          v-if="phone.length === 10"
                          v-slot:append-inner
                        >
                          <v-icon
                            v-if="phoneConfirmed"
                            color="green"
                            icon="mdi-check-bold"
                            style="cursor: pointer"
                            title="'Номер телефона подтвержден"
                          />
                          <small
                            v-else
                            style="cursor: pointer"
                            @click.prevent="phoneAppendClick"
                          >
                            Подтвердить
                          </small>
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
                        <template
                          v-if="email.length && isEmail(email)"
                          v-slot:append-inner
                        >
                          <v-icon
                            v-if="emailConfirmed"
                            color="green"
                            icon="mdi-check-bold"
                            style="cursor: pointer"
                            title="Адрес email подтвержден"
                          />
                          <small
                            v-else
                            style="cursor: pointer"
                            @click.prevent="emailAppendClick"
                          >
                            Подтвердить
                          </small>
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
                      >
                        <template v-slot:append-inner>
                          <v-icon
                            v-if="passwordConfirmValid"
                            color="green"
                            icon="mdi-check-bold"
                            title="Правильный повтор пароля"
                          />
                        </template>
                      </v-text-field>
                      <v-radio-group
                        v-if="!wideScreen"
                        v-model="accountType"
                        label="Зарегистрируйте меня как"
                      >
                        <v-radio label="Заказчик" value="customer" />
                        <v-radio label="Перевозчик" value="transporter" />
                      </v-radio-group>
                      <v-checkbox
                        v-model="processPersonal"
                        label="Даю согласие на обработку персональных данных"
                      />
                      <v-checkbox
                        v-model="termsNConditions"
                        label="Принимаю пользовательское соглашение и политику конфиденциальности"
                      />
                    </v-col>
                  </v-row>
                </v-card-text>
                <v-card-actions class="flex-row justify-center">
                  <v-btn
                    :disabled="
                      !termsNConditions ||
                      !processPersonal ||
                      !credentialsConfirmed ||
                      !passwordConfirmValid
                    "
                    class="mb-2"
                    @click="smartRegister"
                  >
                    Зарегистрироваться
                  </v-btn>
                </v-card-actions>
              </v-card>
          </v-layout>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>
<script setup>
import { storeToRefs } from "pinia";
import { useAuthStore } from "~/store/auth";
import { useConfigStore } from "~/store/config";
import { Mask } from "maska";
import {useDisplay} from "vuetify";
import CompanyFinder from "~/components/CompanyFinder.vue";

const authStore = useAuthStore();
const configStore = useConfigStore();
const { authDialog, registerDialog, dialogMode, dialogTitle, dialog, company } =
  storeToRefs(authStore);
const { phoneConfirmed, emailConfirmed, companyConfirmed, companySearchMode } =
  storeToRefs(configStore);
const mask = new Mask({ mask: "+7 (###) ###-##-##" });
const emailConfirmCode = computed(() => configStore.emailConfirmCode);
const { getCompanyByInn, registerUser } = authStore;
const { name } = useDisplay();
const findCompanyByStr = ref(false);
const accountType = ref("");
const inn = ref("");
const ndsPayer = ref("no");
const contactPerson = ref("");
const phone = ref("");
const email = ref("");
const password = ref("");
const passwordConfirm = ref("");
const processPersonal = ref(false);
const termsNConditions = ref(false);
const emailConfirmationStatus = ref("");
const phoneConfirmationStatus = ref("");
const credentialsConfirmed = computed(
  () => phoneConfirmed.value && emailConfirmed.value && companyConfirmed.value,
);
const username = computed(() => email.value || phone.value);
const passwordConfirmValid = computed(
  () => passwordConfirm.value && passwordConfirm.value === password.value,
);
const displayMode = computed(() => name.value);
const modalWidth = computed(() => wideScreen.value ? '40%' : '100%');
const wideScreen = computed(() => ['lg', 'xl', 'xxl'].includes(displayMode.value));
watch(email, () => (emailConfirmationStatus.value = ""));
watch(phone, () => (phoneConfirmationStatus.value = ""));
const registered = async () => {
  useSnack({
    show: true,
    type: "success",
    title: "Авторизован",
    message: "Вы успешно зарегистрировались в системе",
  });
  goLogin();
};
const company_id = computed(() => company.value && company.value.id);


const goLogin = () => {
  authDialog.value = true;
  registerDialog.value = false;
};
const smartRegister = async () => {
  const success = await registerUser({
    contactPerson,
    email,
    phone,
    password,
    passwordConfirm,
    company_id,
  });
  success ? await registered() : null;
};
const phoneAppendClick = async () => {
  if (!phoneConfirmationStatus.value) {
    await configStore.getPhoneConfirm(phone.value);
    if (configStore.newPhoneConfirm) {
      useSnack({
        show: true,
        type: "success",
        title: "Код подтверждения",
        message: "На указанный номер выслан код подтверждения",
      });
    }
    phoneConfirmationStatus.value = "requested";
  }
  if (phoneConfirmed.value) {
    return;
  }
  dialogMode.value = "phone";
  dialogTitle.value = "Код подтверждения телефона";
  dialog.value = true;
};
const emailAppendClick = async () => {
  if (!emailConfirmationStatus.value) {
    await configStore.getEmailConfirm(email.value);
    if (configStore.newEmailConfirm) {
      useSnack({
        show: true,
        type: "success",
        title: "Код подтверждения",
        message: "На указанный адрес выслан код подтверждения",
      });
    }
    emailConfirmationStatus.value = "requested";
  }
  if (emailConfirmed.value) {
    return;
  }
  dialogMode.value = "email";
  dialogTitle.value = "Код подтверждения email";
  dialog.value = true;
};
const confirmCompany = () => {
  company_id.value = company.value.id;
  configStore.setValue({ key: "companyConfirmed", value: true });
};
watch(inn, async (val) => {
  company.value = null;
  !!val && val.length >= 10 ? await getCompanyByInn(val) : null;
});
const isEmail = (val) => {
  return String(val)
    .toLowerCase()
    .match(
      /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
    );
};
const rules = {
  required: (value) => !!value || "Поле обязательно для заполнения",
  email: (value) =>
    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(
      value,
    ) || "Неверный формат email",
};
watch(registerDialog, val => {
  if (!val) {
    companyConfirmed.value = false;
    company.value = null;
    inn.value = '';
  }
});
</script>
<style lang="css" scoped>
.inputInn >>> input[type="number"] {
  -moz-appearance: textfield;
}

.inputInn >>> input::-webkit-outer-spin-button,
.inputInn >>> input::-webkit-inner-spin-button {
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
}

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

.unselect {
  -webkit-user-select: none;
  /* user-select -- это нестандартное свойство */

  -moz-user-select: none;
  /* поэтому нужны префиксы */

  -ms-user-select: none;
}
</style>
