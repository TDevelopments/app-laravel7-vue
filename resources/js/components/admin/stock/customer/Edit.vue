<template>
  <div class="my-3 mx-5">
    <v-row>
      <h3>Editar Cliente</h3>
    </v-row>
    <v-row class="border mb-3">
      <v-col cols="12" md="3" sm="6">
        Nombres (*)
        <v-text-field
          class="border"
          flat
          hide-details
          solo
          dense
          v-model="customer.FullName"
        ></v-text-field>
      </v-col>
      <v-col cols="12" md="3" sm="6">
        DNI (*)
        <v-text-field
          class="border"
          flat
          hide-details
          solo
          dense
          v-model="customer.Dni"
        ></v-text-field>
      </v-col>
      <v-col cols="12" md="3" sm="6">
        Direccion
        <v-text-field
          class="border"
          flat
          hide-details
          solo
          dense
          v-model="customer.Address1"
        ></v-text-field>
      </v-col>
      <!-- <v-col cols="12" md="3" sm="6">
        Unidades en Orden
        <v-text-field class="border" flat hide-details solo dense></v-text-field>
      </v-col> -->
      <v-col cols="12" md="3" sm="6">
        Pais
        <v-text-field
          class="border"
          flat
          hide-details
          solo
          dense
          v-model="customer.Country"
        ></v-text-field>
      </v-col>
      <v-col cols="12" md="3" sm="6">
        Ciudad
        <v-text-field
          class="border"
          flat
          hide-details
          solo
          dense
          v-model="customer.City"
        ></v-text-field>
      </v-col>
      <v-col cols="12" md="3" sm="6">
        Telefono (*)
        <v-text-field
          class="border"
          flat
          hide-details
          solo
          dense
          v-model="customer.Phone"
        ></v-text-field>
      </v-col>
      <v-col cols="12" md="3" sm="6">
        Email
        <v-text-field
          class="border"
          flat
          hide-details
          solo
          dense
          v-model="customer.Email"
        ></v-text-field>
      </v-col>

      <!-- <v-col cols="12" md="3" sm="6">
        Estado
        <v-text-field class="border" flat hide-details solo dense></v-text-field>
      </v-col> -->
    </v-row>
    <v-row class="my-3">
      <v-spacer></v-spacer>
      <v-btn class="mx-1 my-4 border" elevation="0" color="#0D52D6" dark small @click="editCustomer"
        >Guardar</v-btn
      >
      <v-btn class="mx-1 my-4 border" elevation="0" small>Cancelar</v-btn>
    </v-row>
  </div>
</template>

<script>
export default {
  data: () => ({
    customer: {},
  }),
  methods: {
    getCustomer() {
      axios
        .get(`/api/v1/sale-customers/${this.$route.params.id}`)
        .then(response => {
          this.customer = response.data.data;
        })
        .catch(error => {});
    },
    editCustomer() {
      axios
        .put(`/api/v1/sale-customers/${this.$route.params.id}`, this.customer)
        .then(response => {})
        .catch(error => {});
    },
  },
  mounted() {
    this.getCustomer();
  },
};
</script>
<style scoped>
.border {
  border: 1px solid #d2d6de;
  background-color: white;
}
</style>
