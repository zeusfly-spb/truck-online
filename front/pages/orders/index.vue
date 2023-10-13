<template>
  <v-container style="max-width: 2300px; background-color: white">
    <div class="headerOrderTable">
      <h2 class="tableOrders">Таблица заказов</h2>
      <div class="btnsOrderTable">
        <div class="createOrder">
          <v-btn style="background-color: #285795">
            <NuxtLink to="/orders/create" style="color: white">
              Создать заказ
            </NuxtLink>
          </v-btn>
        </div>
        <div class="filtersBtn">
          <v-btn
            @click="clickShowFilter"
            style="background-color: white; color: black"
          >
            Фильтры
          </v-btn>
        </div>
      </div>
    </div>
    <div class="filters" v-if="showFilters">
      <div class="filter-price">
        <p class="label">Цена:</p>
        <div class="filter">
          <v-text-field
            label="Цена от"
            variant="solo"
            v-model="priceFromFilter"
            density="compact"
            single-line
            hide-details
          ></v-text-field>
        </div>
        <div class="filter">
          <v-text-field
            label="Цена до"
            variant="solo"
            v-model="priceToFilter"
            density="compact"
            single-line
            hide-details
          ></v-text-field>
        </div>
      </div>
      <div class="filter-weight">
        <div class="label">Вес:</div>
        <div class="filter">
          <v-text-field
            label="Вес от"
            variant="solo"
            v-model="weightFromFilter"
            density="compact"
            single-line
            hide-details
          ></v-text-field>
        </div>
        <div class="filter">
          <v-text-field
            label="Вес до"
            variant="solo"
            v-model="weightToFilter"
            density="compact"
            single-line
            hide-details
          ></v-text-field>
        </div>
      </div>
      <div class="another-filters">
        <div class="filter">
          <v-select
            label="Тип контейнера"
            :items="['20 f', '40 f', '20 f + 20 f']"
            variant="solo"
            multiple
            v-model="selectedContainerTypes"
            density="compact"
            single-line
            hide-details
          ></v-select>
        </div>
        <div class="filter">
          <v-select
            label="Status"
            :items="['false', 'true']"
            multiple
            variant="solo"
            v-model="statusChosen"
            density="compact"
            single-line
            hide-details
          ></v-select>
        </div>
      </div>
      <div class="deleteFilters">
        <v-btn
          size="x-small"
          @click="deleteFilters"
          class="delFilters"
          height="46px"
          >Сбросить</v-btn
        >
      </div>
    </div>
    <div class="table">
      <v-table style="background-color: white; color: black">
        <thead>
          <tr>
            <th>
              <div class="heade-wrapper" style="color: black">
                <span>ID</span> <span @click="sortOrders('id')">⇅</span>
              </div>
            </th>
            <th style="color: black">Погрузка</th>
            <th style="color: black">Дата погрузки</th>
            <th style="color: black">Cлот</th>
            <th style="color: black">Адрес доставки</th>
            <th style="color: black">Возврат контейнера</th>

            <th style="color: black">Тип контейнера</th>
            <th>
              <div class="header-wrapper">
                <span>Weight</span>
                <span @click="sortOrders('weight')">⇅</span>
              </div>
            </th>
            <th>
              <div class="header-wrapper" style="color: black">
                <span>Price</span>
                <span @click="sortOrders('price')">⇅</span>
              </div>
            </th>
          </tr>
        </thead>
        <tbody style="color: black">
          <template v-for="order in paginatedOrders" :key="order.id">
            <tr @click="paramsOrder(order.id)" style="cursor: pointer">
              <td>{{ order.id }}</td>
              <td>{{ order.from_address.name }}</td>
              <td>{{ order.from_date }}</td>
              <td>{{ order.from_slot }}</td>
              <td>
                {{ order.delivery_address.name }}, дата доставки:
                <p class="date">
                  {{ order.delivery_date.split("-").reverse().join("-") }}
                </p>
              </td>
              <td>
                {{ order.return_address.name }}, дата возврата:
                <p class="date">
                  {{ order.return_date.split("-").reverse().join("-") }}
                </p>
              </td>
              <td>{{ order.container.name }}</td>
              <td>{{ order.weight }}</td>
              <td>{{ order.price }}</td>
            </tr>
            <tr v-if="selectOrderId === order.id" class="dopParams">
              <div>Вес: {{ oneOrder.weight }} Цена: {{ oneOrder.price }}</div>
              <v-btn>Принять</v-btn>
            </tr>
          </template>
        </tbody>
      </v-table>
    </div>
    <div v-intersect="onIntersect" class="observer">Загрузка...</div>
  </v-container>
</template>
<script setup>
import { useOrdersStore } from "~/store/order";
const showFilters = ref(false);
const priceFromFilter = ref("");
const priceToFilter = ref("");
const weightFromFilter = ref("");
const weightToFilter = ref("");
const statusChosen = ref([]);
const selectedContainerTypes = ref([]);
const isIntersecting = ref(false);
const sortField = ref(null);
const sortOrder = ref(1);
const currentPage = ref(1);
const itemsPerPage = ref(10);
const orderStore = useOrdersStore();
const selectOrderId = ref(null);

onBeforeMount(async () => {
  await orderStore.getOrders();
  await orderStore.getOneOrder();
});

const paginatedOrders = computed(() => {
  const start = 0;
  const end = start + itemsPerPage.value;
  return sortedOrders.value.slice(start, end);
});

const onIntersect = (isIntersecting, entries, observer) => {
  setTimeout(() => {
    itemsPerPage.value += 10;
  }, 1500);
};

const orders = computed(() => {
  if (!orderStore.orders || orderStore.loading) return [];
  return orderStore.orders;
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

  return orders.value.filter((order) => {
    const priceInRange = order.price >= priceFrom && order.price <= priceTo;
    const weightInRange =
      order.weight >= weightFrom && order.weight <= weightTo;
    const containerTypeAllowed =
      selectedContainerTypes.value.length === 0 ||
      selectedContainerTypes.value.includes(order.container.name);
    // const statusMatches =
    //   statusChosen.value.length === 0 ||
    //   statusChosen.value.includes(String(order.status));

    return priceInRange && weightInRange && containerTypeAllowed;
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

const deleteFilters = () => {
  priceFromFilter.value = "";
  priceToFilter.value = "";
  weightFromFilter.value = "";
  weightToFilter.value = "";
  selectedContainerTypes.value = "";
  statusChosen.value = "";
};

async function paramsOrder(id) {
  await orderStore.getOneOrder(id);
  selectOrderId.value = id;
}

const oneOrder = computed(() => {
  if (!orderStore.oneOrder || orderStore.loading) return [];
  return orderStore.oneOrder.order;
});
</script>

<style scoped lang="sass">


.tableOrders
  color: rgba(0, 0, 0, 0.704)
  font-size: 33px
  font-weight: 600

.headerOrderTable
  display: flex
  justify-content: space-between
  align-items: center

.btnsOrderTable
  display: flex

.createOrder
  margin-right: 10px

.table
  margin-top: 50px
  font-size: 24px
  height: 100vh
.date
  color: red
  font-weight: 900
.filters
  display: flex
  flex-direction: row
  justify-content: space-between
  align-items: flex-start
  margin-top: 30px
  margin-bottom: -40px

  @media (max-width: 767px)
    flex-direction: column
    align-content: center
    align-items: center
    height: 340px

.filter,
.deleteFilters
  flex-grow: 1
  flex-basis: 200px
  margin: 1px

.filter-price,
.filter-weight,
.another-filters
  display: flex
  justify-content: space-between
  width: 60vh

  .filter-weight
    margin-left: 10px
  .another-filters
    margin-left: 10px

.label
  position: relative
  bottom: 30px
  width: 0px
  font-size: 18px
  color: black

.header-wrapper,
.my-3
  display: flex
  align-items: center
  justify-content: space-between
  color: black

.delFilters
  margin-left: 35px
  height: 56px

@media (max-width: 767px)
  .tableOrders
    font-size: 23px

  .filter
    height: 80px

  .filter-weight,
  .another-filters
    margin: 0px 0px 0px

@media (max-width: 536px)
  .btnsOrderTable
    flex-direction: column

  .filtersBtn
    margin: 10px 0px 10px 20px

  .filter-weight,
  .another-filters,
  .filter-price
    margin: 10px 0px 0px
    width: 50vh

  .delFilters
    height: 46px

@media (max-width: 432px)
  .filter-weight,
  .another-filters,
  .filter-price
    margin: 10px 0px 0px
    width: 40vh

  .delFilters
    height: 36px

@media (max-width: 364px)
  .filter-weight,
  .another-filters,
  .filter-price
    margin: 10px 0px 0px
    width: 35vh

  .delFilters
    height: 36px
</style>
