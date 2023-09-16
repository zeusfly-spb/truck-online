<template>
  <div class="deliveryFooter">
    <ul class="namesFooter">
      <li class="mainLi">Результат подсчетов:</li>
      <li>
        Расстояние:
        <p>0р</p>
      </li>
      <li>
        Цена:
        <p>0р</p>
      </li>
      <li>
        Сумма к оплате:
        <p v-if="price">{{ price }}р</p>
        <p v-else>0р</p>
      </li>
    </ul>
  </div>
</template>
<script>
import { useCalculate } from "~/store/calculateForm";
import { computed } from "vue";
export default {
  setup() {
    const calculate = useCalculate();
    const price = computed(() => calculate.price);
    return {
      price,
    };
  },
};
</script>
<style scoped>
li {
  font-weight: 500;
  font-size: 20px;
  list-style-type: none;
}
.namesFooter {
  display: flex;
  align-content: center;
  justify-content: space-between;
  align-items: center;
  padding: 20px;
  color: black;
}
.deliveryFooter {
  background-color: white;
  height: 20%;
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
@media (max-width: 610px) {
  .namesFooter {
    display: flex;
    flex-direction: column;
    align-items: stretch;
  }
  li {
    display: flex;
    justify-content: space-between;
  }
}
</style>
