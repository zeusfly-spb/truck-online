<template>
  <v-container class="mb-2 bg-white">
    <v-row class="filter-container">
      <v-col cols="12" md="2">
        <label for="priceFilter">Price Filter:</label>
        <v-text-field
          type="number"
          id="priceFilter"
          v-model="priceFilter"
          @input="applyFilters"
        >
        </v-text-field>
      </v-col>
      <v-col cols="12" md="2">
        <label for="priceFilter">Weight Filter:</label>
        <v-text-field
          type="number"
          id="weightFilter"
          v-model="weightFilter"
          @input="applyFilters"
        >
        </v-text-field>
      </v-col>
    </v-row>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>From Address</th>
          <th>Delivery Address</th>
          <th>Container</th>
          <th>Weight</th>
          <th>Price</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="order in orders" :key="order.id">
          <td>{{ order.id }}</td>
          <td>{{ order.from_address.name }}</td>
          <td>{{ order.delivery_address.name }}</td>
          <td>{{ order.container.name }}</td>
          <td>{{ order.weight }}</td>
          <td>{{ order.price }}</td>
          <td>{{ order.status.name }}</td>
        </tr>
      </tbody>
    </table>
    <div class="pagination">
      <button @click="loadPage(ordersMeta.prev)" :disabled=!ordersMeta.prev>Previous</button>
      <button @click="loadPage(ordersMeta.next)" :disabled=!ordersMeta.next>Next</button>
    </div>
  </v-container>
</template>
<style>
.bg-white{
  background-color: #fff;
  padding: 50px;
}
.pagination button{
  background-color: #fff;
  padding: 10px;
  border: 1px solid#ddd;
  width: 120px;
}
a { text-decoration: none; }
  table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
  margin-top: 20px;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
.mt-20{
  margin-top:20px
}
</style>

<script setup>
  const { data: addresses } = useFetch(URI+'addresses');
  const orders = ref([]);
  const ordersMeta = {
      prev: null,
      next: null,
      current_page: 1
    };
  const priceFilter = ref(null);
  const weightFilter = ref(null);

  const loadPage = async (url) => {
  try {
      const headers = new Headers();
      const token_cookie = useCookie('online_port_token');
    if (token_cookie.value) {
      headers.set("Authorization", `Bearer ${ token_cookie.value }`);
    }
    let query = '';
    if (priceFilter.value) {
      query += `&price=${priceFilter.value}`;
    }
    if (weightFilter.value) {
      query += `&weight=${weightFilter.value}`;
    }

    const response = await $fetch(url+query, { headers });
    orders.value = response.data;
    ordersMeta.prev = response.links.prev;
    ordersMeta.next = response.links.next;
    ordersMeta.current_page = response.meta.current_page;
    console.log(orders.value);
  } catch (error) {
    console.error('Error loading data:', error);
  }
};
// Apply the filters
const applyFilters = () => {
  loadPage(URI+`orders?page=${ordersMeta.current_page}`);
};

onMounted(() => {
  loadPage(URI+'orders?page=1');
});
</script>
