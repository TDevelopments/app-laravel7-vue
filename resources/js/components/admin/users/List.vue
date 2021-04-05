<template>
  <div>
    <v-data-table
      :headers="headers"
      :items="users"
      :loading="loading"
      item-key="item.id"
      loading-text="Loading... Please wait"
      :page.sync="page"
      :items-per-page="itemsPerPage"
      hide-default-footer
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Usuarios</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>

          <v-btn color="#1B1B1B" dark @click="newProduct">
            Nuevo Usuario
          </v-btn>

          <v-dialog v-model="dialogDelete" max-width="290">
            <v-card>
              <v-card-title class="headline"> Eliminar Usuario </v-card-title>

              <v-card-text>
                ¿Estas seguro de eliminar este <strong>Usuario</strong>?
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
      <template v-slot:[`item.gender`]="{ item }">
        {{ item.gender == "masculine" ? "Masculino" : "Femenino" }}
      </template>
      <template v-slot:[`item.arrivals`]="{ item }">
        <p v-for="ar in item.arrivals" :key="ar.id">
          {{ ar.city }} -> {{ ar.arrival_date }}
        </p>
      </template>
      <template v-slot:[`item.actions`]="{ item }">
        <v-icon small @click="editItem(item)" color="#D6B331">
          mdi-pencil
        </v-icon>
        <v-icon small @click="deleteItem(item)" color="black">
          mdi-delete
        </v-icon>
      </template>
    </v-data-table>
    <div class="text-center pt-2">
      <v-pagination
        v-model="page"
        :length="pagination"
        @input="next"
      ></v-pagination>
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
        text: "Nombre",
        value: "name",
        align: "center",
        sortable: false,
      },
      {
        text: "Apellido",
        value: "lastname",
        align: "center",
        sortable: false,
      },
      {
        text: "Email",
        value: "email",
        align: "center",
        sortable: false,
      },
      {
        text: "Dirección",
        value: "address",
        align: "center",
        sortable: false,
      },
      {
        text: "DNI",
        value: "dni",
        align: "center",
        sortable: false,
      },
      {
        text: "Celular",
        value: "phone",
        align: "center",
        sortable: false,
      },
      {
        text: "Género",
        value: "gender",
        align: "center",
        sortable: false,
      },
      {
        text: "Cuidad",
        value: "city",
        align: "center",
        sortable: false,
      },
      { text: "Acciones", value: "actions", sortable: false, align: "center" },
    ],
    users: [],
    idDelete: null,
    page: 1,
    pageCount: 0,
    itemsPerPage: 15,
    pagination: null,
    baseURL: "",
  }),
  computed: {},
  mounted() {
    this.getList();
  },
  methods: {
    getList() {
      axios
        .get("/api/v1/users")
        .then((response) => {
          console.log(response);
          this.loading = false;
          this.users = response.data.data;
          this.pagination = response.data.meta.last_page;
        })
        .catch((error) => {});
    },
    deleteItem(item) {
      this.idDelete = item.id;
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      axios
        .delete(`/api/v1/users/${this.idDelete}`)
        .then((response) => {
          console.log(response);
          this.getList();
          this.closeDelete();
        })
        .catch((error) => {});
    },

    close() {
      this.dialog = false;
    },

    closeDelete() {
      this.dialogDelete = false;
    },
    newProduct() {
      this.$router.push({
        name: "addUser",
      });
    },
    editItem(item) {
      this.$router.push({
        name: "editUser",
        params: {
          id: item.id,
        },
      });
    },
    next(page) {
      axios
        .get(`/api/v1/users?page=${page}`)
        .then((response) => {
          this.users = response.data.data;
          this.pagination = response.data.meta.last_page;
          console.log(response);
        })
        .catch((error) => {});
    },
  },
};
</script>
