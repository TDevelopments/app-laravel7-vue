<template>
  <div class="my-3 mx-5">
    <v-row>
      <h3>Añadir Marca</h3>
    </v-row>
    <v-row class="border mb-3">
      <v-col cols="12" sm="6" md="6">
        Nombre Marca
        <v-text-field
          v-model="name"
          solo
          required
          placeholder="Example"
          v-on:keyup.enter="addBrand"
          class="border"
          flat
          dense
          hide-details
        ></v-text-field>
      </v-col>
      <v-col cols="12" sm="6" md="6">
        Notas
        <v-text-field
          v-model="note"
          solo
          required
          placeholder="Example"
          v-on:keyup.enter="addBrand"
          class="border"
          flat
          dense
          hide-details
        ></v-text-field>
      </v-col>
    </v-row>
    <v-btn color="success" class="mr-4 mt-3" @click="addBrand">
      Guardar
    </v-btn>
  </div>
</template>

<script>
export default {
  data: () => ({
    valid: true,
    name: '',
    note: null,
  }),
  methods: {
    validate() {
      console.log(this.arrivalsDates);
    },
    addBrand() {
      let data = {
        BrandName: this.name,
        Note: this.note,
      };
      if (this.note == null) {
        delete data.Note;
      }
      axios
        .post('/api/v1/sale-brands', data)
        .then(response => {
          this.$router.replace({ name: 'listStockBrand' });
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
