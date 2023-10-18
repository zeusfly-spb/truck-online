<template>
  <h1 v-if="allRecs.length === 0" class="noCars">
    У вас еще нет реквизитов
  </h1>
  <v-table fixed-header height="300px" v-else>
    <thead>
      <tr>
        <th class="text-left">БИК</th>
        <th class="text-left">Название банка</th>
        <th class="text-left">Кор. Счет</th>
        <th class="text-left">Р/счет</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="rec in allRecs" :key="rec.id">
        <td>{{ rec.bik }}</td>
        <td>{{ rec.bank_name }}</td>
        <td>{{ rec.account }}</td>
        <td>{{ rec.k_account }}</td>
        <v-btn @click="deleteRec(rec.id)" text="Удалить реквизит"> </v-btn>
      </tr>
    </tbody>
  </v-table>
</template>
<script setup>
import { useRecsStore } from "~/store/companyConfig/rec";
const recStore = useRecsStore();
onBeforeMount(async () => {
  await recStore.getAllRecs();
});
const allRecs = computed(() => {
  if (!recStore.recs || recStore.loading) return [];
  return recStore.recs;
});

async function deleteRec(id) {
  await recStore.deleteRec(id);
}
</script>
<style scoped></style>
