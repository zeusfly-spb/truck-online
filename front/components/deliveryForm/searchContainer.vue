<template>
  <div>
    <v-select
      v-model="selectedContainerId"
      @change="updateContainer"
      :items="allContainers"
      variant="solo"
    />
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

const updateContainer = () => {
  emit("updateContainer", selectedContainerId.value);
};
const allContainers = computed(() => {
  const base =
    containersStore.containers.map((item) => ({
      ...item,
      title: item.name,
      value: item.id,
      props: { subtitle: `${item.weight} кг.` },
    })) || [];
  return [{ value: "", title: "Тип контейнера" }, ...base];
});

const clearSelect = () => {
  selectedContainerId.value = "";
};

defineExpose({ clearSelect });
</script>
