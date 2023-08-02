<template>
  <v-layout class="rounded rounded-md">
    <v-main
      class="d-flex align-center justify-center flex-column"
      style="min-height: 300px;"
    >
      <h3>Регистрация</h3>
      <v-card
        class="pa-md-4 mx-lg-auto register-class register-card"
      >
        <v-card-text
          class="register-class"
        >
          <v-row>
            <v-col>
              <img src="/register_logo.png" alt="register_logo" class="logo">
              <v-radio-group
                label="Зарегистрируйте меня как"
                v-model="accountType"
              >
                <v-radio label="Заказчик" value="customer"></v-radio>
                <v-radio label="Перевозчик" value="transporter"></v-radio>
                <v-radio label="Владелец уборочной техники" value="equipment_owner"></v-radio>
                <v-radio label="Агент терминала" value="terminal_agent"></v-radio>
              </v-radio-group>
            </v-col>
            <v-col>
              <v-text-field
                label="ИНН организации"
                v-model="inn"
                placeholder="0000 0000 0000"
              />
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </v-main>
  </v-layout>
</template>

<script setup>
const accountType = ref('');
const inn = ref('');
</script>

<style lang="css" scoped>
.logo {
  width: 250px;
}
.register-class {
  margin: 0!important;
  padding: 0!important;
}
.register-card {
  width: 500px;
}
</style>
