<template>
  <v-select
    label="НДС"
    name="tax_id"
    :items="taxes"
    v-model="tax"
    variant="solo"
    class="tax"
    @update:modelValue="updateTax"
    :rules="[rules.required]"
  >
  </v-select>
</template>
<script setup>
import { useTaxesStore } from "~/store/tax";
const taxStore = useTaxesStore();
const tax = ref(null);
const emit = defineEmits(["updateTax"]);
onBeforeMount(async () => {
  watch(
    () => tax.value,
    (newVal) => console.log("new tax:", newVal),
  );
  await taxStore.getTaxes();
});

const updateTax = (value) => {
  tax.value = value;
  console.log("New tax value", tax.value);
  emit("updateTax", tax.value);
};

const rules = {
  required: (value) => !!tax.value || "Поле обязательно для заполнения",
};

const clearSelect = () => {
  tax.value = "";
};

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

defineExpose({
  clearSelect,
});
</script>
<style scoped></style>
