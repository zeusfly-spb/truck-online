<template>
  <div class="formDelivery">
    <v-form>
      <h2 class="calculation" style="font-weight: 600; font-size: 35px">
        Предварительный расчет
      </h2>
      <p class="calc" style="font-weight: 500; font-size: 20px">Калькулятор</p>
      <div class="from-to">
        <div class="inputFrom">
          <search-input-from
            @updateSelectAddressFrom="updateSelectAdressFrom"
            ref="childFrom"
          />
        </div>
        <div class="inputTo">
          <search-input-to
            @updateSelectedAddressTo="updateSelectAdressTo"
            ref="childTo"
          />
        </div>
      </div>
      <div class="return">
        <div class="inputReturn">
          <search-input-return
            @updateSelectedAddressReturn="updateSelectAdressReturn"
            ref="childReturn"
          />
        </div>
        <div class="inputWeight">
          <weight-input @updateWeight="updateWeight" ref="childWeight" />
        </div>
      </div>
      <div class="containerInput">
        <div class="taxSelect">
          <tax-select @updateTax="updateTax" ref="childTax" />
        </div>
        <div class="containerSelect">
          <div>Тип контейнера</div>
          <search-container
            @updateContainer="updateContainer"
            ref="childSelectContainer"
          />
        </div>
      </div>
      <div class="additionally">
        <div
          class="additionallyBtn"
          type="button"
          @click="toggleAdditionalOptions"
        >
          Выберите из списка доп параметров
        </div>
        <div v-if="showAdditionalOptions" class="additional-options">
          <div class="additional-par">ПАРАМЕТР</div>
          <div class="additional-par">ПАРАМЕТР</div>
          <div class="additional-par">ПАРАМЕТР</div>
          <div class="additional-par">ПАРАМЕТР</div>
        </div>
      </div>
      <div class="buttonsForm">
        <v-btn
          v-if="showCalculateBtn"
          @click="submitForm"
        >
          Рассчитать
        </v-btn>
        <v-btn
          v-else
          @click="goToBigForm"
        >
          Создать заказ
        </v-btn>
        <v-btn
          variant="tonal"
          style="background-color: #2e67b1; color: rgba(255, 255, 255, 0.5)"
          @click="clearData"
          type="button"
        >
          Сбросить
        </v-btn>
      </div>
    </v-form>
  </div>
</template>
<script setup>
import SearchInputFrom from "./searchInputFrom.vue";
import SearchInputTo from "./searchInputTo.vue";
import SearchInputReturn from "./searchInputReturn.vue";
import searchContainer from "./searchContainer.vue";
import WeightInput from "./weightInput.vue";
import taxSelect from "./taxSelect.vue";
import { useCalculate } from "~/store/calculateForm";
import { defineEmits } from "vue";

const selectedCoordinates = ref([]);
const showAdditionalOptions = ref(false);
const containerId = ref(null);
const calculation = useCalculate();
const selectedIds = ref([]);
const tax = ref(null);
const weight = ref(null);
const childFrom = ref(null);
const childTo = ref(null);
const childReturn = ref(null);
const childWeight = ref(null);
const childTax = ref(null);
const childSelectContainer = ref(null);
const showCalculateBtn = ref(true);
const emit = defineEmits([
  "updateSelectedCoordinates",
  "updateContainer",
  "updateWeight",
  "clearMarkers",
  "updateTax",
]);

const toggleAdditionalOptions = () => {
  showAdditionalOptions.value = !showAdditionalOptions.value;
};

const updateSelectAdressFrom = (address) => {
  selectedCoordinates.value[0] = address.coordinates;
  selectedIds.value[0] = address.id;
  emit("updateSelectedCoordinates", selectedCoordinates.value);
  showCalculateBtn.value = true;
};

const updateSelectAdressTo = (address) => {
  selectedCoordinates.value[1] = address.coordinates;
  selectedIds.value[1] = address.id;
  emit("updateSelectedCoordinates", selectedCoordinates.value);
  showCalculateBtn.value = true;
};
const updateSelectAdressReturn = (address) => {
  selectedCoordinates.value[2] = address.coordinates;
  selectedIds.value[2] = address.id;
  emit("updateSelectedCoordinates", selectedCoordinates.value);
  showCalculateBtn.value = true;
};

const updateWeight = (value) => {
  weight.value = value;
  emit("updateWeight", weight.value);
  showCalculateBtn.value = true;
};
const updateTax = (value) => {
  tax.value = value;
  console.log("taaaax:", tax.value);
  emit("updateTax", tax.value);
  showCalculateBtn.value = true;
};

const updateContainer = (id) => {
  containerId.value = id;
  emit("updateContainer", containerId.value);
  showCalculateBtn.value = true;
};

const goToBigForm = async () => {
  const token_cookie = useCookie("online_port_token");
  if (token_cookie.value) {
    await navigateTo("/orders/create");
  }
};

async function submitForm() {
  const body = {
    container_id: containerId.value,
    from_address_id: selectedIds.value[0],
    delivery_address_id: selectedIds.value[1],
    return_address_id: selectedIds.value[2],
    weight: weight.value,
    imo: 0,
    is_international: 1,
    temp_reg: 1,
    tax_id: tax.value,
    calc: 1,
  };
  if (
    selectedIds &&
    weight.value &&
    tax.value &&
    childSelectContainer.value.validate()
  ) {
    await calculation.calculate(body);
    showCalculateBtn.value = false;
  } else {
    useSnack({
      show: true,
      type: "error",
      title: "Проверьте все ли данные указаны!",
      message: "Предварительная стоимость не рассчитана",
    });
  }
}

const clearData = () => {
  childFrom.value.clearInput();
  childTo.value.clearInput();
  childReturn.value.clearInput();
  childWeight.value.clearInput();
  childSelectContainer.value.clearSelect();
  childTax.value.clearSelect();
  selectedCoordinates.value = [];
  selectedIds.value = [];
  emit("clearMarkers");
  showCalculateBtn.value = true;
  calculation.resetPrice();
};
</script>
<style scoped>
.buttonsForm {
  display: flex;
  align-content: center;
  justify-content: space-between;
  margin: 20px 10px 25px 0px;
}

.containerSelect {
  display: grid;
  justify-items: center;
}

.buttonsForm .v-btn {
  width: 280px;
  height: 50px;
}
.additional-options {
  display: flex;
  align-content: center;
  justify-content: space-between;
}
.additionallyBtn {
  color: #fff;
  font-size: 16px;
  font-style: normal;
  font-weight: 400;
  line-height: normal;
}
.additional-par {
  background-color: #285795;
  color: white;
  width: 145px;
  height: 32px;
  display: flex;
  align-content: center;
  justify-content: center;
  flex-wrap: wrap;
  margin: 20px auto;
}

@media (min-width: 1400px) {
  .formDelivery {
    width: 50%;
    height: 80%;
    height: 735px;
  }
  .from-to {
    display: flex;
    align-items: baseline;
    margin-top: 25px;
  }
  .inputFrom,
  .inputReturn {
    flex: 1;
    margin-right: 10px;
    position: relative;
    margin-bottom: 10px;
  }
  .inputTo {
    flex: 1;
  }

  .inputWeight,
  .inputWeight {
    flex: 1;
  }

  .return {
    display: flex;
    align-items: baseline;
  }

  .containerInput {
    display: flex;
  }
  .taxSelect,
  .containerSelect {
    flex: 1;
  }
  .inputWeight {
    flex: 1;
    max-width: 400px;
  }

  .additionally {
    margin-top: 25px;
  }

  form {
    width: 95%;
    padding: 0px 40px 0px;
  }
  .calculation {
    margin-top: 40px;
    font-size: 35px;
    font-style: normal;
    font-weight: 600;
    line-height: normal;
  }
  .calc {
    margin-top: 25px;
    color: #fff;
    font-size: 20px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
  }
  .buttonsForm {
    display: flex;
    align-items: center;
    justify-content: space-evenly;
  }
}

@media (max-width: 1400px) {
  .formDelivery {
    display: flex;
    flex-direction: column;
    width: 100%;
  }
  .calculation {
    text-align: center;
    font-size: 30px;
    margin: 10px auto;
  }
  .calc {
    text-align: center;
    margin: 10px auto;
    font-size: 25px;
  }
  .additionally {
    text-align: center;
  }
  .buttonsForm .v-btn {
    width: 230px;
    height: 50px;
  }
  .additional-par {
    width: 120px;
    height: 30px;
  }
  .buttonsForm {
    display: flex;
    justify-content: space-evenly;
  }
  @media (max-width: 494px) {
    .buttonsForm .v-btn {
      width: 170px;
      height: 50px;
    }
    .additional-par {
      width: 80px;
      font-size: 12px;
    }
    .calc {
      font-size: 21px;
    }
    .calculation {
      font-size: 26px;
    }
  }
  @media (max-width: 370px) {
    .buttonsForm .v-btn {
      width: 130px;
      height: 50px;
    }
    .additional-par {
      width: 60px;
      font-size: 10px;
    }
  }
}
</style>
