<template>
  <v-card>
    <v-data-table
      :headers="headers"
      :items="categories"
      :loading="loading"
      loading-text="Loading... Please wait"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Categorias</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>

          <v-btn color="#1B1B1B" dark @click="newCategory">
            Nueva Categoria
          </v-btn>

          <v-dialog v-model="dialogDelete" max-width="290">
            <v-card>
              <v-card-title class="headline"> Eliminar Categoria </v-card-title>

              <v-card-text>
                ¿Estas seguro de eliminar esta <strong>categoría</strong>?
              </v-card-text>
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
  </v-card>
</template>

<script>
export default {
  data: () => ({
    dialogDelete: false,
    loading: false,
    headers: [
      {
        text: "Nombre Categoria",
        value: "name",
        align: "center",
        sortable: false
      },
      { text: "Acciones", value: "actions", sortable: false, align: "center" }
    ],
    categories: [],
    idDelete: null,
  }),
  methods: {
    getList() {
      axios
        .get("/api/v1/categories")
        .then(response => {
          this.loading = false;
          this.categories = response.data.data;
        })
        .catch(error => {});
    },

    editItem(item) {
      this.$router.push({
        name: "editCategory",
        params: {
          id: item.id
        }
      });
    },

    deleteItem(item) {
      this.dialogDelete = true;
      this.idDelete = item.id;
    },

    deleteItemConfirm() {
      axios
        .delete(`/api/v1/categories/${this.idDelete}`)
        .then(response => {
          this.getList();
          this.closeDelete();
        })
        .catch(error => {
        });
    },

    closeDelete() {
      this.dialogDelete = false;
    },
    newCategory() {
      this.$router.push({
        name: "addCategory"
      });
    }
  },
  mounted() {
    this.getList();
  },
};
</script>
