<template>
  <v-navigation-drawer app>
      <v-list>
        <v-list-item-group>
          <v-list-item to="/profile">
            <v-list-item-content>
              <v-list-item-title>Home</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item to="/profile/users">
            <v-list-item-content>
              <v-list-item-title>Users</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item to="/profile/companies">
            <v-list-item-content>
              <v-list-item-title>Companies</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item to="/profile/drivers">
            <v-list-item-content>
              <v-list-item-title>Drivers</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item to="/profile/addresses">
            <v-list-item-content>
              <v-list-item-title>Addresses</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item to="/profile/containers">
            <v-list-item-content>
              <v-list-item-title>Containers</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item to="/profile/carTypes">
            <v-list-item-content>
              <v-list-item-title>CarTypes</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item to="/profile/orders">
            <v-list-item-content>
              <v-list-item-title>Orders</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item to="/profile/calcHistory">
            <v-list-item-content>
              <v-list-item-title>CalcHistory</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>
</template>
