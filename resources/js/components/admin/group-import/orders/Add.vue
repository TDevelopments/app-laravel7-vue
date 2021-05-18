<template>
  <div class="d-flex">
    <v-select
      :items="catalogues"
      item-text="name"
      item-value="id"
      label="Seleccionar Catalogo"
      no-data-text="No hay se encontraron datos"
      dense
      outline
    ></v-select>
  </div>
</template>

<script>
export default {
  data: () => ({
    catalogues: [],
  }),
  methods: {
    getCatalogues() {
      axios.get('/api/v1/catalogues-availables').then((response) => {
        this.catalogues = response.data.data;
      });
    },
  },
  mounted() {
    this.getCatalogues();
  },
};
</script>
