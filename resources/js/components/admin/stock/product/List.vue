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
      show-expand
      :expanded.sync="expanded"
      single-expand
      no-data-text="No se encontraron datos"
      :headers="headers"
      :items="prodc"
    >
      <template v-slot:expanded-item="{ headers, item }">
        <td :colspan="headers.length" class="p-0">
          <v-data-table
            v-if="item.StockRecords != null"
            :headers="headersStock"
            :items="item.StockRecords"
            disable-pagination
            hide-default-footer
          >
            <template v-slot:[`item.actions`]="{ item }">
              <div>
                <div v-if="item.Customer != null">
                  {{ item.Customer.FullName }}
                </div>
                <div v-if="item.Customer == null">
                  No se Encontro un Cliente
                </div>
              </div>
            </template>
          </v-data-table>
          <div v-else>
            No se entontraron datos
          </div>
        </td>
      </template>
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
    expanded: [],
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
        text: 'Stock',
        value: 'Stock',
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
    headersStock: [
      {
        text: 'Almacen',
        value: 'BusinessLocation.Name',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Estado',
        value: 'ProductStatus.StatusName',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Cantidad',
        value: 'Quantity',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Cliente',
        value: 'Customer.FullName',
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
