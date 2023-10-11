<template>
  <v-navigation-drawer app>
      <v-list>
           <!-- {{ allRoles }} {{ userRoles }} -->
           {{ userRoles }}
          <v-list-item to="/profile">
              <v-list-item-title>Home</v-list-item-title>
          </v-list-item>
          <v-list-item to="/profile/users"  v-if="shouldShowSidebar">
              <v-list-item-title>Users</v-list-item-title>
          </v-list-item>
          <v-list-item to="/profile/companies">
              <v-list-item-title>Companies</v-list-item-title>
          </v-list-item>
          <v-list-item to="/profile/drivers">
              <v-list-item-title>Drivers</v-list-item-title>
          </v-list-item>
          <v-list-item to="/profile/addresses">
              <v-list-item-title>Addresses</v-list-item-title>
          </v-list-item>
          <v-list-item to="/profile/containers">
              <v-list-item-title>Containers</v-list-item-title>
          </v-list-item>
          <v-list-item to="/profile/carTypes">
              <v-list-item-title>CarTypes</v-list-item-title>
          </v-list-item>
          <v-list-item to="/profile/orders">
              <v-list-item-title>Orders</v-list-item-title>
          </v-list-item>
          <v-list-item to="/profile/calcHistory">
              <v-list-item-title>CalcHistory</v-list-item-title>
          </v-list-item>
      </v-list>
    </v-navigation-drawer>
</template>
<script setup>
import { onBeforeMount } from "vue";
import { useAuthStore } from "~/store/auth";
const userStore = useAuthStore();

 const userRoles = ref([]);
 const shouldShowSidebar = computed(() => {

  //userRoles.value = ['execute'];
  userRoles = userStore.user?.roles.map(role => role?.name);
  return userRoles && userRoles.value && userRoles.value.includes('driver');
});

// async function shouldShow(allowedRoles) {
//     return allowedRoles.some(role => hasAccess(role));
// }
// const hasAccess = computed(() => {
//   const test = ['manager', 'admin'];
//       return test.includes(role);
// })

// const allRoles = computed(() => {
//   if (!rolesStore.roles || rolesStore.loading) return [];
//   const roleNames = rolesStore.roles.map(role => role.name);
//   return roleNames;
// });
// async function userHasAccess(role){
//   return userRoles && userRoles.value && userRoles.value.includes(role);
//   console.log("here")
// }
</script>
