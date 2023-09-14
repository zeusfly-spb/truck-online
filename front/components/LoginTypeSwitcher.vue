<template>
  <v-btn-toggle
    v-model="loginType"
    :divided="true"
    variant="outlined"
    selected-class="active"
    density="compact"
  >
    <v-btn
      :class="{active: loginType === 'email'}"
      @click="switchLoginType('email')"
      title="Использовать email в качестве имени пользователя"
      icon="mdi-email"
    />
    <v-btn
      :class="{active: loginType === 'phone'}"
      @click="switchLoginType('phone')"
      title="Использовать номер телефона в качестве имени пользователя"
      icon="mdi-phone"
    />
  </v-btn-toggle>
</template>

<script setup>
import {useConfigStore} from "~/store/config";
import {storeToRefs} from "pinia";

const {loginType} = storeToRefs(useConfigStore());
const switchLoginType = type => loginType.value = type;
</script>

<style scoped>
.active {
  color:#2e67b1;
  background-color: rgb(166,186,211);
  border: 1px solid #3700B3;
}
</style>
