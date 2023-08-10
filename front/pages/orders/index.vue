<template>
  <v-container>
    <v-btn
        class="text-none"
        color="grey-lighten-3"
        size="x-large"
        >
      <NuxtLink
        to="/orders/create"
        class=""
      >
        Создать заказ
      </NuxtLink>
    </v-btn>
    <table>
      <tr>
        <th v-for="head in heads">{{ head.title }}</th>
      </tr>
      <tr v-for="order in orders">
        <td>{{ order.id }}</td>
        <td>{{ order.from_address?.name }}</td>
        <td>{{ order.delivery_address?.name }}</td>
        <td>{{ order.container?.name }}</td>
        <td>{{ order.weight }}</td>
        <td>{{ order.price }}</td>
      </tr>
    </table>
    <!-- <v-btn
        class="text-none mb-4"
        color="indigo-darken-3"
        size="large"
        variant="flat"
        @click.prevent="createOrder"
      >
        Create Order
      </v-btn> -->
  </v-container>

</template>
<style>
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
  const headers = new Headers();
  const token_cookie = useCookie('online_port_token');
  if (token_cookie.value) {
    headers.set("Authorization", `Bearer ${ token_cookie.value }`);
  }

  const { data: orders } = await useFetch(URI+'orders',{ headers});
  const itemsPerPage = 5;
  const heads = [
          { title: 'ID', align: 'start', sortable: false, key: 'id'},
          { title: 'From Address', align: 'start', sortable: false, key: 'from_address' },
          { title: 'To Address', align: 'start', sortable: false, key: 'to_address' },
          { title: 'Conatiner', align: 'start', sortable: false, key: 'container' },
          { title: 'Weight', align: 'start', sortable: false, key: 'weight' },
          { title: 'Price', align: 'start', sortable: false, key: 'price' },
        ];
  console.log(orders._rawValue);
  console.log(headers);
</script>
