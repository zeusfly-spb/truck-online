<template>
  <v-menu>
    <template v-slot:activator="{ props }">
      <v-btn v-bind="props">{{ userName }}</v-btn>
    </template>
    <v-list>
      <v-list-item
        v-for="item in items"
        @click="toPage(item.link)"
      >
        <v-list-item-title>
          {{ item.title }}
        </v-list-item-title>
      </v-list-item>
      <v-divider/>
      <v-list-item
        @click="logOut"
      >
        <v-list-item-title>Выход</v-list-item-title>
      </v-list-item>
    </v-list>
  </v-menu>
</template>

<script setup>
import {useAuthStore} from "~/store/auth";

const authStore = useAuthStore();
const userName = computed(() => authStore.userName);
const items = [{title: 'Личный кабинет', link: '/profile'}, {title: 'Настройки', link: '/config'},
  {title: 'Главная', link: '/'}];
const logOut = async () => {
  await authStore.logUserOut();
}
const toPage = async link => {
  await navigateTo(link);
}
</script>

<style lang="scss" scoped>
a, u {
  text-decoration: none;
}
</style>
