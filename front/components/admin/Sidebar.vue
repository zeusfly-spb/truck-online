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
          <v-list-item to="/profile/companies" v-if="shouldShowSidebar">
              <v-list-item-title>Companies</v-list-item-title>
          </v-list-item>
          <v-list-item to="/profile/drivers" v-if="shouldShowSidebar">
              <v-list-item-title>Drivers</v-list-item-title>
          </v-list-item>
          <v-list-item to="/profile/addresses" v-if="shouldShowSidebar">
              <v-list-item-title>Addresses</v-list-item-title>
          </v-list-item>
          <v-list-item to="/profile/containers" v-if="shouldShowSidebar">
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
const userRoles = ref([]);
const userStore = useAuthStore();


 const shouldShowSidebar = computed( async () => {

  //const userRoles = ['execute'];
 userRoles = userStore.user?.roles.map(role => role?.name);
console.log(userRoles)
  return userRoles && userRoles.value && userRoles.value.includes(['execute']);

  console.log(test);

});

</script>
