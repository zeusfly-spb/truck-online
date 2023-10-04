<template>
  <Sidebar />
  <v-container>
    <table>
      <tr>
        <th>Conatiner</th>
        <th>Price</th>
        <th>Weight</th>
        <th>From</th>
        <th>To</th>
        <th>Return</th>
        <th>Tax</th>
        <th>Options</th>
      </tr>
      <tbody>
        <tr v-for="history in allCalcHistories" :key="history.id">
          <td>{{ history.container?.name }}</td>
          <td>{{ history.price }}</td>
          <td>{{ history.weight }}</td>
          <td>{{ history.from_address.name }}</td>
          <td>{{ history.delivery_address.name }}</td>
          <td>{{ history.return_address.name }}</td>
          <td>{{ history.tax_id.name }}</td>
          <td>
            <v-col>
              <v-menu>
                <template v-slot:activator="{ props }">
                  <v-btn icon="mdi-dots-vertical" v-bind="props"></v-btn>
                </template>
                <v-list>
                  <v-list-item :to="`calcHistory/${history.id}`">
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
import { useCalcHistoryStore } from "~/store/admin/calcHistory/calcHistory";
const calcHistoryStore = useCalcHistoryStore();
onBeforeMount(() => {
  calcHistoryStore.getAllCalcHistories()
})
const allCalcHistories = computed(() => {
  if (!calcHistoryStore.calcHistories || calcHistoryStore.loading) return [];
  return calcHistoryStore.calcHistories;
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
