<template>
  <div>
    <div>
      <h3>Filtros</h3>
      <v-row>
        <v-col>
          Nombre Cliente
          <v-select
            hide-details
            flat
            class="border"
            solo
            dense
            v-model="nameCustomer"
            :items="customers"
            item-text="FullName"
            item-value="id"
            no-data-text="No hay se encontraron datos"
            clearable
            @click:clear="clearSearch"
          ></v-select>
        </v-col>
        <!-- <v-col class="text-center align-center justify-center px-0 d-flex">
          <v-btn small class="mx-1" color="#0D52D6" dark> Buscar </v-btn>
          <v-btn small @click="clear" class="mx-1"> Limpiar </v-btn>
        </v-col> -->
      </v-row>
    </div>
    <v-divider></v-divider>
    <div class="d-flex my-3">
      <h3>Delivery</h3>
      <v-spacer></v-spacer>
      <v-btn @click="newItem" small>
        Nuevo Delivery
      </v-btn>
    </div>
    <v-data-table
      class="border"
      hide-default-footer
      disable-pagination
      :headers="headers"
      :items="deliveries"
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
    <div class="text-center pt-2">
      <v-pagination v-model="page" :length="pagination" @input="next"></v-pagination>
    </div>
  </div>
</template>

<script>
export default {
  data: () => ({
    headers: [
      {
        text: 'Cliente',
        value: 'Customer.FullName',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Hecho por',
        value: 'User.name',
        align: 'center',
        sortable: false,
      },
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
      { text: 'Acciones', value: 'actions', sortable: false, align: 'center' },
    ],
    deliveries: [],
    customers: [],
    nameCustomer: '',
    page: 1,
    pageCount: 0,
    itemsPerPage: 15,
    pagination: null,
  }),
  methods: {
    getList() {
      if (this.nameCustomer == null) {
        this.nameCustomer = '';
      }
      axios
        .get('/api/v1/sale-deliveries')
        .then(response => {
          this.deliveries = response.data.data;
          this.pagination = response.data.meta.last_page;
          console.log(response);
        })
        .catch(error => {});
    },
    next(page) {
      if (this.nameCustomer == null) {
        this.nameCustomer = '';
      }
      console.log(this.nameCustomer);
      axios
        .get(`/api/v1/sale-deliveries?CustomerId=${this.nameCustomer}&page=${page}`)
        .then(response => {
          this.loading = false;
          this.deliveries = response.data.data;
          this.pagination = response.data.meta.last_page;
          console.log(response);
        })
        .catch(error => {});
    },

    getCustomer() {
      axios
        .get('/api/v1/sale-customers?list=true')
        .then(response => {
          this.customers = response.data.data;
        })
        .catch(error => {});
    },

    newItem() {
      this.$router.push({
        name: 'addStockDelivery',
      });
    },

    editItem(item) {
      this.$router.push({
        name: 'editStockDelivery',
        params: {
          id: item.Id,
        },
      });
    },

    deleteItem(item) {
      this.dialogDelete = true;
      this.idDelete = item.CategoryId;
    },

    deleteItemConfirm() {
      axios
        .delete(`/api/v1/sale-deliveries/${this.idDelete}`)
        .then(response => {
          this.getList();
          this.closeDelete();
        })
        .catch(error => {});
    },

    closeDelete() {
      this.dialogDelete = false;
    },
    clearSearch() {
      this.getList();
    },
  },
  watch: {
    nameCustomer: function(newQuestion) {
      if (this.page != 1) {
        this.page = 1;
      }
      if (this.nameCustomer == null) {
        this.nameCustomer = '';
      }
      axios
        .get(`/api/v1/sale-deliveries?CustomerId=${newQuestion}&page=${this.page}`)
        .then(response => {
          this.deliveries = response.data.data;
          this.pagination = response.data.meta.last_page;
          console.log(response.data.data);
        })
        .catch(error => {});
    },
  },
  mounted() {
    this.getList();
    this.getCustomer();
  },
};
</script>
<style scoped>
.border {
  border: 1px solid #d2d6de;
}
</style>
