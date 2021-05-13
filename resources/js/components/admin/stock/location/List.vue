<template>
  <div>
    <div class="d-flex my-3">
      <h3>Almacenes</h3>
      <v-spacer></v-spacer>
      <v-btn @click="newItem" small>
        Nuevo Almacen
      </v-btn>
    </div>
    <v-data-table
      class="border"
      hide-default-footer
      disable-pagination
      :headers="headers"
      :items="locations"
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
        value: 'Name',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Direccion',
        value: 'Address',
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
        text: 'Region',
        value: 'Region',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Codigo Postal',
        value: 'PostalCode',
        align: 'center',
        sortable: false,
      },
      { text: 'Acciones', value: 'actions', sortable: false, align: 'center' },
    ],
    locations: [],
  }),
  methods: {
    getList() {
      axios
        .get('/api/v1/business-locations')
        .then(response => {
          this.locations = response.data.data;
          console.log(response.data.data);
        })
        .catch(error => {});
    },

    newItem() {
      this.$router.push({
        name: 'addStockLocation',
      });
    },

    editItem(item) {
      this.$router.push({
        name: 'editStockLocation',
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
        .delete(`/api/v1/business-locations/${this.idDelete}`)
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
