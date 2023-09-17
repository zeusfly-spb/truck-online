<template>
  <v-text-field
    label="ВЕС"
    variant="solo"
    name="weight"
    type="number"
    @input="updateWeight"
    @focus="focusInput"
    v-model.number="weight"
  ></v-text-field>
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
<style scoped></style>
