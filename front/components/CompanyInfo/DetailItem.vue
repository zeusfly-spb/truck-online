<template>
  <div
    v-if="content"
  >
    <span
      v-if="['string', 'number'].includes(type)"
    >
      {{ translate(title) }}: <strong>{{ translate(content) }}</strong>
    </span>
    <v-expansion-panels
      v-if="type === 'object'"
      v-model="panel"
    >
      <v-expansion-panel
        style="background-color: transparent!important;"
      >
        <v-expansion-panel-title>
          {{ translate(title) }}
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
import {useTranslatorStore} from "~/store/translator";
import {useConfigStore} from "~/store/config";
import {storeToRefs} from "pinia";

const panel = ref([]);
const {activePanel} = storeToRefs(useConfigStore());
const translatorStore = useTranslatorStore();
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
const translate = word => {
  return translatorStore.translate(word, 'details');
}
const {title, content} = toRefs(props);
const type = computed(() => content.value && typeof content.value);
const panelName = computed(() => type.value === 'object' && title.value || null);
watch(activePanel, val => val !== panelName.value ? panel.value = undefined : null);
watch(panel, val => val === 0 ? activePanel.value = panelName.value : null);
</script>

<style lang="scss" scoped>

</style>
