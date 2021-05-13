<template>
  <div class="my-3 mx-5">
    <v-row>
      <h3>Editar Categoria</h3>
    </v-row>
    <v-row class="border mb-3">
      <v-col cols="12" sm="6" md="6">
        Nombre Marca
        <v-text-field
          v-model="categorie.CategoryName"
          solo
          required
          placeholder="Example"
          v-on:keyup.enter="updateCategorie"
          class="border"
          flat
          dense
          hide-details
        ></v-text-field>
      </v-col>
      <v-col cols="12" sm="6" md="6">
        Notas
        <v-text-field
          v-model="categorie.CategoryDescription"
          solo
          required
          placeholder="Example"
          v-on:keyup.enter="updateCategorie"
          class="border"
          flat
          dense
          hide-details
        ></v-text-field>
      </v-col>
    </v-row>
    <v-btn color="success" class="mr-4 mt-3" @click="updateCategorie">
      Guardar
    </v-btn>
  </div>
</template>

<script>
export default {
  data: () => ({
    valid: true,
    categorie: {},
  }),

  methods: {
    validate() {
      console.log(this.arrivalsDates);
    },
    getBrand() {
      axios
        .get(`/api/v1/sale-categories/${this.$route.params.id}`)
        .then(response => {
          this.categorie = response.data.data;
        })
        .catch(error => {});
    },
    updateCategorie() {
      axios
        .put(`/api/v1/sale-categories/${this.$route.params.id}`, this.categorie)
        .then(response => {
          this.$router.replace({ name: 'listStockCategorie' });
        })
        .catch(error => {});
    },
  },
  mounted() {
    this.getBrand();
  },
};
</script>
<style scoped>
.border {
  border: 1px solid #d2d6de;
  background-color: white;
}
</style>
