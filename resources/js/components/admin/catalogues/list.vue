<template>
  <v-card>
    <v-data-table
      :headers="headers"
      :items="catalogues"
      :loading="loading"
      item-key="item.id"
      loading-text="Loading... Please wait"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Catalogues</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>

          <v-btn
            color="#1B1B1B"
            dark
            @click="newCatalogue"
          >
            New Catalogue
          </v-btn>

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
        <v-icon small class="mr-2" @click="editItem(item)" color="#D6B331"> mdi-pencil </v-icon>
        <v-icon small @click="deleteItem(item)" color="#FF0000"> mdi-delete </v-icon>
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
      { text: "Image", value: "image", align: "center", sortable: false },
      {
        text: "Catalogue Name",
        value: "name",
        align: "center",
        sortable: false,
      },
      {
        text: "Quota Date",
        value: "quota_date",
        align: "center",
        sortable: false,
      },
      {
        text: "Quota Price",
        value: "quota_price",
        align: "center",
        sortable: false,
      },
      {
        text: "Minimum Investment",
        value: "minimum_investment",
        align: "center",
        sortable: false,
      },
      {
        text: "First Payment",
        value: "first_payment",
        align: "center",
        sortable: false,
      },
      {
        text: "Date First Payment",
        value: "date_first_payment",
        align: "center",
        sortable: false,
      },
      {
        text: "Second Payment",
        value: "second_payment",
        align: "center",
        sortable: false,
      },
      {
        text: "Date Second Payment",
        value: "date_second_payment",
        align: "center",
        sortable: false,
      },
      {
        text: "Arrivals Date",
        value: "arrivals",
        align: "center",
        sortable: false,
      },
      { text: "Actions", value: "actions", sortable: false, align: "center" },
    ],
    catalogues: [],
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
  }),
  mounted() {
    this.getList();
  },
  methods: {
    getList() {
      axios
        .get("/api/v1/catalogues", {
          headers: { Authorization: "Bearer " + this.$store.getters.getToken },
        })
        .then((response) => {
          console.log(response);
          this.loading = false;
          this.catalogues = response.data.data;
        })
        .catch((error) => {
          //console.log(error)
          // reject(error);
        });
    },

    editItem(item) {
      console.log(item.id);
      this.$router.push({
        name: "editCatalogue",
        params: {
          id: item.id,
        },
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
        .delete(`api/v1/catalogues/${this.catalogueItem.id}`, {
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
    newCatalogue() {
      this.$router.push({
        name: "addCatalogue"
      });
    },
  },
};
</script>