<template>
  <div class="my-3 mx-5">
    <v-row>
      <h3>Añadir Estado de Orden</h3>
    </v-row>
    <v-row class="border mb-3">
      <v-col cols="12" sm="6" md="6">
        Nombre de Estado de Orden (*)
        <v-text-field
          v-model="name"
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
          v-model="shortName"
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
    <v-btn color="success" class="mr-4 mt-3" @click="addState">
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
    addState() {
      let data = {
        Name: this.name,
        ShortName: this.shortName,
      };
      axios
        .post('/api/v1/sale-state-orders', data)
        .then(response => {
          this.$router.replace({ name: 'listStockState' });
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
