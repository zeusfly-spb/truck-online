<template>
  <Sidebar />
  <v-container>
    <v-form @submit.prevent="updateContainer">
    <v-row no-gutters class="align-center">
      <v-col md :cols="4" class="mr-3 mb-3" style="display: flex">
        <v-text-field
          theme="light"
          label="Name"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
          v-model="data.name"
          :rules="[rules.required]"
          style="margin-right: 10px;"
        ></v-text-field>
      </v-col>
      <v-col md :cols="4" class="mr-3 mb-3" style="display: flex">
        <v-text-field
          theme="light"
          label="Weight"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
          v-model="data.weight"
          :rules="[rules.required]"
          style="margin-right: 10px;"
        ></v-text-field>
      </v-col>
      <v-col md :cols="4" class="mr-3 mb-3" style="display: flex">
        <v-text-field
          theme="light"
          label="Kit"
          class="text-body-1"
          variant="outlined"
          hide-details="auto"
          v-model="data.kit"
          :rules="[rules.required]"
          style="margin-right: 10px;"
        ></v-text-field>
      </v-col>
    </v-row>
    <v-row no-gutters>
      <v-col md :cols="12">
        <v-btn
          color="primary"
          class="text-body-2 text-uppercase rounded font-weight-bold elevation-0"
          type="submit"
          >Обновить
        </v-btn>
      </v-col>
    </v-row>
  </v-form>
  </v-container>
</template>

<script setup>
  import Sidebar from "~/components/admin/Sidebar.vue";

  const route = useRoute();
  const data = reactive({
    name: '',
    weight: '',
    kit: '',
  })
  const rules = {
    required: (value) => !!value || "Поле обязательно для заполнения",
  };

  onBeforeMount(async () => {
    const route = useRoute();
    const { data: { _rawValue }, } = await opFetch(`/containers/${route.params.id}`, { method: "get"});
    data.name = _rawValue['name'];
    data.weight = _rawValue['weight'];
    data.kit = _rawValue['kit'];
  });
  const updateContainer = async () => {

    const token_cookie = useCookie("online_port_token");
    const headers = new Headers();
    if (token_cookie.value) {
      headers.set("Authorization", `Bearer ${token_cookie.value}`);
    }
    const url = `containers/${route.params.id}`;
    const {
      data: { _rawValue },
    } = await opFetch(url, {
      method: "put",
      body: { name: data.name, weight: data.weight, kit: data.kit },
    });
     await navigateTo("/admin/containers");
  };
</script>
