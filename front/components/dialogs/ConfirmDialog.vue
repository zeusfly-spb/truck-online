<template>
  <div>
    <v-dialog
      v-model="dialog"
      width="20%"
    >
      <v-card>
        <v-card-title
          class="text-caption"
          style="word-break: break-word; text-align: center"
        >
          {{ dialogTitle }}
        </v-card-title>
        <v-card-text>
          <v-text-field
            v-model="dialogText"
            @keyup.enter="setValues"
          />
        </v-card-text>
        <v-card-actions>
          <v-spacer/>
          <v-btn
            @click="setValues"
          >
            Ok
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script setup>
import {useAuthStore} from "~/store/auth";
import {useConfigStore} from "~/store/config";

const authStore = useAuthStore();
const {setValue} = authStore;

const dialog = computed({
  get() {
    return authStore.dialog;
  },
  set(val) {
    setValue({key: 'dialog', value: val})
  }
});
const dialogTitle = computed(() => authStore.dialogTitle);
const dialogMode = computed(() => authStore.dialogMode);
const dialogText = computed({
  get() {
    return authStore.dialogText;
  },
  set(val) {
    setValue({key: 'dialogText', value: val})
  }
});

const configStore = useConfigStore();
const phoneConfirmCode = computed(() => configStore.phoneConfirmCode);
const emailConfirmCode = computed(() => configStore.emailConfirmCode);

watch(dialog, val => !val ? dialogText.value = '' : null);

const setValues = () => {
  if (dialogMode.value === 'phone' && dialogText.value === phoneConfirmCode.value) {
    setValue({key: 'phoneConfirmed', value: true});
    dialog.value = false;
    useSnack({
      show: true,
      type: 'success',
      title: 'Подтвержден',
      message: 'Номер телефона успешно подтвержден',
    });
  }
  if (dialogMode.value === 'email' && dialogText.value === emailConfirmCode.value) {
    setValue({key: 'emailConfirmed', value: true});
    dialog.value = false;
    useSnack({
      show: true,
      type: 'success',
      title: 'Подтвержден',
      message: 'Адрес электронной почты успешно подтвержден',
    });
  }
}
</script>
