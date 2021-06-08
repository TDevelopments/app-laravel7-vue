<template>
  <div class="my-3 mx-5">
    <v-row>
      <h3>Editar Estado de Orden</h3>
    </v-row>
    <v-row class="border mb-3">
      <v-col cols="12" sm="6" md="6">
        Nombre de Estado de Orden (*)
        <v-text-field
          v-model="state.Name"
          solo
          required
          placeholder="Example"
          v-on:keyup.enter="addState"
          class="border"
          flat
          dense
          hide-details
        ></v-text-field>
      </v-col>
      <v-col cols="12" sm="6" md="6">
        Nombre Corto (*)
        <v-text-field
          v-model="state.ShortName"
          solo
          required
          placeholder="Example"
          v-on:keyup.enter="addState"
          class="border"
          flat
          dense
          hide-details
        ></v-text-field>
      </v-col>
    </v-row>
    <v-btn color="success" class="mr-4 mt-3" @click="updateState">
      Guardar
    </v-btn>
  </div>
</template>

<script>
export default {
  data: () => ({
    valid: true,
    state: {},
  }),

  methods: {
    validate() {
      console.log(this.arrivalsDates);
    },
    getState() {
      axios
        .get(`/api/v1/sale-state-orders/${this.$route.params.id}`)
        .then(response => {
          this.state = response.data.data;
        })
        .catch(error => {});
    },
    updateState() {
      axios
        .put(`/api/v1/sale-state-orders/${this.$route.params.id}`, this.state)
        .then(response => {
          this.$router.replace({ name: 'listStockState' });
        })
        .catch(error => {});
    },
  },
  mounted() {
    this.getState();
  },
};
</script>
<style scoped>
.border {
  border: 1px solid #d2d6de;
  background-color: white;
}
</style>
