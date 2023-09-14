<template>
  <v-text-field
    label="ВЕС"
    variant="solo"
    name="weight"
    type="number"
  ></v-text-field>
</template>
<script>
export default {
  methods: {
    onWeightChange() {
      const weight = this.weight;
      this.$emit("updateWeight", weight);
    },
  },
};
</script>
<style scoped></style>
