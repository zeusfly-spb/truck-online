<template>
  <div
    v-if="content"
  >
    <span
      v-if="['string', 'number'].includes(type)"
    >
      {{ title }} : {{ content }}
    </span>
    <v-expansion-panels
      v-if="type === 'object'"
      v-model="panel"
    >
      <v-expansion-panel>
        <v-expansion-panel-title>
          {{ title }}
        </v-expansion-panel-title>
        <v-expansion-panel-text>
          <div
            v-for="(item, index) in content"
            :key="index"
          >
            <DetailItem :content="item" :title="index"/>
          </div>
        </v-expansion-panel-text>
      </v-expansion-panel>
    </v-expansion-panels>
  </div>
</template>

<script setup>
const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  content: {
    type: [String, Object, Number, null],
    required: true
  }
});
const {title, content} = toRefs(props);
const type = computed(() => content.value && typeof content.value);
const panel = ref([]);
</script>

<style lang="scss" scoped>

</style>
