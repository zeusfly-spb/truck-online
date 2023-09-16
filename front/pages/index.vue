<template>
  <div class="delivery">
    <form-order @updateSelectedCoordinates="updateMapCoordinates" />
    <TwogisMap :selectedCoordinates="selectedCoordinates" />
  </div>
  <delivery-footer />
</template>

<script setup>
import { ref } from "vue";
import { useAddressesStore } from "~/store/address";
import TwogisMap from "../components/TwogisMap.vue";
import DeliveryFooter from "../components/deliveryForm/deliveryFooter.vue";
import formOrder from "../components/deliveryForm/formOrder.vue";

const addressesStore = useAddressesStore();
const addresses = computed(() => addressesStore.addresses);

const selectedCoordinates = ref([]);
const updateMapCoordinates = (coordinates) =>
  (selectedCoordinates.value = coordinates);
onBeforeMount(async () => {
  await addressesStore.getAddresses();
});
</script>

<style scoped>
@media (max-width: 1400px) {
  .delivery {
    display: flex;
  }
}
.delivery {
  display: flex;
  justify-content: space-between;
}
</style>
