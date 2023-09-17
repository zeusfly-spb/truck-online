<template>
  <v-container class="mb-2">
    <v-form ref="order-create" @submit.prevent="submit" id="order-form">
      <v-row>
        <h3>Откуда везем</h3>
        <v-divider></v-divider>
        <v-col cols="12" md="4">
          <v-select
            label="Select"
            name="from_address_id"
            :items="
              addresses
                ? addresses.data.filter((address) => address.from == true)
                : []
            "
            item-value="id"
            item-title="name"
            @update:modelValue="updateFromAddress"
            :rules="[rules.required]"
          ></v-select>
        </v-col>
        <v-col cols="12" md="4">
          <v-text-field
            type="date"
            name="from_date"
            :rules="[rules.required]"
          ></v-text-field>
        </v-col>
        <v-col cols="12" md="4">
          <v-text-field
            type="time"
            name="from_slot"
            :rules="[rules.required]"
          ></v-text-field>
        </v-col>
        <v-col cols="12" md="4">
          <v-text-field
            name="from_contact_name"
            label="From Contact Name"
            :rules="[rules.required]"
          ></v-text-field>
        </v-col>
        <v-col cols="12" md="4">
          <v-text-field
            name="from_contact_phone"
            label="From Contact Phone"
            :rules="[rules.required, rules.phoneLength]"
            placeholder="+7 900 000-00-00"
          ></v-text-field>
        </v-col>
        <v-col cols="12" md="4">
          <v-text-field
            name="from_contact_email"
            label="From Contact Email"
            :rules="[rules.required]"
          ></v-text-field>
        </v-col>
        <!-- Order From Data -->
        <h3>Куда везем</h3>
        <v-divider></v-divider>
        <!-- Order To Data -->
        <v-col cols="12" md="4">
          <v-select
            label="Select"
            name="delivery_address_id"
            :items="
              addresses
                ? addresses.data.filter((address) => address.to == true)
                : []
            "
            item-value="id"
            item-title="name"
            @update:modelValue="updateDeliveryAddress"
            :rules="[rules.required]"
          ></v-select>
        </v-col>
        <v-col cols="12" md="4">
          <v-text-field
            type="date"
            name="delivery_date"
            :rules="[rules.required]"
          ></v-text-field>
        </v-col>
        <v-col cols="12" md="4">
          <v-text-field
            type="time"
            name="delivery_slot"
            :rules="[rules.required]"
          ></v-text-field>
        </v-col>
        <v-col cols="12" md="4">
          <v-text-field
            name="delivery_contact_name"
            label="Delivery Contact Name"
            :rules="[rules.required]"
          ></v-text-field>
        </v-col>
        <v-col cols="12" md="4">
          <v-text-field
            name="delivery_contact_phone"
            label="Delivery Contact Phone"
            :rules="[rules.required, rules.phoneLength]"
            placeholder="+7 900 000-00-00"
          ></v-text-field>
        </v-col>
        <v-col cols="12" md="4">
          <v-text-field
            name="delivery_contact_email"
            label="Delivery Contact Email"
            :rules="[rules.required]"
          ></v-text-field>
        </v-col>
        <!-- Order To Data -->
        <!-- Order Return Data -->
        <h3>Место сдачи контейнера</h3>
        <v-divider></v-divider>
        <v-col cols="12" md="4">
          <v-select
            label="Select"
            name="return_address_id"
            :items="
              addresses
                ? addresses.data.filter((address) => address.return == true)
                : []
            "
            item-value="id"
            item-title="name"
            @update:modelValue="updateReturnAddress"
            :rules="[rules.required]"
          ></v-select>
        </v-col>
        <v-col cols="12" md="4">
          <v-text-field
            type="date"
            name="return_date"
            :rules="[rules.required]"
          ></v-text-field>
        </v-col>
        <v-col cols="12" md="4">
          <v-text-field
            type="time"
            name="return_slot"
            :rules="[rules.required]"
          ></v-text-field>
        </v-col>
        <v-col cols="12" md="4">
          <v-text-field
            name="return_contact_name"
            label="Return Contact Name"
            :rules="[rules.required]"
          ></v-text-field>
        </v-col>
        <v-col cols="12" md="4">
          <v-text-field
            name="return_contact_phone"
            label="Return Contact Phone"
            :rules="[rules.required, rules.phoneLength]"
            placeholder="+7 900 000-00-00"
          ></v-text-field>
        </v-col>
        <v-col cols="12" md="4">
          <v-text-field
            name="return_contact_email"
            label="Return Contact Email"
            :rules="[rules.required]"
          ></v-text-field>
        </v-col>
        <!-- Order Return Data -->
        <h3>INFO</h3>
        <v-divider></v-divider>
        <v-col cols="12" md="4">
          <v-select
            label="Containers"
            name="container_id"
            id="container_id"
            :items="containers ? containers?.data : []"
            item-value="id"
            item-title="name"
            :rules="[rules.required]"
          ></v-select>
        </v-col>
        <v-col cols="12" md="2">
          <v-text-field
            name="weight"
            label="Weight"
            type="number"
            id="weight"
            :rules="[rules.required]"
          ></v-text-field>
        </v-col>
        <v-col cols="12" md="2">
          <v-text-field
            name="price"
            label="Price"
            :rules="[rules.required]"
          ></v-text-field>
        </v-col>
        <v-col cols="12" md="2">
          <v-text-field
            name="length_algo"
            label="Длина маршрута в км"
            :rules="[rules.required]"
          ></v-text-field>
        </v-col>
        <v-col cols="12" md="2">
          <v-text-field
            name="length_real"
            label="Реальная длина из данных водителя"
            :rules="[rules.required]"
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="12">
          <v-text-field
            name="description"
            label="Description"
            :rules="[rules.required]"
          ></v-text-field>
        </v-col>
        <v-col cols="12" md="2">
          <v-checkbox name="imo" :label="`imo`"></v-checkbox>
        </v-col>
        <v-col cols="12" md="3">
          <v-checkbox
            name="temp_reg"
            :label="`Температурный режим`"
          ></v-checkbox>
        </v-col>
        <v-col cols="12" md="3">
          <v-checkbox
            name="is_international"
            :label="`is_international`"
          ></v-checkbox>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="12" md="6">
          <v-card
            class="text-right text-h6 p-20"
            id="sum"
            text="0 руб"
            variant="outlined"
          ></v-card>
        </v-col>
        <v-col cols="12" md="2">
          <v-btn
            :loading="loading"
            block
            class="mt-2"
            text="Calculate"
            color="indigo-darken-3"
            @click="calculate"
          ></v-btn>
        </v-col>
        <v-col cols="12" md="2">
          <v-btn
            :loading="loading"
            type="submit"
            block
            class="mt-2"
            text="Submit"
            color="indigo-darken-3"
          ></v-btn>
        </v-col>
      </v-row>
    </v-form>
  </v-container>
</template>
<style>
.p-20 {
  padding: 20px;
}
</style>
<!-- <script>
export default {
  async fetch() {
    this.containers = await useFetch('http://127.0.0.1:8000/api/containers');
    this.addresses = await useFetch('http://127.0.0.1:8000/api/addresses');
    this.cars = await useFetch('http://127.0.0.1:8000/api/cars');
    this.companies = await useFetch('http://127.0.0.1:8000/api/companies');
    this.taxes = await useFetch('http://127.0.0.1:8000/api/taxes');
  },
  data() {
    return {
      containers: [],
      addresses: [],
      cars: [],
      companies: [],
      taxes: [],
    };
  },
  methods: {
    async submit() {
      // await fetch(FORMSPARK_ACTION_URL, {
      //   method: "POST",
      //   headers: {
      //     "Content-Type": "application/json",
      //     Accept: "application/json",
      //   },
      //   body: JSON.stringify({
      //     message: this.message,
      //   }),
      // });
      alert("Form submitted");
    },
  },

};
</script> -->

<script setup>
const { data: containers } = await useFetch(URI + "containers");
const { data: addresses } = await useFetch(URI + "addresses");
const { data: orderSetting } = await useFetch(URI + "order/settings");

const authStore = useAuthStore();

import { useAddressesStore } from "~/store/address";

const addressesFrom = computed(() => {
  const allAdressesFrom = addressesStore.addresses.filter(
    (el) => el.from == true,
  );
  return allAdressesFrom;
});
// console.log("FROOOOOOM:", addressesFrom);

const rules = {
  required: (value) => !!value || "Поле обязательно для заполнения",
  phoneLength: (value) =>
    value.toString().length === 10 || "Телефон должен быть длинной 10 цифр",
};

var fromAddress;
var deliveryAddress;
var returnAddress;

const submit = async (event) => {
  try {
    await submitForm(event);
  } catch (e) {
    const showError = async () => {
      useSnack({
        show: true,
        type: "error",
        title: "Что-то не так с созданием заказа!",
        message: "Проверьте правильность введенных данных",
      });
    };
  }
};

const submitForm = async (event) => {
  //get FromData
  const formData = new FormData(event.target);
  const formProps = Object.fromEntries(formData);
  //get Token
  const token_cookie = useCookie("online_port_token");
  const headers = new Headers();
  if (token_cookie.value) {
    headers.set("Authorization", `Bearer ${token_cookie.value}`);
  }
  //store order
  const { data: responseData } = await useFetch(URI + "order/store", {
    method: "post",
    headers,
    body: { data: formProps },
    async onResponse({ request, response, options }) {
      console.log(response);
      if (response.status == "200") {
        useSnack({
          show: true,
          type: "success",
          title: "Заказ успешно создан!",
          message: "Заказ успешно создан!",
        });
        await navigateTo("/orders");
      }
      if (response.status == "500") {
        useSnack({
          show: true,
          type: "error",
          title: "Что-то не так с созданием заказа!",
          message: "Проверьте правильность введенных данных",
        });
      }
    },
  });
};

const calculate = async () => {
  var data = {
    points: [
      {
        type: "stop",
        lon: 37.582591,
        lat: 55.775364,
      },
      {
        type: "stop",
        lon: 37.579206,
        lat: 55.774362,
      },
      {
        type: "stop",
        lon: 37.2377193,
        lat: 55.6617422,
      },
    ],
    transport: "truck",
    route_mode: "fastest",
    traffic_mode: "jam",
  };

  const responseDataDistance = ref();
  var distance = ref();
  // const headers = new Headers();
  // headers.set('Accept', 'application/json');

  // const { data: responseData } = await useFetch('https://routing.api.2gis.com/routing/7.0.0/global?key=cb315652-4a77-4656-b55c-2485e210e675',
  //   { method: 'post',  headers, body: data,
  //     async onResponse({ request, response, options }) {
  //       console.log('response',response);
  //       responseDataDistance.value = response;
  //     },
  //   });

  //distance = responseDataDistance.value._data.result[0].total_distance; //kilometraj
  distance = 1000;
  var fullWeight = document.getElementById("weight").value;
  //getContainerWeight
  var containerWeight = getContainerWeight();
  //getOverWeight
  var overWeightSum = getOverWeight(containerWeight, fullWeight);
  var defaultCarPrice = orderSetting.value.default_car_price;

  var sum =
    overWeightSum +
    defaultCarPrice +
    distance * orderSetting.value.default_over_weight_price; // fullSum
  console.log("перевес=>" + overWeightSum);
  console.log("distance=>", distance);

  const formatter = new Intl.NumberFormat("ru");
  document.getElementById("sum").innerHTML = formatter.format(sum) + " руб";
  //console.log(fromAddress.coordinates.coordinates);
  //console.log(deliveryAddress.coordinates.coordinates);
  //console.log(returnAddress.coordinates.coordinates);
};

const getContainerWeight = () => {
  var containerId = document.getElementById("container_id").value;
  var container = containers.value.data.filter(
    (container) => container.id == containerId,
  );
  return parseFloat(container[0].weight);
};
const getOverWeight = (containerWeight, fullWeight) => {
  var overWeightSum = 0;

  if (containerWeight < parseFloat(fullWeight)) {
    var overweight = parseFloat(fullWeight) - containerWeight;
    overWeightSum = overweight * orderSetting.value.default_over_weight_price;
  }
  return overWeightSum;
};
const getDistance = async () => {
  var data = {
    points: [
      {
        type: "stop",
        lon: 37.582591,
        lat: 55.775364,
      },
      {
        type: "stop",
        lon: 37.579206,
        lat: 55.774362,
      },
      {
        type: "stop",
        lon: 37.2377193,
        lat: 55.6617422,
      },
    ],
    transport: "truck",
    route_mode: "fastest",
    traffic_mode: "jam",
  };

  const responseDataDistance = ref();
  const headers = new Headers();
  headers.set("Accept", "application/json");

  const { data: responseData } = await useFetch(
    "https://routing.api.2gis.com/routing/7.0.0/global?key=cb315652-4a77-4656-b55c-2485e210e675",
    {
      method: "post",
      headers,
      body: data,
      async onResponse({ request, response, options }) {
        console.log("response", response);
        responseDataDistance.value = response;
      },
    },
  );
  distanceSum = responseDataDistance.value._data.result[0].total_distance;
  //  return responseDataDistance.value._data.result[0].total_distance;
};
const updateFromAddress = async (id) => {
  fromAddress = addresses.value.data.find((address) => address.id === id);
};
const updateDeliveryAddress = async (id) => {
  deliveryAddress = addresses.value.data.find((address) => address.id === id);
};
const updateReturnAddress = async (id) => {
  returnAddress = addresses.value.data.find((address) => address.id === id);
};
</script>
