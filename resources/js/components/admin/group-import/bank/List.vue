<template>
  <div>
    <v-data-table
      :headers="headers"
      :items="bank"
      :loading="loading"
      loading-text="Loading... Please wait"
      :page.sync="page"
      :items-per-page="itemsPerPage"
      hide-default-footer
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Bancos</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>

          <v-btn color="#1B1B1B" dark @click="newBank">
            Nuevo Banco
          </v-btn>

          <v-dialog v-model="dialogDelete" max-width="290">
            <v-card>
              <v-card-title class="headline"> Eliminar Banco </v-card-title>

              <v-card-text> ¿Estas seguro de eliminar este <strong>banco</strong>? </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>

                <v-btn color="green darken-1" text @click="closeDelete">
                  Cancelar
                </v-btn>

                <v-btn color="green darken-1" text @click="deleteItemConfirm">
                  Aceptar
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
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
    <div class="text-center pt-2">
      <v-pagination v-model="page" :length="pagination" @input="next"></v-pagination>
    </div>
  </div>
</template>

<script>
export default {
  data: () => ({
    dialogDelete: false,
    loading: false,
    headers: [
      {
        text: 'Nombre Banco',
        value: 'name',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Nombre Corto',
        value: 'short_name',
        align: 'center',
        sortable: false,
      },
      { text: 'Acciones', value: 'actions', sortable: false, align: 'center' },
    ],
    bank: [],
    idDelete: null,
    page: 1,
    pageCount: 0,
    itemsPerPage: 15,
    pagination: null,
  }),
  methods: {
    getList() {
      axios
        .get('/api/v1/banks')
        .then(response => {
          this.bank = response.data;
          console.log(response);
        })
        .catch(error => {});
    },

    editItem(item) {
      this.$router.push({
        name: 'editBank',
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
        .delete(`/api/v1/banks/${this.idDelete}`)
        .then(response => {
          this.getList();
          this.closeDelete();
        })
        .catch(error => {});
    },

    closeDelete() {
      this.dialogDelete = false;
    },
    newBank() {
      this.$router.push({
        name: 'addBank',
      });
    },
    next(page) {
      axios
        .get(`/api/v1/payment-concepts?page=${page}`)
        .then(response => {
          this.loading = false;
          this.catalogues = response.data.data;
          this.pagination = response.data.meta.last_page;
          console.log(response);
        })
        .catch(error => {});
    },
  },
  mounted() {
    this.getList();
  },
};
</script>
