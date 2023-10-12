<template>
  <v-navigation-drawer app>
      <v-list>
           <!-- {{ allRoles }} {{ userRoles }} -->
           {{ data.userRoles }}
          <v-list-item to="/profile">
              <v-list-item-title>Home</v-list-item-title>
          </v-list-item>
          <v-list-item to="/profile/users">
              <v-list-item-title>Users</v-list-item-title>
          </v-list-item>
          <v-list-item to="/profile/companies" v-show="hasRoles(['super-admin'])">
              <v-list-item-title>Companies</v-list-item-title>
          </v-list-item>
          <v-list-item to="/companyconfig" v-show="!hasRoles(['super-admin'])">
              <v-list-item-title>Company config</v-list-item-title>
          </v-list-item>
          <v-list-item to="/profile/drivers">
              <v-list-item-title>Drivers</v-list-item-title>
          </v-list-item>
          <v-list-item to="/profile/addresses">
              <v-list-item-title>Addresses</v-list-item-title>
          </v-list-item>
          <v-list-item to="/profile/containers" v-show="hasRoles(['super-admin'])">
              <v-list-item-title>Containers</v-list-item-title>
          </v-list-item>
          <v-list-item to="/profile/carTypes" v-show="hasRoles(['super-admin'])">
              <v-list-item-title>CarTypes</v-list-item-title>
          </v-list-item>
          <v-list-item to="/profile/orders" v-show="hasRoles(['super-admin','driver'])">
              <v-list-item-title>Orders</v-list-item-title>
          </v-list-item>
          <v-list-item to="/profile/calcHistory" v-show="hasRoles(['super-admin','driver'])">
              <v-list-item-title>CalcHistory</v-list-item-title>
          </v-list-item>
      </v-list>
    </v-navigation-drawer>
</template>
<script setup>
import { useAuthStore } from "~/store/auth";
const userStore = useAuthStore();
const data = reactive({
  userRoles: ['customer'],
  roles: []
});
onBeforeMount(async () => {
  //await userStore.getUserDetails()
});
data.userRoles = computed( () => {
  const rolesUserStore = userStore.user?.roles.map(role => role?.name);
  return rolesUserStore ?? [];
});
const hasRoles = (targetRoles) => {
  return targetRoles.some(role => data.userRoles.includes(role));
};
</script>
