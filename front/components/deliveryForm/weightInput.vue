<template>
  <v-text-field
    label="ВЕС"
    variant="solo"
    name="weight"
    type="number"
    @input="updateWeight"
  ></v-text-field>
</template>
<script>
export default {
  data() {
    return {
      weight: null,
    };
  },
  methods: {
    updateWeight(event) {
      this.weight = event.target.value;
      this.$emit("updateWeight", this.weight);
    },
  },
};
</script>
<style scoped></style>
