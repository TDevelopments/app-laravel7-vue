<template>
  <div class="my-3 mx-5">
    <v-row>
      <h3>Editar Sub-Categoria</h3>
    </v-row>
    <v-row class="border mb-3">
      <v-col cols="12" sm="6" md="6">
        Nombre de Sub-Categoria
        <v-text-field
          v-model="subCategorie.SubCategoryName"
          solo
          required
          placeholder="Example"
          v-on:keyup.enter="updateSubCategorie"
          class="border"
          flat
          dense
          hide-details
        ></v-text-field>
      </v-col>
    </v-row>
    <v-btn color="success" class="mr-4 mt-3" @click="updateSubCategorie">
      Guardar
    </v-btn>
  </div>
</template>

<script>
export default {
  data: () => ({
    valid: true,
    subCategorie: {},
  }),

  methods: {
    validate() {
      console.log(this.arrivalsDates);
    },
    getProductType() {
      axios
        .get(`/api/v1/sale-sub-categories/${this.$route.params.id}`)
        .then(response => {
          this.subCategorie = response.data.data;
        })
        .catch(error => {});
    },
    updateSubCategorie() {
      axios
        .put(`/api/v1/sale-sub-categories/${this.$route.params.id}`, this.subCategorie)
        .then(response => {
          this.$router.replace({ name: 'listStockSubCategorie' });
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
