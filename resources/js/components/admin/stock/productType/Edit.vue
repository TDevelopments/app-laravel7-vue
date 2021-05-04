<template>
  <div class="my-3 mx-5">
    <v-row>
      <h3>Editar Tipo de Producto</h3>
    </v-row>
    <v-row class="border mb-3">
      <v-col cols="12" sm="6" md="6">
        Nombre de Tipo de Producto
        <v-text-field
          v-model="productType.TypeName"
          solo
          required
          placeholder="Example"
          v-on:keyup.enter="updateProductType"
          class="border"
          flat
          dense
          hide-details
        ></v-text-field>
      </v-col>
    </v-row>
    <v-btn color="success" class="mr-4 mt-3" @click="updateProductType">
      Guardar
    </v-btn>
  </div>
</template>

<script>
export default {
  data: () => ({
    valid: true,
    productType: {},
  }),

  methods: {
    validate() {
      console.log(this.arrivalsDates);
    },
    getProductType() {
      axios
        .get(`/api/v1/sale-product-types/${this.$route.params.id}`)
        .then(response => {
          this.productType = response.data.data;
        })
        .catch(error => {});
    },
    updateProductType() {
      axios
        .put(`/api/v1/sale-product-types/${this.$route.params.id}`, this.productType)
        .then(response => {
          this.$router.replace({ name: 'listStockProductType' });
        })
        .catch(error => {});
    },
  },
  mounted() {
    this.getProductType();
  },
};
</script>
<style scoped>
.border {
  border: 1px solid #d2d6de;
  background-color: white;
}
</style>
