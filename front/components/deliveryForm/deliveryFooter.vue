<template>
  <div class="deliveryFooter">
    <ul class="namesFooter">
      <li
        style="
          color: black;
          font-weight: 600;
          font-size: 25px;
          margin-bottom: 20px;
        "
      >
        Результат подсчетов:
      </li>
      <li>
        Наименование услуги
        <p>0р</p>
      </li>
      <li>
        Колличество
        <p>0р</p>
      </li>
      <li>
        Цена
        <p>0р</p>
      </li>
      <li>
        НДС
        <p>0р</p>
      </li>
      <li>
        Сумма к оплате
        <p>0р</p>
      </li>
    </ul>
  </div>
</template>
<script>
export default {};
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
</style>
