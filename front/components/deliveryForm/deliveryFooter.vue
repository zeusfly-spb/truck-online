<template>
  <v-bottom-navigation elevation="5">
    <ul class="namesFooter">
      <li class="mainLi">Результат подсчетов:</li>
      <li>
        Сумма к оплате:
        <p>{{ price }}р</p>
      </li>
    </ul>
  </v-bottom-navigation>
</template>
<script setup>
import { useCalculate } from "~/store/calculateForm";
const calculate = useCalculate();
const price = computed(() => calculate.price);
</script>
<style scoped>
li {
  font-weight: 500;
  font-size: 20px;
  list-style-type: none;
}
.namesFooter {
  width: 100%;
  display: flex;
  align-content: center;
  justify-content: space-between;
  align-items: center;
  padding: 20px;
  color: black;
  background-color: white;
}

.mainLi {
  color: black;
  font-weight: 600;
  font-size: 25px;
  margin-bottom: 20px;
}

@media (max-width: 900px) {
  li {
    font-size: 14px;
  }

  .mainLi {
    font-size: 18px;
  }
}
</style>
