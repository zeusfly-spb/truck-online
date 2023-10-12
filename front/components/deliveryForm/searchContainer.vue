<template>
  <div>
    <div
      v-for="container in allContainers"
      :key="container.id"
      class="container-button"
    >
      <v-btn
        :class="selectedContainerId === container.id ? 'selected' : null"
        @click="updateContainer(container.id)"
        variant="solo"
      >
        {{ container.name }}
      </v-btn>
    </div>
  </div>
</template>
<script setup>
import { useContainersStore } from "~/store/containers";
import { defineEmits } from "vue";

const emit = defineEmits(["updateContainer"]);
const containersStore = useContainersStore();
const selectedContainerId = ref("");

onBeforeMount(async () => {
  watch(selectedContainerId, (container) => {
    if (container) {
      emit("updateContainer", selectedContainerId.value);
    }
  });
  await containersStore.getContainers();
});

const updateContainer = (id) => {
  selectedContainerId.value = id;
  emit("updateContainer", id);
};

const allContainers = computed(() => {
  const names = ["20f", "40f", "20+20"];
  if (!containersStore.containers || containersStore.loading) return [];
  return containersStore.containers.filter((el) => names.includes(el.name));
});

const clearSelect = () => {
  selectedContainerId.value = "";
};

defineExpose({ clearSelect });
</script>
<style scoped>
.container-button {
  display: inline-block;
  margin: 5px;
}

.selected {
  font-size: 1.5rem;
  transform: scale(1);
  background-color: #285795;
}
</style>
