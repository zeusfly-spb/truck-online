<template>
  <div>
    <v-app>
      <v-app-bar title="PortOnline"/>
      <v-main>
        <Snack></Snack>
        <slot />
      </v-main>
    </v-app>
  </div>
</template>

<script setup lang="ts"></script>
