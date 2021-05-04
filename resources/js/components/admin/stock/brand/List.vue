<template>
  <div>
    <div class="d-flex my-3">
      <h3>Marcas</h3>
      <v-spacer></v-spacer>
      <v-btn @click="newItem" small>
        Nueva Marca
      </v-btn>
    </div>
    <v-data-table
      class="border"
      hide-default-footer
      disable-pagination
      :headers="headers"
      :items="brands"
      no-data-text="No se encontraron datos"
    >
      <template v-slot:[`item.actions`]="{ item }">
        <v-icon color="#D6B331" small class="mr-2" @click="editItem(item)">
          mdi-pencil
        </v-icon>
        <v-icon color="black" small @click="deleteItem(item)">
          mdi-delete
        </v-icon>
      </template>
    </v-data-table>
  </div>
</template>

<script>
export default {
  data: () => ({
    headers: [
      {
        text: 'Nombre de Marca',
        value: 'BrandName',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Notas',
        value: 'Note',
        align: 'center',
        sortable: false,
      },
      { text: 'Acciones', value: 'actions', sortable: false, align: 'center' },
    ],
    brands: [],
  }),
  methods: {
    getList() {
      axios
        .get('/api/v1/sale-brands')
        .then(response => {
          this.brands = response.data.data;
        })
        .catch(error => {});
    },

    newItem() {
      this.$router.push({
        name: 'addStockBrand',
      });
    },

    editItem(item) {
      this.$router.push({
        name: 'editStockBrand',
        params: {
          id: item.id,
        },
      });
    },

    deleteItem(item) {
      this.dialogDelete = true;
      this.idDelete = item.id;
    },

    deleteItemConfirm() {
      axios
        .delete(`/api/v1/sale-brands/${this.idDelete}`)
        .then(response => {
          this.getList();
          this.closeDelete();
        })
        .catch(error => {});
    },

    closeDelete() {
      this.dialogDelete = false;
    },
  },
  mounted() {
    this.getList();
  },
};
</script>
<style scoped>
.border {
  border: 1px solid #d2d6de;
}
</style>
