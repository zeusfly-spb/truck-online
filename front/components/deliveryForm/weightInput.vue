<template>
  <v-text-field
    class="inputInn"
    label="ВЕС"
    variant="solo"
    name="weight"
    type="number"
    @input="updateWeight"
    @focus="focusInput"
    v-model.number="weight"
  />
</template>
<script setup>
import { defineEmits, defineExpose } from "vue";
const emit = defineEmits(["updateWeight"]);

const weight = ref(null);

const updateWeight = (event) => {
  weight.value = event.target.value;
  emit("updateWeight", weight.value);
};

const focusInput = () => {
  weight.value = "";
};

defineExpose({
  focusInput,
});
</script>
<style scoped>
.inputInn >>> input[type="number"] {
  -moz-appearance: textfield;
}
.inputInn >>> input::-webkit-outer-spin-button,
.inputInn >>> input::-webkit-inner-spin-button {
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
}
</style>
