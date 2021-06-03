<template>
  <div class="my-3 mx-5">
    <v-row>
      <h3>Editar Estado</h3>
    </v-row>
    <v-row class="border mb-3">
      <v-col cols="12" sm="6" md="6">
        Nombre Estado
        <v-text-field
          v-model="status.PaymentStatusName"
          solo
          required
          placeholder="Example"
          v-on:keyup.enter="updateStatus"
          class="border"
          flat
          dense
          hide-details
        ></v-text-field>
      </v-col>
    </v-row>
    <v-btn color="success" class="mr-4 mt-3" @click="updateStatus">
      Guardar
    </v-btn>
  </div>
</template>

<script>
export default {
  data: () => ({
    valid: true,
    status: {},
  }),

  methods: {
    validate() {
      console.log(this.arrivalsDates);
    },
    getStatus() {
      axios
        .get(`/api/v1/sale-payment-status/${this.$route.params.id}`)
        .then(response => {
          this.status = response.data.data;
        })
        .catch(error => {});
    },
    updateStatus() {
      axios
        .put(`/api/v1/sale-payment-status/${this.$route.params.id}`, this.status)
        .then(response => {
          this.$router.replace({ name: 'listStockPaymentStatus' });
        })
        .catch(error => {});
    },
  },
  mounted() {
    this.getStatus();
  },
};
</script>
<style scoped>
.border {
  border: 1px solid #d2d6de;
  background-color: white;
}
</style>
