<template>
  <div>
    <v-select
      v-model="selectedContainerId"
      @change="updateContainer"
      :items="allContainers"
    />
  </div>
</template>

<script setup>
import { useContainersStore } from "~/store/containers";
import { defineEmits } from "vue";

const emit = defineEmits(["updateContainer"]);
const containersStore = useContainersStore();
const selectedContainerId = ref("");

onMounted(async () => await containersStore.getContainers());

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
</script>
