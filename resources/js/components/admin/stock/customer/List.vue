<template>
  <div>
    <div>
      <h3>Filtros</h3>
      <v-row>
        <v-col>
          Búsqueda (Nombre, DNI, Email, Teléfono)
          <v-text-field
            class="border"
            flat
            hide-details
            solo
            dense
            append-icon="mdi-magnify"
            v-model="searchCustomer"
            ref="nomCli"
          ></v-text-field>
        </v-col>
        <v-col class="align-center justify-end px-0 pr-2 d-flex">
          <v-btn small @click="search" class="mx-1" color="#0D52D6" dark> Buscar </v-btn>
          <v-btn small @click="clear" class="mx-1"> Limpiar </v-btn>
        </v-col>
      </v-row>
    </div>
    <v-divider></v-divider>
    <div class="d-flex my-3">
      <h3>Clientes</h3>
      <v-spacer></v-spacer>
      <v-btn @click="newItem" small>
        Nuevo Cliente
      </v-btn>
    </div>
    <v-data-table
      class="border"
      hide-default-footer
      disable-pagination
      :headers="headers"
      :items="customers"
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
        text: 'Nombre',
        value: 'FullName',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Direccion',
        value: 'Address1',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Ciudad',
        value: 'City',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Pais',
        value: 'Country',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Telefono',
        value: 'Phone',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Email',
        value: 'Email',
        align: 'center',
        sortable: false,
      },
      { text: 'Acciones', value: 'actions', sortable: false, align: 'center' },
    ],
    customers: [],
    searchCustomer: '',
    page: 1,
    pageCount: 0,
    itemsPerPage: 15,
    pagination: null,
  }),
  methods: {
    getList() {
      if (this.searchCustomer == null) {
        this.searchCustomer = '';
      }
      axios
        .get('/api/v1/sale-customers')
        .then(response => {
          this.customers = response.data.data;
          this.pagination = response.data.meta.last_page;
          console.log(response.data.data);
        })
        .catch(error => {});
    },
    next(page) {
      if (this.searchCustomer == null) {
        this.searchCustomer = '';
      }
      axios
        .get(`/api/v1/sale-customers?Search=${this.searchCustomer}&page=${page}`)
        .then(response => {
          this.customers = response.data.data;
          this.pagination = response.data.meta.last_page;
          console.log(response);
        })
        .catch(error => {});
    },

    newItem() {
      this.$router.push({
        name: 'addStockCustomer',
      });
    },

    editItem(item) {
      this.$router.push({
        name: 'editStockCustomer',
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
        .delete(`/api/v1/sale-customers/${this.idDelete}`)
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
      if (this.page != 1) {
        this.page = 1;
      }
      if (this.searchCustomer == null) {
        this.searchCustomer = '';
      }
      axios
        .get(`/api/v1/sale-customers?Search=${this.searchCustomer}&page=${this.page}`)
        .then(response => {
          this.customers = response.data.data;
          this.pagination = response.data.meta.last_page;
          console.log(response);
        })
        .catch(error => {});
    },
    clear() {
      this.searchCustomer = '';
      this.getList();
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
