<template>
  <div>
    <select v-model="selectedContainerId" @change="updateContainer">
      <option disabled value="">Выберите контейнер</option>
      <option
        v-for="container in allContainer"
        :key="container.id"
        :value="container.id"
      >
        {{ container.name }}
      </option>
    </select>
  </div>
</template>

<script setup>
import { useContainersStore } from "~/store/containers";
import { defineEmits } from "vue";

const emit = defineEmits(["updateContainer"]);
const containersStore = useContainersStore();
const selectedContainerId = ref("");

onBeforeMount(async () => {
  await containersStore.getContainers();
});

const updateContainer = () => {
  emit("updateContainer", selectedContainerId.value);
  console.log("CONTAINER ID:", selectedContainerId.value);
};
const allContainer = computed(() => {
  if (!containersStore.containers || containersStore.loading) return [];
  return containersStore.containers;
});
</script>
