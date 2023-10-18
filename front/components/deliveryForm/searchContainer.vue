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
    <div v-if="!isValid && showError" class="error-message">
      Выберите тип контейнера
    </div>
  </div>
</template>
<script setup>
import { useContainersStore } from "~/store/containers";
import { defineEmits } from "vue";

const emit = defineEmits(["updateContainer"]);
const containersStore = useContainersStore();
const selectedContainerId = ref("");
const showError = ref(false);

onBeforeMount(async () => {
  await containersStore.getContainers();
});

const updateContainer = (id) => {
  selectedContainerId.value = id;
  emit("updateContainer", id);
  showError.value = false;
};

const allContainers = computed(() => {
  const names = ["20DC", "40HC", "20+20"];
  return containersStore.containers.filter((el) => names.includes(el.name));
});

const clearSelect = () => {
  selectedContainerId.value = "";
  showError.value = false;
};

const isValid = computed(() => !!selectedContainerId.value);

const validate = () => {
  showError.value = !isValid.value;
  return isValid.value;
};

defineExpose({ clearSelect, validate });
</script>
<style scoped>
.container-button {
  display: inline-block;
  margin: 5px;
}
.error-message {
  color: red;
}

.selected {
  font-size: 1.5rem;
  transform: scale(1);
  background-color: #285795;
}
</style>
