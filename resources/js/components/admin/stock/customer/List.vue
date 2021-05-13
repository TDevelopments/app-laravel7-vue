<template>
  <div>
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
  </div>
</template>

<script>
export default {
  data: () => ({
    headers: [
      {
        text: 'Nombre',
        value: 'FirstName',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Apellido',
        value: 'LastName',
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
  }),
  methods: {
    getList() {
      axios
        .get('/api/v1/sale-customers')
        .then(response => {
          this.customers = response.data.data;
          console.log(response.data.data);
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
