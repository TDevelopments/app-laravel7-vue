<template>
  <div class="my-3 mx-5">
    <v-row>
      <h3>Añadir Cliente</h3>
    </v-row>
    <v-row class="border mb-3">
      <v-col cols="12" md="3" sm="6">
        Nombres
        <v-text-field
          class="border"
          flat
          hide-details
          solo
          dense
          v-model="dataUser.FullName"
        ></v-text-field>
      </v-col>
      <v-col cols="12" md="3" sm="6">
        DNI 
        <v-text-field class="border" flat hide-details solo dense v-model="dataUser.Dni"></v-text-field>
      </v-col>
      <v-col cols="12" md="3" sm="6">
        Direccion
        <v-text-field class="border" flat hide-details solo dense v-model="dataUser.Address1"></v-text-field>
      </v-col>
      <!-- <v-col cols="12" md="3" sm="6">
        Unidades en Orden
        <v-text-field class="border" flat hide-details solo dense></v-text-field>
      </v-col> -->
      <v-col cols="12" md="3" sm="6">
        Pais
        <v-text-field class="border" flat hide-details solo dense v-model="dataUser.Country"></v-text-field>
      </v-col>
      <v-col cols="12" md="3" sm="6">
        Ciudad
        <v-text-field class="border" flat hide-details solo dense v-model="dataUser.City"></v-text-field>
      </v-col>
      <v-col cols="12" md="3" sm="6">
        Telefono
        <v-text-field class="border" flat hide-details solo dense v-model="dataUser.Phone"></v-text-field>
      </v-col>
      <v-col cols="12" md="3" sm="6">
        Email
        <v-text-field class="border" flat hide-details solo dense v-model="dataUser.Email"></v-text-field>
      </v-col>

      <!-- <v-col cols="12" md="3" sm="6">
        Estado
        <v-text-field class="border" flat hide-details solo dense></v-text-field>
      </v-col> -->
    </v-row>
    <v-row class="my-3">
      <v-spacer></v-spacer>
      <v-btn class="mx-1 my-4 border" elevation="0" color="#0D52D6" dark small @click="addCustomer"
        >Guardar</v-btn
      >
      <v-btn class="mx-1 my-4 border" elevation="0" small>Cancelar</v-btn>
    </v-row>
  </div>
</template>

<script>
export default {
  data: () => ({
    dataUser: {},
    FullName: null,
    Address1: null,
    Address2: null,
    City: null,
    PostalCode: null,
    Country: null,
    Phone: null,
    Email: null,
    ShipAddress: null,
    ShipCity: null,
    ShipRegion: null,
    ShipPostalCode: null,
    ShipCountry: null,
    BillingAddress: null,
    BillingCity: null,
    BillingRegion: null,
    BillingPostalCode: null,
    BillingCountry: null,
  }),
  methods: {
    addCustomer() {
      let data = {
        FullName: this.FullName,
        Address1: this.Address1,
        Address2: this.Address2,
        City: this.City,
        State: this.State,
        PostalCode: this.PostalCode,
        Country: this.Country,
        Phone: this.Phone,
        Email: this.Email,
        ShipAddress: this.ShipAddress,
        ShipCity: this.ShipCity,
        ShipRegion: this.ShipRegion,
        ShipPostalCode: this.ShipPostalCode,
        ShipCountry: this.ShipCountry,
        BillingAddress: this.BillingAddress,
        BillingCity: this.BillingCity,
        BillingRegion: this.BillingRegion,
        BillingPostalCode: this.BillingPostalCode,
        BillingCountry: this.BillingCountry,
      };
      console.log(data);
      axios
        .post('/api/v1/sale-customers', this.dataUser)
        .then(response => {
          console.log(response);
          this.$router.replace({
            name: 'listStockCustomer',
          });
        })
        .catch(error => {});
    },
  },
};
</script>
<style scoped>
.border {
  border: 1px solid #d2d6de;
  background-color: white;
}
</style>
