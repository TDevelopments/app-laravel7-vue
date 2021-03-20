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
          <v-toolbar-title>Categories</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>

          <v-btn
            color="#1B1B1B"
            dark
            @click="newCategory"
          >
            New Category
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
      <template v-slot:item.actions="{ item }">
        <v-icon color="#D6B331" small class="mr-2" @click="editItem(item)"> mdi-pencil </v-icon>
        <v-icon color="black" small @click="deleteItem(item)"> mdi-delete </v-icon>
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
        text: "Category Name",
        value: "name",
        align: "center",
        sortable: false,
      },
      { text: "Actions", value: "actions", sortable: false, align: "center" },
    ],
    categories: [],
    editedIndex: -1,
    categoryItem: {
      id: "",
      name: "",
    },
    catagoryDefault: {
      id: "",
      name: "",
    },
  }),
  mounted() {
    this.getList();
  },
  methods: {
    getList() {
      axios
        .get("/api/v1/categories", {
          headers: { Authorization: "Bearer " + this.$store.getters.getToken },
        })
        .then((response) => {
          console.log(response);
          this.loading = false;
          this.categories = response.data.data;
        })
        .catch((error) => {
        });
    },

    editItem(item) {
      console.log(item.id);
      this.$router.push({
        name: "editCategory",
        params: {
          id: item.id,
        },
      });
    },

    deleteItem(item) {
      this.editedIndex = this.categories.indexOf(item);
      this.categoryItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      console.log(this.categoryItem.id);
      axios
        .delete(`api/v1/categories/${this.categoryItem.id}`, {
          headers: { Authorization: "Bearer " + this.$store.getters.getToken },
        })
        .then((response) => {
          console.log(response);
          this.categories.splice(this.editedIndex, 1);
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
        this.categoryItem = Object.assign({}, this.catagoryDefault);
        this.editedIndex = -1;
      });
    },

    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.categoryItem = Object.assign({}, this.catagoryDefault);
        this.editedIndex = -1;
      });
    },
    newCategory() {
      this.$router.push({
        name: "addCategory"
      });
    },
  },
};
</script>