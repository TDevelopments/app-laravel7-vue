<template>
  <div>
    <div>
      <h3>Filtros</h3>
      <v-row>
        <v-col>
          Nombre Cliente
          <v-text-field
            class="border"
            flat
            hide-details
            solo
            dense
            append-icon="mdi-magnify"
            v-model="nameCustomer"
            ref="nomCli"
          ></v-text-field>
        </v-col>
        <v-col>
          Nombre Producto
          <v-text-field
            class="border"
            flat
            hide-details
            solo
            dense
            append-icon="mdi-magnify"
            v-model="nameProduct"
          ></v-text-field>
        </v-col>
        <v-col>
          Estado
          <v-select
            hide-details
            flat
            class="border"
            solo
            dense
            v-model="nameStatus"
            :items="status"
            item-text="StatusName"
            item-value="id"
            append-icon="mdi-magnify"
            no-data-text="No hay se encontraron datos"
          ></v-select>
        </v-col>
        <v-col>
          Almacen
          <v-select
            hide-details
            flat
            class="border"
            solo
            dense
            v-model="nameLocation"
            :items="locations"
            item-text="Name"
            item-value="id"
            append-icon="mdi-magnify"
            no-data-text="No hay se encontraron datos"
          ></v-select>
        </v-col>
        <v-col class="text-center align-center justify-center px-0 d-flex">
          <v-btn small @click="search" class="mx-1" color="#0D52D6" dark>
            Buscar
          </v-btn>
          <v-btn small @click="clear" class="mx-1">
            Limpiar
          </v-btn>
        </v-col>
      </v-row>
    </div>
    <v-divider></v-divider>
    <div class="d-flex my-3">
      <h3>Stock</h3>
      <v-spacer></v-spacer>
      <v-btn @click="newItem" small>
        Nuevo Stock
      </v-btn>
    </div>
    <v-data-table
      class="border"
      hide-default-footer
      disable-pagination
      :headers="headers"
      :items="stock"
      no-data-text="No se encontraron datos"
    >
      <template v-slot:[`item.Customer`]="{ item }">
        {{ item.Customer.FirstName }} {{ item.Customer.LastName }}
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
    nameCustomer: '',
    nameLocation: '',
    nameStatus: '',
    nameProduct: '',
    headers: [
      {
        text: 'Producto',
        value: 'Product.ProductName',
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
        text: 'Estado',
        value: 'ProductStatus.StatusName',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Almacen',
        value: 'BusinessLocation.Name',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Cliente',
        value: 'Customer',
        align: 'center',
        sortable: false,
      },
      { text: 'Acciones', value: 'actions', sortable: false, align: 'center' },
    ],
    stock: [],
    locations: [],
    status: [],
  }),
  methods: {
    getProductStatus() {
      axios
        .get('/api/v1/sale-product-status?list=true')
        .then(response => {
          this.status = response.data.data;
          console.log(response);
        })
        .catch(error => {});
    },
    getLocations() {
      axios
        .get('/api/v1/business-locations?list=true')
        .then(response => {
          this.locations = response.data.data;
          console.log(response);
        })
        .catch(error => {});
    },
    getList() {
      axios
        .get('/api/v1/sale-stock-records')
        .then(response => {
          this.stock = response.data.data;
          console.log(response.data.data);
        })
        .catch(error => {});
    },

    newItem() {
      this.$router.push({
        name: 'addStockStockRecord',
      });
    },

    editItem(item) {
      this.$router.push({
        name: 'editStockStockRecord',
        params: {
          id: item.Id,
        },
      });
    },

    deleteItem(item) {
      // this.dialogDelete = true;
      // this.idDelete = item.CategoryId;
      axios
        .delete(`/api/v1/sale-stock-records/${item.Id}`)
        .then(response => {
          this.getList();
          this.closeDelete();
        })
        .catch(error => {});
    },

    deleteItemConfirm() {
      axios
        .delete(`/api/v1/sale-stock-records/${this.idDelete}`)
        .then(response => {
          this.getList();
          this.closeDelete();
        })
        .catch(error => {});
    },

    closeDelete() {
      this.dialogDelete = false;
    },

    search() {
      axios
        .get(
          `/api/v1/sale-stock-records?BusinessId=${this.nameLocation}&StatusId=${this.nameStatus}&ProductName=${this.nameProduct}&CustomerName=${this.nameCustomer}`
        )
        .then(response => {
          console.log('mundo', response);
          this.stock = response.data.data;
        })
        .catch(error => {});
    },
    clear() {
      this.getList();
      this.nameLocation = null;
      this.nameCustomer = null;
      this.nameStatus = null;
      this.nameProduct = null;
    },
  },
  mounted() {
    this.getList();
    this.getProductStatus();
    this.getLocations();
  },
};
</script>
<style scoped>
.border {
  border: 1px solid #d2d6de;
  background-color: white;
}
</style>
