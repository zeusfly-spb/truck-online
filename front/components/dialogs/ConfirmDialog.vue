<template>
  <div>
    <v-dialog
      v-model="config.dialog"
      width="20%"
    >
      <v-card>
        <v-card-title>
          {{ config.dialogTitle }}
        </v-card-title>
        <v-card-text>
          <v-text-field
            v-model="config.dialogText"
            @keyup.enter=""
          />
        </v-card-text>
        <v-card-actions>
          <v-btn
            @click=""
          >
            Ok
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script setup>
import { useAuthStore } from "~/store/auth";
const authStore = useAuthStore();
const config = computed(() => authStore.modalConfig);
</script>

<style lang="scss" scoped>

</style>
