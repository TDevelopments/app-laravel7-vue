<template>
  <div>
    <div class="d-flex my-3">
      <h3>Estados de Productos</h3>
      <v-spacer></v-spacer>
      <v-btn @click="newItem" small>
        Nueva Estado de Producto
      </v-btn>
    </div>
    <v-data-table
      class="border"
      hide-default-footer
      disable-pagination
      :headers="headers"
      :items="productStatus"
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
        text: 'Nombre de Estado de Producto',
        value: 'Name',
        align: 'center',
        sortable: false,
      },
      { text: 'Acciones', value: 'actions', sortable: false, align: 'center' },
    ],
    productStatus: [],
  }),
  methods: {
    getList() {
      axios
        .get('/api/v1/sale-state-orders')
        .then(response => {
          this.productStatus = response.data.data;
        })
        .catch(error => {});
    },

    newItem() {
      this.$router.push({
        name: 'addStockState',
      });
    },

    editItem(item) {
      this.$router.push({
        name: 'editStockState',
        params: {
          id: item.id,
        },
      });
    },

    deleteItem(item) {
      this.dialogDelete = true;
      this.idDelete = item.CategoryId;
    },

    deleteItemConfirm() {
      axios
        .delete(`/api/v1/sale-product-status/${this.idDelete}`)
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
