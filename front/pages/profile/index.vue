<!-- index.vue -->
<template>
  <Sidebar />
</template>
<script setup>
import Sidebar from "~/components/admin/Sidebar.vue";
import { useAuthStore } from "~/store/auth";
import { useRolesStore } from "~/store/roles";
const userStore = useAuthStore();
const rolesStore = useRolesStore();
onBeforeMount(async () => {
   userStore.getUserDetails();
   //rolesStore.getAllRoles();
})
</script>
