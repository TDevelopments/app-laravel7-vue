<template>
  <div>
    <div class="d-flex my-3">
      <h3>Roles de Usuario</h3>
      <v-spacer></v-spacer>
      <v-btn @click="newItem" small>
        Nuevo Rol
      </v-btn>
    </div>
    <v-data-table
      class="border"
      hide-default-footer
      disable-pagination
      :headers="headers"
      :items="roles"
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
        text: 'Nombre de Rol',
        value: 'name',
        align: 'center',
        sortable: false,
      },
      { text: 'Acciones', value: 'actions', sortable: false, align: 'center' },
    ],
    roles: [],
  }),
  methods: {
    getList() {
      axios
        .get('/api/v1/roles')
        .then(response => {
          this.roles = response.data.data;
        })
        .catch(error => {});
    },

    newItem() {
      this.$router.push({
        name: 'addRoles',
      });
    },

    editItem(item) {
      this.$router.push({
        name: 'editRoles',
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
        .delete(`/api/v1/sale-payment-roles/${this.idDelete}`)
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
