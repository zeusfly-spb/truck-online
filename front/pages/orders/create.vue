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
                :items="addresses.filter((el) => !!el.from)"
                item-value="id"
                item-title="name"
                v-model="data.order.fromAdress"
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
                      v-model="data.order.fromDate"
                      variant="solo"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="15">
                    <v-text-field
                      type="time"
                      name="from_slot"
                      :rules="[rules.required]"
                      v-model="data.order.fromSlot"
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
                      v-model="data.order.fromContactName"
                      variant="solo"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="15">
                    <v-text-field
                      name="from_contact_phone"
                      label="Телефон"
                      :rules="[rules.required, rules.phoneLength]"
                      placeholder="+7 900 000-00-00"
                      v-model="data.order.fromContactPhone"
                      variant="solo"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="15">
                    <v-text-field
                      name="from_contact_email"
                      label="Email"
                      :rules="[rules.required]"
                      variant="solo"
                      v-model="data.order.fromContactEmail"
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
                v-model="data.order.deliveryAddress"
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
                      v-model="data.order.deliveryDate"
                      variant="solo"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="15">
                    <v-text-field
                      type="time"
                      name="delivery_slot"
                      :rules="[rules.required]"
                      v-model="data.order.deliverySlot"
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
                      v-model="data.order.deliveryContactName"
                      variant="solo"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="15">
                    <v-text-field
                      name="delivery_contact_phone"
                      label="Телефон"
                      :rules="[rules.required, rules.phoneLength]"
                      placeholder="+7 900 000-00-00"
                      v-model="data.order.deliveryContactPhone"
                      variant="solo"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="15">
                    <v-text-field
                      name="delivery_contact_email"
                      label="Email"
                      :rules="[rules.required]"
                      v-model="data.order.deliveryContactEmail"
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
                v-model="data.order.returnAddress"
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
                      v-model="data.order.returnDate"
                      variant="solo"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="15">
                    <v-text-field
                      type="time"
                      name="return_slot"
                      :rules="[rules.required]"
                      v-model="data.order.returnSlot"
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
                      v-model="data.order.returnContactName"
                      variant="solo"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="15">
                    <v-text-field
                      name="return_contact_phone"
                      label="Телефон"
                      :rules="[rules.required, rules.phoneLength]"
                      placeholder="+7 900 000-00-00"
                      v-model="data.order.returnContactPhone"
                      variant="solo"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="15">
                    <v-text-field
                      name="return_contact_email"
                      label="Email"
                      :rules="[rules.required]"
                      v-model="data.order.returnContactEmail"
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
                v-model="data.order.weight"
                variant="solo"
              ></v-text-field>
            </v-col>
            <v-col cols="40" md="6">
              <v-select
                label="Containers"
                name="container_id"
                id="container_id"
                :items="allContainers"
                :rules="[rules.required]"
                v-model="data.order.container"
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
                v-model="data.order.price"
                variant="solo"
              ></v-text-field>
            </v-col>
            <v-col cols="40" md="6">
              <v-text-field
                name="length_algo"
                label="Длина маршрута в км"
                :rules="[rules.required]"
                v-model="data.order.lengthAlgo"
                variant="solo"
              ></v-text-field>
            </v-col>
          </div>
          <div class="additionalyParametrs">
            <v-col>
              <v-checkbox name="imo" label="Класс imo" v-model="data.order.imo">
              </v-checkbox>
            </v-col>
            <v-col>
              <v-select
                label="НДС"
                name="tax_id"
                :items="taxes"
                v-model="data.order.tax"
                variant="solo"
                class="tax"
              >
              </v-select>
            </v-col>
            <v-col>
              <v-checkbox
                name="temp_reg"
                :label="`Температурный режим`"
                v-model="data.order.temp"
              ></v-checkbox>
            </v-col>
            <v-col>
              <v-checkbox
                name="is_international"
                :label="`is_international`"
                v-model="data.order.international"
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
        v-model="data.order.description"
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

const containerStore = useContainersStore();
const addresStore = useAddressesStore();
const orderStore = useOrdersStore();
const taxStore = useTaxesStore();

onBeforeMount(async () => {
  await containerStore.getContainers();
  await addresStore.getAddresses();
  await taxStore.getTaxes();
});

const data = reactive({
  order: {
    fromAdress: null,
    fromDate: null,
    fromSlot: null,
    fromContactName: null,
    fromContactPhone: null,
    fromContactEmail: null,
    deliveryAddress: null,
    deliveryDate: null,
    deliverySlot: null,
    deliveryContactName: null,
    deliveryContactPhone: null,
    deliveryContactEmail: null,
    returnAddress: null,
    returnDate: null,
    returnSlot: null,
    returnContactName: null,
    returnContactPhone: null,
    returnContactEmail: null,
    container: null,
    weight: null,
    price: null,
    lengthAlgo: null,
    description: null,
    imo: 1,
    temp: 1,
    international: 1,
    tax: null,
  },
});
console.log("data:", data.order.fromAdress);
watch(
  () => data.order.fromAdress,
  (newVal) => console.log("new address:", newVal),
);
watch(
  () => data.order.deliveryAddress,
  (newVal) => console.log("new address:", newVal),
);
watch(
  () => data.order.returnAddress,
  (newVal) => console.log("new address:", newVal),
);
watch(
  () => data.order.container,
  (newVal) => console.log("new container:", newVal),
);
watch(
  () => data.order.tax,
  (newVal) => console.log("tax:", newVal),
);

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

async function addOrder(event) {
  const formData = new FormData(event.target);
  formData.append("calc", false);
  const formProps = Object.fromEntries(formData);
  console.log(formData);
  await orderStore.createOrder(formProps);
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
.p-20 {
  padding: 20px;
}
.container {
  display: flex;
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
.v-col {
  padding: 7px;
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
