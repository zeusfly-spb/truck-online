<template>
  <v-navigation-drawer app>
      <v-list>
        <v-list-item-group>
          <v-list-item to="/admin">
            <v-list-item-content>
              <v-list-item-title>Home</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item to="/admin/users">
            <v-list-item-content>
              <v-list-item-title>Users</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item to="/admin/drivers">
            <v-list-item-content>
              <v-list-item-title>Drivers</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item to="/admin/addresses">
            <v-list-item-content>
              <v-list-item-title>Addresses</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>
</template>
