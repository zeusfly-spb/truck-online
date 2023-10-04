<template>
  <Sidebar />
  <v-container>
    <v-table>
    <thead>
      <tr>
        <th class="text-left">
          Name
        </th>
        <th class="text-left">
          Calories
        </th>
      </tr>
    </thead>
    <tbody>
        <tr>
          <td>Container</td>
          <td>{{ historyData.container.name }}</td>
        </tr>
        <tr>
          <td>From address</td>
          <td>{{ historyData.from_address.name }}</td>
        </tr>
        <tr>
          <td>Delivery Address</td>
          <td>{{ historyData.delivery_address.name }}</td>
        </tr>
        <tr>
          <td>Return address</td>
          <td>{{ historyData.return_address.name }}</td>
        </tr>
        <tr>
          <td>Delivery2 Address</td>
          <td>{{ historyData.delivery2_address?.name }}</td>
        </tr>
        <tr>
          <td>Return2 address</td>
          <td>{{ historyData.return2_address?.name }}</td>
        </tr>
        <tr>
          <td>Tax</td>
          <td>{{ historyData.tax_id.name }}</td>
        </tr>
        <tr>
          <td>Price</td>
          <td>{{ historyData.price }}</td>
        </tr>
        <tr>
          <td>Weight</td>
          <td>{{ historyData.weight }}</td>
        </tr>
        <tr>
          <td>Imo</td>
          <td>{{ historyData.imo }}</td>
        </tr>
        <tr>
          <td>Temp reg</td>
          <td>{{ historyData.temp_reg }}</td>
        </tr>
        <tr>
          <td>Is international</td>
          <td>{{ historyData.is_international }}</td>
        </tr>
    </tbody>
  </v-table>
  </v-container>
</template>

<script setup>
  import Sidebar from "~/components/admin/Sidebar.vue";
  const route = useRoute();
  import { useCalcHistoryStore } from "~/store/admin/calcHistory/calcHistory";
  const calcHistoryStore = useCalcHistoryStore();
  onBeforeMount(() => {
    calcHistoryStore.getHistory(`${route.params.id}`)
  })
  const historyData = computed(() => {
  //if (!calcHistoryStore.history || calcHistoryStore.loading) return [];
  return calcHistoryStore.history;
});



</script>
