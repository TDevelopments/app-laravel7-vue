<template>
  <v-card>
    <v-tabs fixed-tabs background-color="#546E7A" v-model="currentTab" dark>
      <v-tab> Product Normal </v-tab>
      <v-tab> Product for Range </v-tab>
    </v-tabs>
    <v-tabs-items v-model="currentTab">
      <v-tab-item>
        <v-card flat>
          <v-data-table
            :headers="headers"
            :items="products"
            :loading="loading"
            loading-text="Loading... Please wait"
          >
            <template v-slot:top>
              <v-toolbar flat>
                <v-toolbar-title>Products Normal</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
                <v-spacer></v-spacer>

                <v-btn color="#1B1B1B" dark @click="newProduct">
                  New Product
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
                      <v-btn
                        color="blue darken-1"
                        text
                        @click="deleteItemConfirm"
                        >OK</v-btn
                      >
                      <v-spacer></v-spacer>
                    </v-card-actions>
                  </v-card>
                </v-dialog>
              </v-toolbar>
            </template>
            <template v-slot:item.images="{ item }">
              <v-img
                max-height="50"
                max-width="100"
                :src="item.images[0].path"
                class="mt-1 mb-1 mx-auto"
              ></v-img>
            </template>
            <template v-slot:item.actions="{ item }">
              <v-icon
                small
                class="mr-2"
                @click="editItem(item)"
                color="#D6B331"
              >
                mdi-pencil
              </v-icon>
              <v-icon small @click="deleteItem(item)" color="#FF0000">
                mdi-delete
              </v-icon>
            </template>
          </v-data-table>
        </v-card>
      </v-tab-item>
      <v-tab-item>
        <v-card flat>
          <v-card flat>
            <v-data-table
              :headers="headersProductForRange"
              :items="productForRange"
              :loading="loading"
              loading-text="Loading... Please wait"
              :single-expand="singleExpand"
              :expanded.sync="expanded"
              show-expand
              class="elevation-1"
            >
              <template v-slot:top>
                <v-toolbar flat>
                  <v-toolbar-title>Products for Range</v-toolbar-title>
                  <v-divider class="mx-4" inset vertical></v-divider>
                  <v-spacer></v-spacer>

                  <v-btn color="#1B1B1B" dark @click="newProduct">
                    New Product Range
                  </v-btn>

                  <v-dialog v-model="dialogDelete" max-width="500px">
                    <v-card>
                      <v-card-title class="headline"
                        >Are you sure you want to delete this
                        item?</v-card-title
                      >
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" text @click="closeDelete"
                          >Cancel</v-btn
                        >
                        <v-btn
                          color="blue darken-1"
                          text
                          @click="deleteItemConfirm"
                          >OK</v-btn
                        >
                        <v-spacer></v-spacer>
                      </v-card-actions>
                    </v-card>
                  </v-dialog>
                </v-toolbar>
              </template>
              <template v-slot:expanded-item="{ headers, item }">
                <p v-for="(rg, i) in item.ranges" :key="i">
                  {{ rg.min }} -> {{ rg.max }} -> {{ rg.price }}
                </p>
              </template>
              <template v-slot:item.image="{ item }">
                <v-img
                  lazy-src="https://picsum.photos/id/11/10/6"
                  max-height="50"
                  max-width="100"
                  src="https://picsum.photos/id/11/500/300"
                  class="mt-1 mb-1 ml-8"
                ></v-img>
              </template>
              <template v-slot:item.actions="{ item }">
                <v-icon
                  small
                  class="mr-2"
                  @click="editItem(item)"
                  color="#D6B331"
                >
                  mdi-pencil
                </v-icon>
                <v-icon small @click="deleteItem(item)" color="black">
                  mdi-delete
                </v-icon>
              </template>
            </v-data-table>
          </v-card>
        </v-card>
      </v-tab-item>
    </v-tabs-items>
  </v-card>
</template>

<script>
export default {
  data: () => ({
    dialogDelete: false,
    loading: false,
    currentTab: 0,
    products: [],
    headersProductForRange: [
      { text: "Image", value: "image", align: "center", sortable: false },
      {
        text: "Product Model",
        value: "model",
        align: "center",
        sortable: false,
      },
      {
        text: "Stock",
        value: "stock",
        align: "center",
        sortable: false,
      },
      {
        text: "Brand",
        value: "brand",
        align: "center",
        sortable: false,
      },
      {
        text: "Category",
        value: "category.name",
        align: "center",
        sortable: false,
      },
      {
        text: "Catalogue",
        value: "catalogue.name",
        align: "center",
        sortable: false,
      },
      { text: "Actions", value: "actions", sortable: false, align: "center" },
      { text: "", value: "data-table-expand", sortable: false },
    ],
    editedIndex: -1,
    productItem: {
      id: "",
      model: "",
      slug: "",
      stock: "",
      brand: "",
      price_unit: "",
      price_group: "",
      quantity_group: "",
      type_group: "",
      category: "",
      catalogue: "",
    },
    productDefault: {
      id: "",
      model: "",
      slug: "",
      stock: "",
      brand: "",
      price_unit: "",
      price_group: "",
      quantity_group: "",
      type_group: "",
      category: "",
      catalogue: "",
    },
    productForRange: [],
    headers: [
      { text: "Image", value: "images", align: "center", sortable: false },
      {
        text: "Product Model",
        value: "model",
        align: "center",
        sortable: false,
      },
      {
        text: "Stock",
        value: "stock",
        align: "center",
        sortable: false,
      },
      {
        text: "Brand",
        value: "brand",
        align: "center",
        sortable: false,
      },
      {
        text: "Price Unit",
        value: "price_unit",
        align: "center",
        sortable: false,
      },
      {
        text: "Price Group",
        value: "price_group",
        align: "center",
        sortable: false,
      },
      {
        text: "Quantity Group",
        value: "quantity_group",
        align: "center",
        sortable: false,
      },
      {
        text: "Type Group",
        value: "type_group",
        align: "center",
        sortable: false,
      },
      {
        text: "Category",
        value: "category.name",
        align: "center",
        sortable: false,
      },
      {
        text: "Catalogue",
        value: "catalogue.name",
        align: "center",
        sortable: false,
      },
      { text: "Actions", value: "actions", sortable: false, align: "center" },
    ],
    editedRangeIndex: -1,
    productForRangeItem: {
      id: "",
      model: "",
      slug: "",
      stock: "",
      brand: "",
      price_unit: "",
      price_group: "",
      quantity_group: "",
      type_group: "",
      category: "",
      catalogue: "",
    },
    productForRangeDefault: {
      id: "",
      model: "",
      slug: "",
      stock: "",
      brand: "",
      price_unit: "",
      price_group: "",
      quantity_group: "",
      type_group: "",
      category: "",
      catalogue: "",
    },
    expanded: [],
    singleExpand: false,
  }),
  computed: {},
  mounted() {
    this.getList();
    this.getListForRange();
  },
  methods: {
    getList() {
      axios
        .get("/api/v1/products", {
          headers: { Authorization: "Bearer " + this.$store.getters.getToken },
        })
        .then((response) => {
          console.log(response);
          this.loading = false;
          this.products = response.data.data;
        })
        .catch((error) => {
          //console.log(error)
          // reject(error);
        });
    },

    getListForRange() {
      axios
        .get("/api/v1/product-ranges", {
          headers: { Authorization: "Bearer " + this.$store.getters.getToken },
        })
        .then((response) => {
          console.log(response);
          this.loading = false;
          this.productForRange = response.data.data;
        })
        .catch((error) => {
          //console.log(error)
          // reject(error);
        });
    },

    deleteItem(item) {
      if (this.currentTab == 0) {
        this.editedIndex = this.products.indexOf(item);
        this.productItem = Object.assign({}, item);
        this.dialogDelete = true;
      } else {
        this.editedRangeIndex = this.productForRange.indexOf(item);
        this.productForRangeItem = Object.assign({}, item);
        this.dialogDelete = true;
      }
    },

    deleteItemConfirm() {
      if (this.currentTab == 0) {
        console.log(this.productItem.id);
        axios
          .delete(`api/v1/products/${this.productItem.id}`, {
            headers: {
              Authorization: "Bearer " + this.$store.getters.getToken,
            },
          })
          .then((response) => {
            console.log(response);
            this.products.splice(this.editedIndex, 1);
            this.closeDelete();
          })
          .catch((error) => {
            //console.log(error)
            // reject(error);
          });
      } else {
        console.log(this.productForRangeItem.id);
        axios
          .delete(`api/v1/product-ranges/${this.productForRangeItem.id}`, {
            headers: {
              Authorization: "Bearer " + this.$store.getters.getToken,
            },
          })
          .then((response) => {
            console.log(response);
            this.productForRange.splice(this.editedRangeIndex, 1);
            this.closeDelete();
          })
          .catch((error) => {
            //console.log(error)
            // reject(error);
          });
      }
    },

    close() {
      if (this.currentTab == 0) {
        this.dialog = false;
        this.$nextTick(() => {
          this.productItem = Object.assign({}, this.productDefault);
          this.editedIndex = -1;
        });
      } else {
        this.dialog = false;
        this.$nextTick(() => {
          this.productForRangeItem = Object.assign(
            {},
            this.productForRangeDefault
          );
          this.editedRangeIndex = -1;
        });
      }
    },

    closeDelete() {
      if (this.currentTab == 0) {
        this.dialogDelete = false;
        this.$nextTick(() => {
          this.productItem = Object.assign({}, this.productDefault);
          this.editedIndex = -1;
        });
      } else {
        this.dialogDelete = false;
        this.$nextTick(() => {
          this.productForRangeItem = Object.assign(
            {},
            this.productForRangeDefault
          );
          this.editedRangeIndex = -1;
        });
      }
    },
    editItem(item) {
      if (this.currentTab == 0) {
        console.log(item.id);
        this.$router.push({
          name: "editProduct",
          params: {
            id: item.id,
          },
        });
      } else {
        console.log(item.id);
        this.$router.push({
          name: "editProductRange",
          params: {
            id: item.id,
          },
        });
      }
    },
    newProduct() {
      if (this.currentTab == 0) {
        this.$router.push({
          name: "addProduct",
        });
      } else {
        this.$router.push({
          name: "addProductRange",
        });
      }
    },
  },
};
</script>