<template>
  <v-card>
    <v-tabs fixed-tabs background-color="#546E7A" v-model="currentTab" dark>
      <v-tab> Producto por conjunto </v-tab>
      <v-tab> Producto por rango </v-tab>
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
                <v-toolbar-title>Producto (Conjunto)</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
                <v-spacer></v-spacer>

                <v-btn color="#1B1B1B" dark @click="newProduct">
                  Nuevo producto
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
            <template v-slot:[`item.images`]="{ item }">
              <v-img
                max-height="50"
                max-width="100"
                :src="
                  item.images.length != 0
                    ? item.images[0].path
                    : 'https://cdn.vuetifyjs.com/images/parallax/material.jpg'
                "
                v-if="item.images"
                class="mt-1 mb-1 mx-auto"
                contain
              ></v-img>
            </template>
            <template v-slot:[`item.actions`]="{ item }">
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
                  <v-toolbar-title>Producto (Rango)</v-toolbar-title>
                  <v-divider class="mx-4" inset vertical></v-divider>
                  <v-spacer></v-spacer>

                  <v-btn color="#1B1B1B" dark @click="newProduct">
                    Nuevo Producto Rango
                  </v-btn>

                  <v-dialog v-model="dialogDelete" max-width="290">
                    <v-card>
                      <v-card-title class="headline">
                        Eliminar Catálogo
                      </v-card-title>

                      <v-card-text>
                        ¿Estas seguro de eliminar este
                        <strong>producto</strong>?
                      </v-card-text>

                      <v-card-actions>
                        <v-spacer></v-spacer>

                        <v-btn color="green darken-1" text @click="closeDelete">
                          Cancelar
                        </v-btn>

                        <v-btn
                          color="green darken-1"
                          text
                          @click="deleteItemConfirm"
                        >
                          Aceptar
                        </v-btn>
                      </v-card-actions>
                    </v-card>
                  </v-dialog>
                </v-toolbar>
              </template>
              <template v-slot:expanded-item="{ item }">
                <v-card>
                  <p v-for="(rg, i) in item.ranges" :key="i">
                    {{ rg.min }} -> {{ rg.max }} -> {{ rg.price }}
                  </p>
                </v-card>
              </template>
              <template v-slot:[`item.images`]="{ item }">
                <v-img
                  max-height="50"
                  max-width="100"
                  :src="
                    item.images.length != 0
                      ? item.images[0].path
                      : 'https://cdn.vuetifyjs.com/images/parallax/material.jpg'
                  "
                  v-if="item.images"
                  class="mt-1 mb-1 mx-auto"
                ></v-img>
              </template>
              <template v-slot:[`item.actions`]="{ item }">
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
    headers: [
      { text: "Imagen", value: "images", align: "center", sortable: false },
      {
        text: "Modelo",
        value: "model",
        align: "center",
        sortable: false,
      },
      {
        text: "Stock Meta",
        value: "stock",
        align: "center",
        sortable: false,
      },
      {
        text: "Marca",
        value: "brand",
        align: "center",
        sortable: false,
      },
      {
        text: "Precio unitario",
        value: "price_unit",
        align: "center",
        sortable: false,
      },
      {
        text: "Cantidad por Producto",
        value: "quantity_group",
        align: "center",
        sortable: false,
      },
      {
        text: "Precio por Grupo (P)",
        value: "price_group",
        align: "center",
        sortable: false,
      },
      {
        text: "Typo de Grupo",
        value: "type_group",
        align: "center",
        sortable: false,
      },
      {
        text: "Categoria",
        value: "category.name",
        align: "center",
        sortable: false,
      },
      {
        text: "Catálogo",
        value: "catalogue.name",
        align: "center",
        sortable: false,
      },
      { text: "Acciones", value: "actions", sortable: false, align: "center" },
    ],
    productForRange: [],
    headersProductForRange: [
      { text: "Imagen", value: "images", align: "center", sortable: false },
      {
        text: "Modelo",
        value: "model",
        align: "center",
        sortable: false,
      },
      {
        text: "Stock Meta",
        value: "stock",
        align: "center",
        sortable: false,
      },
      {
        text: "Marca",
        value: "brand",
        align: "center",
        sortable: false,
      },
      {
        text: "Categoria",
        value: "category.name",
        align: "center",
        sortable: false,
      },
      {
        text: "Catalogo",
        value: "catalogue.name",
        align: "center",
        sortable: false,
      },
      { text: "Acciones", value: "actions", sortable: false, align: "center" },
      { text: "", value: "data-table-expand", sortable: false },
    ],

    expanded: [],
    singleExpand: false,
    idDeleteProduct: null,
    idDeleteProductRange: null,
  }),
  methods: {
    getList() {
      axios
        .get("/api/v1/products")
        .then((response) => {
          this.loading = false;
          this.products = response.data.data;
        })
        .catch((error) => {});
    },

    getListForRange() {
      axios
        .get("/api/v1/product-ranges")
        .then((response) => {
          this.loading = false;
          this.productForRange = response.data.data;
        })
        .catch((error) => {});
    },

    deleteItem(item) {
      if (this.currentTab == 0) {
        this.idDeleteProduct = item.id;
        this.dialogDelete = true;
      } else {
        this.idDeleteProductRange = item.id;
        this.dialogDelete = true;
      }
    },

    deleteItemConfirm() {
      if (this.currentTab == 0) {
        axios
          .delete(`/api/v1/products/${this.idDeleteProduct}`)
          .then((response) => {
            this.getList();
            this.closeDelete();
          })
          .catch((error) => {});
      } else {
        axios
          .delete(`/api/v1/product-ranges/${this.idDeleteProductRange}`)
          .then((response) => {
            this.getListForRange();
            this.closeDelete();
          })
          .catch((error) => {});
      }
    },

    closeDelete() {
      this.dialogDelete = false;
    },

    editItem(item) {
      if (this.currentTab == 0) {
        this.$router.push({
          name: "editProduct",
          params: {
            id: item.id,
          },
        });
      } else {
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
  computed: {},
  mounted() {
    this.getList();
    this.getListForRange();
  },
};
</script>
<style lang="sass" scoped></style>
