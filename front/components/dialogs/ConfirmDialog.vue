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
            id="dialog-text"
            v-model="dialogText"
            autofocus
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
import {storeToRefs} from "pinia";

const authStore = useAuthStore();
const configStore = useConfigStore();
const {dialog, dialogText} = storeToRefs(authStore);

const dialogTitle = computed(() => authStore.dialogTitle);
const dialogMode = computed(() => authStore.dialogMode);
const phoneConfirmCode = computed(() => configStore.phoneConfirmCode);
const emailConfirmCode = computed(() => configStore.emailConfirmCode);

watch(dialog, val => !val ? dialogText.value = '' : null);

const setValues = async () => {
  if (dialogMode.value === 'phone' && dialogText.value === phoneConfirmCode.value) {
    await configStore.markPhoneConfirmation(configStore.phoneConfirmation.phone);
    dialog.value = false;
    useSnack({
      show: true,
      type: 'success',
      title: 'Подтвержден',
      message: 'Номер телефона успешно подтвержден',
    });
  }
  if (dialogMode.value === 'email' && dialogText.value.toString() === emailConfirmCode.value.toString()) {
    await configStore.markEmailConfirmation(configStore.emailConfirmation.email);
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
