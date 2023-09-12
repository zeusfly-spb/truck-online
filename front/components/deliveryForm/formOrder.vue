<template>
  <div class="formDelivery">
    <form @submit.prevent="submitForm">
      <h2 class="calculation">Предварительный расчет</h2>
      <p class="calc">Калькулятор</p>
      <div class="from-to">
        <search-input-from @updateSelectAddressFrom="updateSelectAdressFrom" />
        <search-input-to @updateSelectedAddressTo="updateSelectAdressTo" />
      </div>
      <div class="return">
        <search-input-return
          @updateSelectedAddressReturn="updateSelectAdressReturn"
        />
      </div>
      <div class="containerInput">
        <weight-input @updateWeight="updateWeight" />
        <search-container @updateContainer="updateContainer" />
      </div>
      <div class="additionally">
        <button
          class="additionallyBtn"
          type="button"
          @click="toggleAdditionalOptions"
        >
          Выберите из списка доп параметров
        </button>
        <div v-if="showAdditionalOptions" class="additional-options">
          <div class="additional-par">ПАРАМЕТР</div>
          <div class="additional-par">ПАРАМЕТР</div>
          <div class="additional-par">ПАРАМЕТР</div>
          <div class="additional-par">ПАРАМЕТР</div>
        </div>
      </div>
      <div class="buttons">
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

    const toggleAdditionalOptions = () => {
      showAdditionalOptions.value = !showAdditionalOptions.value;
    };

    const updateSelectAdressFrom = (coordinates) => {
      selectedCoordinates.value[0] = coordinates;
      emit("updateSelectedCoordinates", selectedCoordinates.value);
    };

    const updateSelectAdressTo = (coordinates) => {
      selectedCoordinates.value[1] = coordinates;
      emit("updateSelectedCoordinates", selectedCoordinates.value);
    };
    const updateSelectAdressReturn = (coordinates) => {
      selectedCoordinates.value[2] = coordinates;
      emit("updateSelectedCoordinates", selectedCoordinates.value);
      console.log("ВСЕ КООРДИНАТЫ:", selectedCoordinates.value);
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
      const response = await opFetch("/order/store", {
        method: "POST",
        body: {
          data: {
            ...formProps,
            imo: 0,
            is_international: 1,
            temp_reg: 1,
            tax_id: 1,
            calc: true,
          },
        },
        async onResponse({ request, response, options }) {
          console.log(response);
          if (response.status == "200") {
            useSnack({
              show: true,
              type: "success",
              title: "Заказ успешно создан!",
              message: "Заказ успешно создан!",
            });
            await navigateTo("/orders");
          }
          if (response.status == "500") {
            useSnack({
              show: true,
              type: "error",
              title: "Что-то не так с созданием заказа!",
              message: "Проверьте правильность введенных данных",
            });
          }
        },
      });
      intermediateFormData.setFormData(formProps);
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
    };
  },
};
</script>
<style scoped>
.formDelivery {
  width: 100%;
}
form {
  width: 95%;
}
</style>
