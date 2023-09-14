<template>
  <div class="d-inline-flex">
    <v-icon
      v-for="(type, index) in types"
      :key="index"
      :icon="`mdi-${type}`"
      @click="switchLoginType(type)"
      :title="loginType !== type ? `Переключить на режим входа по ${type === 'phone'
        ? 'номеру телефона' : 'адресу email'}` : `Текущий режим входа по ${type === 'phone'
        ? 'номеру телефона' : 'адресу email'}`
      "
      :class="{
        active: type === loginType,
        inactive: type !== loginType
      }"
    />
  </div>
</template>

<script setup>
import { useConfigStore } from "~/store/config";
import { storeToRefs } from "pinia";
const types = ['email', 'phone'];
const { loginType } = storeToRefs(useConfigStore());
const switchLoginType = type => loginType.value = type;
</script>

<style scoped>
.active {
  color: #ffffff;
}
.inactive {
  color: #2e67b1;
}
</style>
