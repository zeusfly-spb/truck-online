<template>
  <div class="delivery">
    <div class="delivery-main">
      <FormOrder
        @updateSelectedCoordinates="updateMapCoordinates"
        @clearMarkers="clearMarkers"
      />
      <TwogisMap
        :selectedCoordinates="selectedCoordinates"
        ref="twoGisMapRef"
      />
    </div>
    <DeliveryFooter />
  </div>
</template>

<script setup>
import TwogisMap from "../components/TwogisMap.vue";
import DeliveryFooter from "~/components/deliveryForm/deliveryFooter.vue";
import FormOrder from "~/components/deliveryForm/formOrder.vue";
const selectedCoordinates = ref([]);
const twoGisMapRef = ref(null);
const updateMapCoordinates = (coordinates) => {
  selectedCoordinates.value = coordinates;
};
const clearMarkers = () => {
  if (twoGisMapRef.value) {
    twoGisMapRef.value.removeMarkers();
  }
};
</script>

<style scoped>
.delivery {
  display: flex;
  flex-direction: column;
  height: 93vh;
}
.delivery-main {
  display: flex;
  flex-wrap: wrap;
  flex: 1;
}
@media (min-width: 1400px) {
  FormOrder,
  TwogisMap {
    flex-basis: 50%;
  }
}
@media (max-width: 1400px) {
  .delivery-main {
    flex-direction: column;
  }
  FormOrder,
  TwogisMap {
    flex-basis: 100%;
  }
}
.deliveryFooter {
  width: 100%;
  flex: 0.1;
}
</style>
