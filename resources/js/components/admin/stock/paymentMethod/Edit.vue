<template>
  <div class="my-3 mx-5">
    <v-row>
      <h3>Editar Metodo</h3>
    </v-row>
    <v-row class="border mb-3">
      <v-col cols="12" sm="6" md="6">
        Nombre Metodo
        <v-text-field
          v-model="method.PaymentMethodName"
          solo
          required
          placeholder="Example"
          v-on:keyup.enter="updateMethod"
          class="border"
          flat
          dense
          hide-details
        ></v-text-field>
      </v-col>
    </v-row>
    <v-btn color="success" class="mr-4 mt-3" @click="updateMethod">
      Guardar
    </v-btn>
  </div>
</template>

<script>
export default {
  data: () => ({
    valid: true,
    method: {},
  }),

  methods: {
    validate() {
      console.log(this.arrivalsDates);
    },
    getMethod() {
      axios
        .get(`/api/v1/sale-payment-methods/${this.$route.params.id}`)
        .then(response => {
          this.method = response.data.data;
        })
        .catch(error => {});
    },
    updateMethod() {
      axios
        .put(`/api/v1/sale-payment-methods/${this.$route.params.id}`, this.method)
        .then(response => {
          this.$router.replace({ name: 'listStockPaymentMethod' });
        })
        .catch(error => {});
    },
  },
  mounted() {
    this.getMethod();
  },
};
</script>
<style scoped>
.border {
  border: 1px solid #d2d6de;
  background-color: white;
}
</style>
