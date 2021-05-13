<template>
  <div class="my-3 mx-5">
    <v-row>
      <h3>Añadir Almacen</h3>
    </v-row>
    <v-row class="border mb-3">
      <v-col cols="12" md="3" sm="6">
        Nombre
        <v-text-field
          class="border"
          flat
          hide-details
          solo
          dense
          v-model="location.Name"
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
          v-model="location.Address"
        ></v-text-field>
      </v-col>
      <v-col cols="12" md="3" sm="6">
        Pais
        <v-text-field
          class="border"
          flat
          hide-details
          solo
          dense
          v-model="location.Country"
        ></v-text-field>
      </v-col>
      <!-- <v-col cols="12" md="3" sm="6">
        Unidades en Orden
        <v-text-field class="border" flat hide-details solo dense></v-text-field>
      </v-col> -->
      <v-col cols="12" md="3" sm="6">
        Cuidad
        <v-text-field
          class="border"
          flat
          hide-details
          solo
          dense
          v-model="location.City"
        ></v-text-field>
      </v-col>
      <v-col cols="12" md="3" sm="6">
        Region
        <v-text-field
          class="border"
          flat
          hide-details
          solo
          dense
          v-model="location.Region"
        ></v-text-field>
      </v-col>
      <v-col cols="12" md="3" sm="6">
        Codigo Postal
        <v-text-field
          class="border"
          flat
          hide-details
          solo
          dense
          v-model="location.PostalCode"
        ></v-text-field>
      </v-col>

      <!-- <v-col cols="12" md="3" sm="6">
        Estado
        <v-text-field class="border" flat hide-details solo dense></v-text-field>
      </v-col> -->
    </v-row>
    <v-row class="my-3">
      <v-spacer></v-spacer>
      <v-btn class="mx-1 my-4 border" elevation="0" color="#0D52D6" dark small @click="addLocation"
        >Guardar</v-btn
      >
      <v-btn class="mx-1 my-4 border" elevation="0" small>Cancelar</v-btn>
    </v-row>
  </div>
</template>
<script>
export default {
  data: () => ({
    location: {},
  }),
  methods: {
    getLocation() {
      axios
        .get(`/api/v1/business-locations/${this.$route.params.id}`)
        .then(response => {
          this.location = response.data.data;
        })
        .catch(error => {
          console.log(error);
        });
    },
    addLocation() {
      axios
        .put(`/api/v1/business-locations/${this.$route.params.id}`, this.location)
        .then(response => {
          this.$router.replace({ name: 'listStockLocation' });
        })
        .catch(error => {
          console.log(error);
        });
    },
  },
  mounted() {
    this.getLocation();
  },
};
</script>
<style scoped>
.border {
  border: 1px solid #d2d6de;
  background-color: white;
}
</style>
