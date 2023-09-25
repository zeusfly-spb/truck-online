<template>
  <v-container>
    <v-btn class="text-none" color="grey-lighten-3" size="x-large">
      <NuxtLink to="/orders/create" class=""> Создать заказ </NuxtLink>
    </v-btn>
    <v-btn @click="clickShowFilter" size="x-large" style="float: right">
      Фильтры
    </v-btn>
    <div class="filters" v-if="showFilters">
      <div class="filter">
        <div class="label">Цена:</div>
        <div>
          <v-text-field
            label="Цена от"
            variant="solo"
            style="width: 220px"
            v-model="priceFromFilter"
          ></v-text-field>
        </div>
        <div>
          <v-text-field
            label="Цена до"
            variant="solo"
            style="width: 220px"
            v-model="priceToFilter"
          ></v-text-field>
        </div>
      </div>
      <div class="filter">
        <v-select
          label="Тип контейнера"
          :items="['20 f', '40 f', '20 f + 20 f']"
          variant="solo"
          multiple
          style="width: 115px"
          v-model="selectedContainerTypes"
        ></v-select>
      </div>
      <div class="filter">
        <v-select
          label="Status"
          :items="['false', 'true']"
          multiple
          variant="solo"
          style="width: 115px"
          v-model="statusChosen"
        ></v-select>
      </div>
      <div class="filter">
        <div class="label">Вес:</div>
        <div>
          <v-text-field
            label="Вес от"
            variant="solo"
            style="width: 220px"
            v-model="weightFromFilter"
          ></v-text-field>
        </div>
        <div>
          <v-text-field
            label="Вес до"
            variant="solo"
            style="width: 220px"
            v-model="weightToFilter"
          ></v-text-field>
        </div>
      </div>
    </div>
    <table>
      <tr>
        <th>
          <div class="header-wrapper">
            <span>ID</span> <span @click="sortOrders('id')">⇅</span>
          </div>
        </th>
        <th>From Address</th>
        <th>To Address</th>
        <th>Conatiner</th>
        <th>
          <div class="header-wrapper">
            <span>Weight</span>
            <span @click="sortOrders('weight')">⇅</span>
          </div>
        </th>
        <th>
          <div class="header-wrapper">
            <span>Price</span>
            <span @click="sortOrders('price')">⇅</span>
          </div>
        </th>
        <th>Status</th>
      </tr>
      <tr v-for="order in paginatedOrders" :key="order.id">
        <td>{{ order.id }}</td>
        <td>{{ order.fromAddress }}</td>
        <td>{{ order.deliveryAddress }}</td>
        <td>{{ order.container }}</td>
        <td>{{ order.weight }}</td>
        <td>{{ order.price }}</td>
        <td>{{ order.status }}</td>
      </tr>
    </table>
    <div class="my-3">
      <v-btn @click="currentPage > 1 ? currentPage-- : null" color="primary"
        >Предыдущая</v-btn
      >
      Страница {{ currentPage }}
      <v-btn
        @click="currentPage < totalPages ? currentPage++ : null"
        color="primary"
        >Следующая</v-btn
      >
    </div>
  </v-container>
</template>
<script setup>
import { data } from "~/store/dataAddress";
const showFilters = ref(false);
const priceFromFilter = ref("");
const priceToFilter = ref("");
const weightFromFilter = ref("");
const weightToFilter = ref("");
const statusChosen = ref([]);
const selectedContainerTypes = ref([]);

const sortField = ref(null);
const sortOrder = ref(1);
const currentPage = ref(1);
const itemsPerPage = ref(10);

const paginatedOrders = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value;
  const end = start + itemsPerPage.value;
  return sortedOrders.value.slice(start, end);
});

const totalPages = computed(() => {
  return Math.ceil(filteredOrders.value.length / itemsPerPage.value);
});

const filteredOrders = computed(() => {
  const priceFrom =
    priceFromFilter.value === "" ? -Infinity : Number(priceFromFilter.value);
  const priceTo =
    priceToFilter.value === "" ? Infinity : Number(priceToFilter.value);
  const weightFrom =
    weightFromFilter.value === "" ? -Infinity : Number(weightFromFilter.value);
  const weightTo =
    weightToFilter.value === "" ? Infinity : Number(weightToFilter.value);

  return data.filter((order) => {
    const priceInRange = order.price >= priceFrom && order.price <= priceTo;
    const weightInRange =
      order.weight >= weightFrom && order.weight <= weightTo;
    const containerTypeAllowed =
      selectedContainerTypes.value.length === 0 ||
      selectedContainerTypes.value.includes(order.container);
    const statusMatches =
      statusChosen.value.length === 0 ||
      statusChosen.value.includes(String(order.status));

    return (
      priceInRange && weightInRange && containerTypeAllowed && statusMatches
    );
  });
});

const sortOrders = (field) => {
  if (sortField.value === field) {
    sortOrder.value = -sortOrder.value;
  } else {
    sortField.value = field;
    sortOrder.value = 1;
  }
};

const sortedOrders = computed(() => {
  if (!sortField.value) {
    return filteredOrders.value;
  }

  return filteredOrders.value.slice().sort((a, b) => {
    if (a[sortField.value] > b[sortField.value]) {
      return sortOrder.value;
    }
    if (a[sortField.value] < b[sortField.value]) {
      return -sortOrder.value;
    }
    return 0;
  });
});

const clickShowFilter = () => {
  showFilters.value = !showFilters.value;
};
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
  font-size: 1.5vh;
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
