<template>
  <v-card>
    <v-data-table
      :headers="headers"
      :items="users"
      :loading="loading"
      item-key="item.id"
      loading-text="Loading... Please wait"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Users</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>

          <v-btn color="#1B1B1B" dark @click="newProduct"> New User </v-btn>

          <v-dialog v-model="dialogDelete" max-width="500px">
            <v-card>
              <v-card-title class="headline"
                >Are you sure you want to delete this item?</v-card-title
              >
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="closeDelete"
                  >Cancel</v-btn
                >
                <v-btn color="blue darken-1" text @click="deleteItemConfirm"
                  >OK</v-btn
                >
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>
      <template v-slot:item.image="{ item }">
        <v-img
          lazy-src="https://picsum.photos/id/11/10/6"
          max-height="50"
          max-width="100"
          src="https://picsum.photos/id/11/500/300"
          class="mt-1 mb-1"
        ></v-img>
      </template>
      <template v-slot:item.arrivals="{ item }">
        <p v-for="ar in item.arrivals">
          {{ ar.city }} -> {{ ar.arrival_date }}
        </p>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-icon small @click="deleteItem(item)" color="black"> mdi-delete </v-icon>
      </template>
    </v-data-table>
  </v-card>
</template>

<script>
export default {
  data: () => ({
    dialogDelete: false,
    pageCount: 5,
    page: 5,
    loading: false,
    headers: [
      { text: "Image", value: "image", align: "center", sortable: false },
      {
        text: "Name",
        value: "name",
        align: "center",
        sortable: false,
      },
      {
        text: "Lastname",
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
        text: "Address",
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
        text: "Phone",
        value: "phone",
        align: "center",
        sortable: false,
      },
      {
        text: "Gender",
        value: "gender",
        align: "center",
        sortable: false,
      },
      {
        text: "City",
        value: "city",
        align: "center",
        sortable: false,
      },
      { text: "Actions", value: "actions", sortable: false, align: "center" },
    ],
    users: [],
    editedIndex: -1,
    catalogueItem: {
      id: "",
      name: "",
      minimum_investment: "",
      quota_price: "",
      quota_date: "",
      first_payment: "",
      date_first_payment: "",
      second_payment: "",
      date_second_payment: "",
    },
    catalogueDefault: {
      id: "",
      name: "",
      minimum_investment: "",
      quota_price: "",
      quota_date: "",
      first_payment: "",
      date_first_payment: "",
      second_payment: "",
      date_second_payment: "",
    },
    totalCatalogues: 0,
  }),
  computed: {
  },
  mounted() {
    this.getList();
  },
  methods: {
    getList() {
      axios
        .get("/api/v1/users", {
          headers: { Authorization: "Bearer " + this.$store.getters.getToken },
        })
        .then((response) => {
          console.log(response);
          this.loading = false;
          this.users = response.data.data;
        })
        .catch((error) => {
          //console.log(error)
          // reject(error);
        });
    },
    deleteItem(item) {
      this.editedIndex = this.catalogues.indexOf(item);
      this.catalogueItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      console.log(this.catalogueItem.id);
      axios
        .delete(`api/catalogues/${this.catalogueItem.id}`, {
          headers: { Authorization: "Bearer " + this.$store.getters.getToken },
        })
        .then((response) => {
          console.log(response);
          this.catalogues.splice(this.editedIndex, 1);
          this.closeDelete();
        })
        .catch((error) => {
          //console.log(error)
          // reject(error);
        });
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.catalogueItem = Object.assign({}, this.catalogueDefault);
        this.editedIndex = -1;
      });
    },

    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.catalogueItem = Object.assign({}, this.catalogueDefault);
        this.editedIndex = -1;
      });
    },
    newProduct() {
      this.$router.push({
        name: "addUser",
      });
    },
  },
};
</script>