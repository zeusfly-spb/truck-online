<template>
  <div class="delivery">
    <div class="delivery-main">
      <calculate-form
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
import calculateForm from "~/components/deliveryForm/calculateForm.vue";
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
  height: 100%;
}
.delivery-main {
  display: flex;
  flex-wrap: wrap;
  flex: 1;
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
