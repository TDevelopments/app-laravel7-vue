<template>
  <div class="my-3 mx-5">
    <v-row>
      <h3>Añadir Estado de Producto</h3>
    </v-row>
    <v-row class="border mb-3">
      <v-col cols="12" sm="6" md="6">
        Nombre de Estado de Producto
        <v-text-field
          v-model="name"
          solo
          required
          placeholder="Example"
          v-on:keyup.enter="addProductStatus"
          class="border"
          flat
          dense
          hide-details
        ></v-text-field>
      </v-col>
    </v-row>
    <v-btn color="success" class="mr-4 mt-3" @click="addProductStatus">
      Guardar
    </v-btn>
  </div>
</template>

<script>
export default {
  data: () => ({
    valid: true,
    name: '',
  }),
  methods: {
    validate() {
      console.log(this.arrivalsDates);
    },
    addProductStatus() {
      let data = {
        StatusName: this.name,
      };
      axios
        .post('/api/v1/sale-product-status', data)
        .then(response => {
          this.$router.replace({ name: 'listStockStatus' });
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
