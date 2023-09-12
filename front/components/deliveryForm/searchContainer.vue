<template>
  <div>
    <select
      style="background-color: white"
      v-model="selectedContainers"
      @change="$emit('updateContainer', selectedContainers)"
    >
      <option
        v-for="container in containersStore.containers"
        :key="container.id"
      >
        {{ container.name }}
      </option>
    </select>
  </div>
</template>
<script>
import { useContainersStore } from "~/store/containers";
export default {
  setup() {
    const containersStore = useContainersStore();
    const selectedContainers = ref(null);
    console.log("ВЫБРАННЫЙ КОНТЕЙНРЕ:", selectedContainers);

    const fetchData = async () => {
      await containersStore.getContainers();
      console.log("Контейнеры:", containersStore.containers);
    };

    onMounted(fetchData);

    return {
      containersStore,
      selectedContainers,
    };
  },
};
</script>
<style scoped></style>
