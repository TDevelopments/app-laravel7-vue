<template>
  <div>
    <div class="d-flex my-3">
      <h3>Productos</h3>
      <v-spacer></v-spacer>
      <v-btn @click="newItem" small>
        Nuevo Producto
      </v-btn>
    </div>
    <v-data-table
      class="border"
      disable-pagination
      hide-default-footer
      no-data-text="No se encontraron datos"
      :headers="headers"
      :items="prodc"
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
    prodc: [],
    headers: [
      {
        text: 'Nombre del Producto',
        value: 'ProductName',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Precio Unitario',
        value: 'UnitPrice',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Precio de Venta',
        value: 'SellingPrice',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Usuario',
        value: 'user',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Stock',
        value: 'stock',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Almacen',
        value: 'locations',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Acciones',
        value: 'actions',
        align: 'center',
        sortable: false,
      },
    ],
  }),
  methods: {
    getList() {
      axios
        .get('/api/v1/sale-products')
        .then(response => {
          this.prodc = response.data.data;
          console.log(response);
        })
        .catch(error => {});
    },
    editItem(item) {
      this.$router.push({
        name: 'editStockProduct',
        params: {
          id: item.id,
        },
      });
    },
    newItem() {
      this.$router.push({
        name: 'addStockProduct',
      });
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
