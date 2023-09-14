<template>
  <div>
    <v-select
      chips
      label="ТИП КОНТЕЙНЕРА"
      :items="[
        'Контейнер 1',
        'Контейнер 2',
        'Контейнер 3',
        'Контейнер 4',
        'Контейнер 5',
        'Контейнер 6',
      ]"
      variant="solo"
    ></v-select>
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
