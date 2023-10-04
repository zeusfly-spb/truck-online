<template>
  <Sidebar />
  <v-container>
    <table>
      <tr>
        <th>Name</th>
        <td>Weight</td>
        <td>Kit</td>
        <td>Options</td>
      </tr>
      <tbody>
        <tr v-for="container in allContainers" :key="container.name">
          <td>{{ container.name }}</td>
          <td>{{ container.weight }}</td>
          <td>{{ container.kit }}</td>
          <td>
            <v-col>
              <v-menu>
                <template v-slot:activator="{ props }">
                  <v-btn icon="mdi-dots-vertical" v-bind="props"></v-btn>
                </template>

                <v-list>
                  <v-list-item :to="`containers/${container.id}`">
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
import { useContainersStore } from "~/store/admin/containers/containers";
const containerStore = useContainersStore();
onBeforeMount(() => {
  containerStore.getAllContainers()
})
const allContainers = computed(() => {
  if (!containerStore.containers || containerStore.loading) return [];
  return containerStore.containers;
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
