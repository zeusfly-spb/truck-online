<template>
  <v-text-field
    class="inputNumber"
    label="ВЕС"
    variant="solo"
    name="weight"
    type="number"
    @input="updateWeight"
    v-model.number="weight"
    :rules="[rules.required]"
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

const clearInput = () => {
  weight.value = "";
};

const rules = {
  required: (value) => !!value || "Поле обязательно для заполнения",
};

defineExpose({
  clearInput,
});
</script>
<style scoped>
.inputNumber >>> input[type="number"] {
  -moz-appearance: textfield;
}
.inputNumber >>> input::-webkit-outer-spin-button,
.inputNumber >>> input::-webkit-inner-spin-button {
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
}
</style>
