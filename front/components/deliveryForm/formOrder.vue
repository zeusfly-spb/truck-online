<template>
  <div class="formDelivery">
    <form @submit.prevent="submitForm">
      <h2 class="calculation">Предварительный расчет</h2>
      <p class="calc">Калькулятор</p>
      <div class="from-to">
        <div class="inputFrom">
          <search-input-from
            @updateSelectAddressFrom="updateSelectAdressFrom"
          />
        </div>
        <div class="inputTo">
          <search-input-to @updateSelectedAddressTo="updateSelectAdressTo" />
        </div>
      </div>
      <div class="return">
        <search-input-return
          @updateSelectedAddressReturn="updateSelectAdressReturn"
        />
      </div>
      <div class="containerInput">
        <div class="inputWeight">
          <weight-input @updateWeight="updateWeight" style="flex: 1" />
        </div>
        <div class="containerSelect">
          <search-container @updateContainer="updateContainer" />
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
        <v-btn type="submit"> Рассчитать </v-btn>
        <v-btn
          variant="tonal"
          style="background-color: #2e67b1; color: rgba(255, 255, 255, 0.5)"
        >
          Сбросить
        </v-btn>
      </div>
    </form>
  </div>
</template>
<script>
import SearchInputFrom from "./searchInputFrom.vue";
import SearchInputTo from "./searchInputTo.vue";
import SearchInputReturn from "./searchInputReturn.vue";
import searchContainer from "./searchContainer.vue";
import WeightInput from "./weightInput.vue";
import { useIntermediateFormData } from "~/store/intermediateFromData";
import { opFetch } from "~/composables/opFetch";
export default {
  components: {
    SearchInputFrom,
    SearchInputTo,
    SearchInputReturn,
    WeightInput,
    searchContainer,
  },
  setup(_, { emit }) {
    const selectedCoordinates = ref([]);
    const showAdditionalOptions = ref(false);
    const selectedContainer = ref(null);
    const intermediateFormData = useIntermediateFormData();
    const selectedIds = ref([]);
    const toggleAdditionalOptions = () => {
      showAdditionalOptions.value = !showAdditionalOptions.value;
    };

    const updateSelectAdressFrom = (address) => {
      selectedCoordinates.value[0] = address.coordinates;
      selectedIds.value[0] = address.id;
      emit("updateSelectedCoordinates", selectedCoordinates.value);
    };

    const updateSelectAdressTo = (address) => {
      selectedCoordinates.value[1] = address.coordinates;
      selectedIds.value[1] = address.id;
      emit("updateSelectedCoordinates", selectedCoordinates.value);
    };
    const updateSelectAdressReturn = (address) => {
      selectedCoordinates.value[2] = address.coordinates;
      selectedIds.value[2] = address.id;
      emit("updateSelectedCoordinates", selectedCoordinates.value);
      console.log("ВСЕ КООРДИНАТЫ:", selectedCoordinates.value);
      console.log("АЙДИШНИКИ:", selectedIds.value);
    };

    const updateWeight = (value) => {
      weight.value = value;
    };

    const updateContainer = (container) => {
      selectedContainer.value = container;
    };

    async function submitForm(event) {
      const formData = new FormData(event.target);
      const formProps = Object.fromEntries(formData);
    }

    return {
      updateSelectAdressFrom,
      updateSelectAdressTo,
      updateSelectAdressReturn,
      submitForm,
      toggleAdditionalOptions,
      showAdditionalOptions,
      updateWeight,
      updateContainer,
      selectedContainer,
      intermediateFormData,
      selectedIds,
    };
  },
};
</script>
<style scoped>
.buttonsForm {
  display: flex;
  align-content: center;
  justify-content: space-between;
  margin: 20px 10px 25px 0px;
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
  .inputFrom {
    flex: 1;
    margin-right: 10px;
  }
  .inputTo {
    flex: 1;
  }

  .containerInput {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 4px;
  }
  .inputWeight {
    flex: 1;
    margin-right: 10px;
  }

  .containerSelect {
    flex: 1;
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
