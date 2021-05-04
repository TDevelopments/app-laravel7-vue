<template>
  <div class="my-3 mx-5">
    <v-row>
      <h3>Editar Unidad</h3>
    </v-row>
    <v-row class="border mb-3">
      <v-col cols="12" sm="6" md="6">
        Nombre de Unidad
        <v-text-field
          v-model="unit.UnitName"
          solo
          required
          placeholder="Example"
          v-on:keyup.enter="updateUnit"
          class="border"
          flat
          dense
          hide-details
        ></v-text-field>
      </v-col>
      <v-col cols="12" sm="6" md="6">
        Nombre Corto de Unidad
        <v-text-field
          v-model="unit.UnitShortName"
          solo
          required
          placeholder="Example"
          v-on:keyup.enter="updateUnit"
          class="border"
          flat
          dense
          hide-details
        ></v-text-field>
      </v-col>
    </v-row>
    <v-btn color="success" class="mr-4 mt-3" @click="updateUnit">
      Guardar
    </v-btn>
  </div>
</template>

<script>
export default {
  data: () => ({
    valid: true,
    unit: {},
  }),

  methods: {
    validate() {
      console.log(this.arrivalsDates);
    },
    getUnit() {
      axios
        .get(`/api/v1/sale-units/${this.$route.params.id}`)
        .then(response => {
          this.unit = response.data.data;
        })
        .catch(error => {});
    },
    updateUnit() {
      axios
        .put(`/api/v1/sale-units/${this.$route.params.id}`, this.unit)
        .then(response => {
          this.$router.replace({ name: 'listStockUnit' });
        })
        .catch(error => {});
    },
  },
  mounted() {
    this.getUnit();
  },
};
</script>
<style scoped>
.border {
  border: 1px solid #d2d6de;
  background-color: white;
}
</style>
