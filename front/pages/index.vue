<template>
  <div class="delivery">
    <FormOrder
      @updateSelectedCoordinates="updateMapCoordinates"
      @clearMarkers="clearMarkers"
    />
    <TwogisMap :selectedCoordinates="selectedCoordinates" ref="twoGisMapRef" />
  </div>
  <delivery-footer />
</template>

<script setup>
import TwogisMap from "../components/TwogisMap.vue";
import DeliveryFooter from "~/components/deliveryForm/deliveryFooter.vue";
import FormOrder from "~/components/deliveryForm/formOrder.vue";

const selectedCoordinates = ref([]);
const twoGisMapRef = ref(null);

const updateMapCoordinates = (coordinates) => {
  selectedCoordinates.value = coordinates;
  twoGisMapRef.value = twoGisMapRef.value;
};

const clearMarkers = () => {
  if (twoGisMapRef.value) {
    twoGisMapRef.value.removeMarkers();
  }
};
</script>

<style scoped>
@media (max-width: 1400px) {
  .delivery {
    display: flex;
    flex-direction: column;
  }
}
@media (min-width: 1400px) {
  .delivery {
    display: flex;
    justify-content: space-between;
  }
}
</style>
