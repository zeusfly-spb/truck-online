<template>
  <div class="delivery">
    <form-order @updateSelectedCoordinates="updateMapCoordinates" />
    <TwogisMap :selectedCoordinates="selectedCoordinates" />
  </div>
  <delivery-footer />
</template>

<script>
import { ref } from "vue";
import TwogisMap from "../components/TwogisMap.vue";
import DeliveryFooter from "../components/deliveryForm/deliveryFooter.vue";
import formOrder from "../components/deliveryForm/formOrder.vue";

export default {
  components: {
    formOrder,
    DeliveryFooter,
    TwogisMap,
  },
  setup() {
    const selectedCoordinates = ref([]);

    const updateMapCoordinates = (coordinates) => {
      selectedCoordinates.value = coordinates;
    };

    return {
      selectedCoordinates,
      updateMapCoordinates,
    };
  },
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
