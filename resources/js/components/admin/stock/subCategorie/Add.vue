<template>
  <div class="my-3 mx-5">
    <v-row>
      <h3>Añadir Sub-Categoria</h3>
    </v-row>
    <v-row class="border mb-3">
      <v-col cols="12" sm="6" md="6">
        Nombre de Sub-Categoria
        <v-text-field
          v-model="name"
          solo
          required
          placeholder="Example"
          v-on:keyup.enter="addSubCategorie"
          class="border"
          flat
          dense
          hide-details
        ></v-text-field>
      </v-col>
    </v-row>
    <v-btn color="success" class="mr-4 mt-3" @click="addSubCategorie">
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
    addSubCategorie() {
      let data = {
        SubCategoryName: this.name,
      };
      axios
        .post('/api/v1/sale-sub-categories', data)
        .then(response => {
          this.$router.replace({ name: 'listStockSubCategorie' });
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
