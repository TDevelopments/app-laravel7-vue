<template>
  <div class="my-3 mx-5">
    <v-row>
      <h3>Añadir Unidad</h3>
    </v-row>
    <v-row class="border mb-3">
      <v-col cols="12" sm="6" md="6">
        Nombre de Unidad
        <v-text-field
          v-model="name"
          solo
          required
          placeholder="Example"
          v-on:keyup.enter="addUnit"
          class="border"
          flat
          dense
          hide-details
        ></v-text-field>
      </v-col>
      <v-col cols="12" sm="6" md="6">
        Nombre Corto de Unidad
        <v-text-field
          v-model="shortName"
          solo
          required
          placeholder="Example"
          v-on:keyup.enter="addUnit"
          class="border"
          flat
          dense
          hide-details
        ></v-text-field>
      </v-col>
    </v-row>
    <v-btn color="success" class="mr-4 mt-3" @click="addUnit">
      Guardar
    </v-btn>
  </div>
</template>

<script>
export default {
  data: () => ({
    valid: true,
    name: '',
    shortName: '',
  }),
  methods: {
    validate() {
      console.log(this.arrivalsDates);
    },
    addUnit() {
      let data = {
        UnitName: this.name,
        UnitShortName: this.shortName,
      };
      axios
        .post('/api/v1/sale-units', data)
        .then(response => {
          this.$router.replace({ name: 'listStockUnit' });
        })
        .catch(error => {
          console.log(error);
        });
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
