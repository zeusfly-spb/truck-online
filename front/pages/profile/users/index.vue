<template>
  <Sidebar />
  <v-container>
    <table>
      <tr>
        <th>ID</th>
        <th>FirstName</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Company</th>
        <th>Options</th>
      </tr>
      <tbody>
        <tr v-for="user in allUsers" :key="user.name">
          <td>{{ user.id }}</td>
          <td>
            {{ user.first_name }} {{ user.middle_name }}
            {{ user.last_name }}
          </td>
          <td>{{ user.email }}</td>
          <td>{{ user.phone }}</td>
          <td>{{ user?.company?.inn }}</td>
          <td>
            <v-col>
              <v-menu>
                <template v-slot:activator="{ props }">
                  <v-btn icon="mdi-dots-vertical" v-bind="props"></v-btn>
                </template>

                <v-list>
                  <v-list-item :to="`config`">
                    <v-list-item-title>Edit</v-list-item-title>
                  </v-list-item>
                </v-list>
              </v-menu>
            </v-col>
          </td>
        </tr>
    </tbody>
    </table>
  </v-container>
</template>
<script setup>
import Sidebar from "~/components/admin/Sidebar.vue";
import { onBeforeMount } from "vue";
import { useUsersStore } from "~/store/admin/users/users";
const userStore = useUsersStore();
onBeforeMount(() => {
 userStore.getAllUsers()
})
const allUsers = computed(() => {
  if (!userStore.users || userStore.loading) return [];
  return userStore.users;
});
</script>
<style scoped>
  .filters {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    margin-top: 20px;
    align-items: center;
  }

  .label {
    width: 100%;
    text-align: center;
    font-weight: bold;
  }

  .filter {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  a {
    text-decoration: none;
  }
  table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
    margin-top: 20px;
  }

  td,
  th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
    font-size: 2.5vh;
  }

  tr:nth-child(even) {
    background-color: #8d8a8a;
    color: black;
  }
  .mt-20 {
    margin-top: 20px;
  }
  .my-3 {
    display: flex;
    align-items: center;
    justify-content: space-evenly;
  }
  .header-wrapper {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .header-wrapper span {
    cursor: pointer;
    padding-right: 4px;
  }

  @media (max-width: 496px) {
    td,
    th {
      font-size: 1vh;
    }
  }
  @media (max-width: 386px) {
    td,
    th {
      font-size: 0.8vh;
    }
  }
</style>
