<template>
  <v-form ref="order-create" @submit.prevent="addOrder" id="order-form">
    <div class="container">
      <div class="form">
        <div class="addressesData">
          <h3>Откуда везем</h3>
          <div class="fromData">
            <v-col>
              <v-select
                label="Выберите адрес"
                name="from_address_id"
                :items="filteredAddresses"
                item-value="id"
                item-title="name"
                v-model="order.from_address_id"
                :rules="[rules.required]"
                variant="solo"
              ></v-select>
            </v-col>
            <v-dialog width="400">
              <template v-slot:activator="{ props }">
                <button type="button">
                  <img
                    v-bind="props"
                    alt="calendar"
                    src="/календарь.png"
                    class="calendar"
                  />
                </button>
              </template>
              <template v-slot:default="{ isActive }">
                <v-card title="Дата и время забора контейнера">
                  <v-col cols="12" md="15" class="dialogInput">
                    <v-text-field
                      type="date"
                      name="from_date"
                      :rules="[rules.required]"
                      v-model="order.from_date"
                      variant="solo"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="15">
                    <v-text-field
                      type="time"
                      name="from_slot"
                      :rules="[rules.required]"
                      v-model="order.from_slot"
                      variant="solo"
                    ></v-text-field>
                  </v-col>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                      text="Добавить"
                      @click="isActive.value = false"
                    ></v-btn>
                  </v-card-actions>
                </v-card>
              </template>
            </v-dialog>
            <v-dialog width="500">
              <template v-slot:activator="{ props }">
                <button type="button">
                  <img
                    alt="calendar"
                    src="/contact.png"
                    class="contact"
                    v-bind="props"
                  />
                </button>
              </template>
              <template v-slot:default="{ isActive }">
                <v-card title="Данные водителя">
                  <v-col cols="12" md="15">
                    <v-text-field
                      name="from_contact_name"
                      label="Имя"
                      :rules="[rules.required]"
                      v-model="order.from_contact_name"
                      variant="solo"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="15">
                    <v-text-field
                      name="from_contact_phone"
                      label="Телефон"
                      :rules="[rules.required, rules.phoneLength]"
                      placeholder="+7 900 000-00-00"
                      v-model="order.from_contact_phone"
                      variant="solo"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="15">
                    <v-text-field
                      name="from_contact_email"
                      label="Email"
                      :rules="[rules.required]"
                      variant="solo"
                      v-model="order.from_contact_email"
                    ></v-text-field>
                  </v-col>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                      text="Добавить"
                      @click="isActive.value = false"
                    ></v-btn>
                  </v-card-actions>
                </v-card>
              </template>
            </v-dialog>
          </div>
          <h3>Куда везем</h3>
          <div class="toData">
            <v-col>
              <v-select
                label="Select"
                name="delivery_address_id"
                :items="addresses.filter((el) => !!el.to)"
                item-value="id"
                item-title="name"
                v-model="order.delivery_address_id"
                :rules="[rules.required]"
                variant="solo"
              ></v-select>
            </v-col>
            <v-dialog width="500">
              <template v-slot:activator="{ props }">
                <button type="button">
                  <img
                    alt="calendar"
                    src="/календарь.png"
                    class="calendar"
                    v-bind="props"
                  />
                </button>
              </template>
              <template v-slot:default="{ isActive }">
                <v-card title="Дата и время доставки контейнера">
                  <v-col cols="12" md="15">
                    <v-text-field
                      type="date"
                      name="delivery_date"
                      :rules="[rules.required]"
                      v-model="order.delivery_date"
                      variant="solo"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="15">
                    <v-text-field
                      type="time"
                      name="delivery_slot"
                      :rules="[rules.required]"
                      v-model="order.delivery_slot"
                      variant="solo"
                    ></v-text-field>
                  </v-col>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                      text="Добавить"
                      @click="isActive.value = false"
                    ></v-btn>
                  </v-card-actions>
                </v-card>
              </template>
            </v-dialog>
            <v-dialog width="500">
              <template v-slot:activator="{ props }">
                <button type="button">
                  <img
                    alt="calendar"
                    src="/contact.png"
                    class="contact"
                    v-bind="props"
                  />
                </button>
              </template>
              <template v-slot:default="{ isActive }">
                <v-card title="Данные водителя">
                  <v-col cols="12" md="15">
                    <v-text-field
                      name="delivery_contact_name"
                      label="Имя"
                      :rules="[rules.required]"
                      v-model="order.delivery_contact_name"
                      variant="solo"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="15">
                    <v-text-field
                      name="delivery_contact_phone"
                      label="Телефон"
                      :rules="[rules.required, rules.phoneLength]"
                      placeholder="+7 900 000-00-00"
                      v-model="order.delivery_contact_phone"
                      variant="solo"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="15">
                    <v-text-field
                      name="delivery_contact_email"
                      label="Email"
                      :rules="[rules.required]"
                      v-model="order.delivery_contact_email"
                      variant="solo"
                    ></v-text-field>
                  </v-col>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                      text="Добавить"
                      @click="isActive.value = false"
                    ></v-btn>
                  </v-card-actions>
                </v-card>
              </template>
            </v-dialog>
          </div>
          <h3>Место сдачи контейнера</h3>
          <div class="returnData">
            <v-col>
              <v-select
                label="Select"
                name="return_address_id"
                :items="addresses.filter((el) => !!el.return)"
                item-value="id"
                item-title="name"
                v-model="order.return_address_id"
                :rules="[rules.required]"
                variant="solo"
              ></v-select>
            </v-col>
            <v-dialog width="500">
              <template v-slot:activator="{ props }">
                <button type="button">
                  <img
                    alt="calendar"
                    src="/календарь.png"
                    class="calendar"
                    v-bind="props"
                  />
                </button>
              </template>
              <template v-slot:default="{ isActive }">
                <v-card title="Дата и время сдачи контейнера">
                  <v-col cols="12" md="15">
                    <v-text-field
                      type="date"
                      name="return_date"
                      :rules="[rules.required]"
                      v-model="order.return_date"
                      variant="solo"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="15">
                    <v-text-field
                      type="time"
                      name="return_slot"
                      :rules="[rules.required]"
                      v-model="order.return_slot"
                      variant="solo"
                    ></v-text-field>
                  </v-col>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                      text="Добавить"
                      @click="isActive.value = false"
                    ></v-btn>
                  </v-card-actions>
                </v-card>
              </template>
            </v-dialog>
            <v-dialog width="500">
              <template v-slot:activator="{ props }">
                <button type="button">
                  <img
                    alt="calendar"
                    src="/contact.png"
                    class="contact"
                    v-bind="props"
                  />
                </button>
              </template>
              <template v-slot:default="{ isActive }">
                <v-card title="Данные водителя">
                  <v-col cols="12" md="15">
                    <v-text-field
                      name="return_contact_name"
                      label="Имя"
                      :rules="[rules.required]"
                      v-model="order.return_contact_name"
                      variant="solo"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="15">
                    <v-text-field
                      name="return_contact_phone"
                      label="Телефон"
                      :rules="[rules.required, rules.phoneLength]"
                      placeholder="900-00-00-00"
                      v-model="order.return_contact_phone"
                      variant="solo"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="15">
                    <v-text-field
                      name="return_contact_email"
                      label="Email"
                      :rules="[rules.required]"
                      v-model="order.return_contact_email"
                      variant="solo"
                    ></v-text-field>
                  </v-col>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                      text="Добавить"
                      @click="isActive.value = false"
                    ></v-btn>
                  </v-card-actions>
                </v-card>
              </template>
            </v-dialog>
          </div>
        </div>
        <!-- Order Return Data -->
        <div class="infoData">
          <h3>INFO</h3>
          <div class="containerInfo">
            <v-col cols="40" md="6">
              <v-text-field
                name="weight"
                label="Вес"
                type="number"
                id="weight"
                :rules="[rules.required]"
                v-model="order.weight"
                variant="solo"
                class="inputNumber"
              ></v-text-field>
            </v-col>
            <v-col cols="40" md="6">
              <v-select
                label="Containers"
                name="container_id"
                id="container_id"
                :items="allContainers"
                :rules="[rules.required]"
                v-model="order.container_id"
                variant="solo"
              ></v-select>
            </v-col>
          </div>
          <div class="priceLength">
            <v-col cols="40" md="6">
              <v-text-field
                name="price"
                label="Цена"
                :rules="[rules.required]"
                v-model="order.price"
                variant="solo"
                type="number"
                class="inputNumber"
              ></v-text-field>
            </v-col>
            <v-col cols="40" md="6">
              <v-text-field
                name="length_algo"
                label="Длина маршрута в км"
                :rules="[rules.required]"
                v-model="order.length_algo"
                variant="solo"
                type="number"
                class="inputNumber"
              ></v-text-field>
            </v-col>
          </div>
          <div class="additionalyParametrs">
            <v-col>
              <v-checkbox name="imo" label="Класс imo" v-model="order.imo">
              </v-checkbox>
            </v-col>
            <v-col>
              <v-select
                label="НДС"
                name="tax_id"
                :items="taxes"
                v-model="order.tax_id"
                variant="solo"
                class="tax"
              >
              </v-select>
            </v-col>
            <v-col>
              <v-checkbox
                name="temp_reg"
                :label="`Температурный режим`"
                v-model="order.temp_reg"
              ></v-checkbox>
            </v-col>
            <v-col>
              <v-checkbox
                name="is_international"
                :label="`is_international`"
                v-model="order.is_international"
              ></v-checkbox>
            </v-col>
          </div>
        </div>
      </div>
      <div class="bigFormMap">
        <twogis-map />
      </div>
    </div>
    <v-col cols="12" md="12">
      <v-text-field
        name="description"
        label="Комментарий"
        :rules="[rules.required]"
        v-model="order.description"
        variant="solo"
      ></v-text-field>
    </v-col>
    <div class="btnsBigForm">
      <v-btn
        :loading="loading"
        type="submit"
        text="Создать заказ"
        color="indigo-darken-3"
        max-width="150px"
      ></v-btn>
      <v-btn
        :loading="loading"
        @click="calculate"
        text="Рассчитать"
        color="indigo-darken-3"
        max-width="150px"
      ></v-btn>
    </div>
  </v-form>
</template>

<script setup>
import { useContainersStore } from "~/store/containers";
import { useAddressesStore } from "~/store/address";
import { useOrdersStore } from "~/store/order";
import { useTaxesStore } from "~/store/tax";
import { useCalculate } from "~/store/calculateForm";

const containerStore = useContainersStore();
const addresStore = useAddressesStore();
const orderStore = useOrdersStore();
const taxStore = useTaxesStore();
const calculate = useCalculate();

onBeforeMount(async () => {
  await containerStore.getContainers();
  await addresStore.getAddresses();
  await taxStore.getTaxes();
});

const intermediateData = computed(() => {
  return calculate.intermediateData;
});

watch(
  () => intermediateData.value,
  (newData) => {
    order.from_address_id = newData.from_address.name;
  },
);

const order = reactive({
  from_address_id: null,
  from_date: null,
  from_slot: null,
  from_contact_name: null,
  from_contact_phone: null,
  from_contact_email: null,
  delivery_address_id: null,
  delivery_date: null,
  delivery_slot: null,
  delivery_contact_name: null,
  delivery_contact_phone: null,
  delivery_contact_email: null,
  return_address_id: null,
  return_date: null,
  return_slot: null,
  return_contact_name: null,
  return_contact_phone: null,
  return_contact_email: null,
  container_id: null,
  weight: null,
  price: null,
  length_algo: null,
  description: null,
  imo: 0,
  temp_reg: 0,
  is_international: 0,
  tax_id: null,
  calc: 0,
});

watch(() => order.from_address_id);
watch(() => order.delivery_address_id);
watch(() => order.return_address_id);
watch(() => order.container_id);
watch(() => order.tax_id);

const addresses = computed(() => {
  if (!addresStore.addresses || addresStore.loading) return [];
  return (
    addresStore.addresses.map((address) => ({
      ...address,
      title: address.name,
      value: address.id,
    })) || []
  );
});

const filteredAddresses = computed(() => {
  const selectedAddress = addresses.value.find(
    (address) => address.name === intermediateData.value?.from_address.name,
  );
  return selectedAddress ? [selectedAddress] : addresses.value;
});

const allContainers = computed(() => {
  if (!containerStore.containers || containerStore.loading) return [];
  const base =
    containerStore.containers.map((item) => ({
      ...item,
      title: item.name,
      value: item.id,
      props: { subtitle: `${item.weight} кг.` },
    })) || [];
  return [{ value: "", title: "Тип контейнера" }, ...base];
});

const taxes = computed(() => {
  if (!taxStore.taxes || taxStore.loading) return [];
  const base =
    taxStore.taxes.map((item) => ({
      ...item,
      title: item.name,
      value: item.id,
    })) || [];
  return [{ value: "", title: "Выберите ндс" }, ...base];
});

async function addOrder() {
  await orderStore.createOrder(order);
}

const rules = {
  required: (value) => !!value || "Поле обязательно для заполнения",
  phoneLength: (value) =>
    value.toString().length === 10 || "Телефон должен быть длинной 10 цифр",
};
</script>
<style scoped>
.fromData,
.toData,
.returnData {
  display: flex;
  align-items: baseline;
  justify-content: space-around;
}

.container {
  display: flex;
  height: 76vh;
}
.form {
  width: 50%;
}
.bigFormMap {
  width: 50%;
}

.containerInfo {
  display: flex;
  justify-content: space-around;
}
.inputNumber >>> input[type="number"] {
  -moz-appearance: textfield;
}

.inputNumber >>> input::-webkit-outer-spin-button,
.inputNumber >>> input::-webkit-inner-spin-button {
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
}
#map {
  width: 100%;
}
h3 {
  margin-left: 10px;
}
.btnsBigForm {
  display: flex;
  justify-content: space-evenly;
}
.calendar {
  height: 55px;
}
.contact {
  height: 55px;
}
.containerInfo {
  display: flex;
}
.priceLength {
  display: flex;
}
.additionalyParametrs {
  display: flex;
}
.dialogInput,
.v-col-md-4 {
  max-width: auto;
}

@media (max-width: 960px) {
  .container {
    flex-direction: column;
  }
  .form {
    width: 100%;
  }
  .bigFormMap {
    width: 100%;
  }
}
@media (max-width: 1308px) {
  :deep(.tax .v-label.v-field-label) {
    font-size: 12px;
  }
}
</style>
