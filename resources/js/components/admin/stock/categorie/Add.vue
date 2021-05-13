<template>
  <div class="my-3 mx-5">
    <v-row>
      <h3>Añadir Categoria</h3>
    </v-row>
    <v-row class="border mb-3">
      <v-col cols="12" sm="6" md="6">
        Nombre Categoria
        <v-text-field
          v-model="name"
          solo
          required
          placeholder="Example"
          v-on:keyup.enter="addCategorie"
          class="border"
          flat
          dense
          hide-details
        ></v-text-field>
      </v-col>
      <v-col cols="12" sm="6" md="6">
        Descripcion
        <v-text-field
          v-model="descripcion"
          solo
          required
          placeholder="Example"
          v-on:keyup.enter="addCategorie"
          class="border"
          flat
          dense
          hide-details
        ></v-text-field>
      </v-col>
    </v-row>
    <v-btn color="success" class="mr-4 mt-3" @click="addCategorie">
      Guardar
    </v-btn>
  </div>
</template>

<script>
export default {
  data: () => ({
    valid: true,
    name: '',
    descripcion: '',
  }),
  methods: {
    validate() {
      console.log(this.arrivalsDates);
    },
    addCategorie() {
      let data = {
        CategoryName: this.name,
        CategoryDescription: this.descripcion,
      };
      axios
        .post('/api/v1/sale-categories', data)
        .then(response => {
          this.$router.replace({ name: 'listStockCategorie' });
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
