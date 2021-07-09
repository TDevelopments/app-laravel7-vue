<template>
  <div v-if="spinnerLoading">
    <Spinner />
  </div>
  <div v-else>
    <v-tabs fixed-tabs background-color="#546E7A" v-model="currentTab" dark>
      <v-tab @click="tab0" href="#tab-0"> Producto por conjunto </v-tab>
      <v-tab @click="tab1" href="#tab-1"> Producto por rango </v-tab>
    </v-tabs>
    <v-tabs-items v-model="currentTab">
      <v-tab-item value="tab-0">
        <br />
        <br />
        <div>
          <h3>Filtros</h3>
          <v-row>
            <v-col>
              Nombre, SKU
              <v-text-field
                class="border"
                flat
                hide-details
                solo
                dense
                v-model="searchName"
                ref="nomCli"
              ></v-text-field>
            </v-col>
            <v-col>
              Tipo de Unidad
              <v-select
                hide-details
                flat
                class="border"
                solo
                dense
                v-model="searchType"
                :items="types"
                item-text="name"
                item-value="name"
                no-data-text="No hay se encontraron datos"
              ></v-select>
            </v-col>
            <v-col>
              Catalogo
              <v-select
                hide-details
                flat
                class="border"
                solo
                dense
                v-model="searchCatalogue"
                :items="catalogues"
                item-text="name"
                item-value="id"
                no-data-text="No hay se encontraron datos"
              ></v-select>
            </v-col>
            <v-col>
              Categoria
              <v-select
                hide-details
                flat
                class="border"
                solo
                dense
                v-model="searchCategory"
                :items="categories"
                item-text="name"
                item-value="id"
                no-data-text="No hay se encontraron datos"
              ></v-select>
            </v-col>
            <v-col class="align-center justify-end px-0 pr-2 d-flex">
              <v-btn small @click="searchProduct" class="mx-1" color="#0D52D6" dark> Buscar </v-btn>
              <v-btn small @click="clearProduct" class="mx-1"> Limpiar </v-btn>
            </v-col>
          </v-row>
        </div>

        <v-card flat>
          <v-data-table
            :headers="headers"
            :items="products"
            :loading="loading"
            loading-text="Loading... Please wait"
            :page.sync="page0"
            :items-per-page="itemsPerPage"
            hide-default-footer
          >
            <template v-slot:top>
              <v-toolbar flat>
                <v-toolbar-title>Producto (Conjunto)</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
                <v-spacer></v-spacer>

                <v-btn color="#1B1B1B" dark @click="newProduct" small>
                  Nuevo producto
                </v-btn>

                <v-dialog v-model="dialogDelete" max-width="290">
                  <v-card>
                    <v-card-title class="headline">
                      Eliminar Producto
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

                      <v-btn color="green darken-1" text @click="deleteItemConfirm()">
                        Aceptar
                      </v-btn>
                    </v-card-actions>
                  </v-card>
                </v-dialog>
              </v-toolbar>
            </template>
            <template v-slot:[`item.images`]="{ item }">
              <v-img
                max-height="50"
                max-width="100"
                src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"
                v-if="item.images == null || item.images.length == 0"
                class="mt-1 mb-1 mx-auto"
                contain
              ></v-img>
              <v-img
                max-height="50"
                max-width="100"
                v-else
                :src="item.images[0].path"
                class="mt-1 mb-1 mx-auto"
                contain
              ></v-img>
            </template>
            <template v-slot:[`item.actions`]="{ item }">
              <v-icon small class="mr-2" @click="editItem(item)" color="#D6B331">
                mdi-pencil
              </v-icon>
              <v-icon small @click="deleteItem(item)" color="#FF0000">
                mdi-delete
              </v-icon>
            </template>
          </v-data-table>
        </v-card>
        <div class="text-center pt-2">
          <v-pagination v-model="page0" :length="pagination0" @input="next0"></v-pagination>
        </div>
      </v-tab-item>
      <v-tab-item value="tab-1">
        <br />
        <br />
        <div>
          <h3>Filtros</h3>
          <v-row>
            <v-col>
              Nombre, SKU
              <v-text-field
                class="border"
                flat
                hide-details
                solo
                dense
                v-model="searchName"
                ref="nomCli"
              ></v-text-field>
            </v-col>
            <v-col>
              Catalogo
              <v-select
                hide-details
                flat
                class="border"
                solo
                dense
                v-model="searchCatalogue"
                :items="catalogues"
                item-text="name"
                item-value="id"
                no-data-text="No hay se encontraron datos"
              ></v-select>
            </v-col>
            <v-col>
              Categoria
              <v-select
                hide-details
                flat
                class="border"
                solo
                dense
                v-model="searchCategory"
                :items="categories"
                item-text="name"
                item-value="id"
                no-data-text="No hay se encontraron datos"
              ></v-select>
            </v-col>
            <v-col class="align-center justify-end px-0 pr-2 d-flex">
              <v-btn small @click="searchRange" class="mx-1" color="#0D52D6" dark> Buscar </v-btn>
              <v-btn small @click="clearRange" class="mx-1"> Limpiar </v-btn>
            </v-col>
          </v-row>
        </div>
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
            :page.sync="page"
            :items-per-page="itemsPerPage"
            hide-default-footer
          >
            <template v-slot:top>
              <v-toolbar flat>
                <v-toolbar-title>Producto (Rango)</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
                <v-spacer></v-spacer>

                <v-btn color="#1B1B1B" dark @click="newProduct" small>
                  Nuevo Producto Rango
                </v-btn>

                <v-dialog v-model="dialogDelete" max-width="290">
                  <v-card>
                    <v-card-title class="headline">
                      Eliminar Producto
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

                      <v-btn color="green darken-1" text @click="deleteItemConfirm">
                        Aceptar
                      </v-btn>
                    </v-card-actions>
                  </v-card>
                </v-dialog>
              </v-toolbar>
            </template>
            <template v-slot:expanded-item="{ headers, item }">
              <td :colspan="headers.length" class="expand">
                <div v-for="(rg, i) in item.ranges" :key="i">
                  {{ rg.min }} -> {{ rg.max }} -> {{ rg.price }}
                </div>
              </td>
            </template>
            <template v-slot:[`item.images`]="{ item }">
              <v-img
                max-height="50"
                max-width="100"
                src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"
                v-if="item.images == null || item.images.length == 0"
                class="mt-1 mb-1 mx-auto"
                contain
              ></v-img>
              <v-img
                max-height="50"
                max-width="100"
                v-else
                :src="item.images[0].path"
                class="mt-1 mb-1 mx-auto"
                contain
              ></v-img>
            </template>
            <template v-slot:[`item.actions`]="{ item }">
              <v-icon small class="mr-2" @click="editItem(item)" color="#D6B331">
                mdi-pencil
              </v-icon>
              <v-icon small @click="deleteItem(item)" color="black">
                mdi-delete
              </v-icon>
            </template>
          </v-data-table>
        </v-card>

        <div class="text-center pt-2">
          <v-pagination v-model="page" :length="pagination" @input="next"></v-pagination>
        </div>
      </v-tab-item>
    </v-tabs-items>
    <ModalError v-model="dialogError" v-if="dialogError" :body="message" />
  </div>
</template>

<script>
import Spinner from '../component/SpinnerLoading';
import ModalError from '../component/ModalError';
import { headerNormal, headerRange } from './constants';

export default {
  components: {
    Spinner,
    ModalError,
  },
  data: () => ({
    dialogError: false,
    spinnerLoading: true,
    value: null,
    bol: ['true', 'false'],
    filterGeneral: '',
    filterMeta: '',
    dialogDelete: false,
    loading: false,
    currentTab: 'tab-1',
    products: [],
    headers: headerNormal,
    productForRange: [],
    headersProductForRange: headerRange,
    expanded: [],
    singleExpand: false,
    idDeleteProduct: null,
    idDeleteProductRange: null,
    page: 1,
    pageCount: 0,
    itemsPerPage: 15,
    pagination: null,
    page0: 1,
    pagination0: null,
    catalogues: [],
    categories: [],
    types: [],
    searchType: '',
    searchCatalogue: '',
    searchCategory: '',
    searchName: '',
    searchCatalogueRange: '',
    searchCategoryRange: '',
    searchNameRange: '',
  }),
  methods: {
    getList() {
      if (this.page0 == 1) {
        axios
          .get('/api/v1/products')
          .then(response => {
            this.loading = false;
            this.products = response.data.data;
            this.pagination0 = response.data.meta.last_page;
            this.getListForRange();
          })
          .catch(error => {});
      } else {
        axios
          .get(`/api/v1/products?page=${page}`)
          .then(response => {
            this.loading = false;
            this.products = response.data.data;
            this.pagination0 = response.data.meta.last_page;
            this.getListForRange();
          })
          .catch(error => {});
      }
    },

    getListFilterGeneral() {
      axios
        .get(`/api/v1/products?model=${this.filterGeneral}&sku=${this.filterGeneral}`)
        .then(response => {
          this.loading = false;
          this.products = response.data.data;
          this.pagination0 = 1;
        })
        .catch(error => {});
    },

    getListFilterMeta() {
      axios
        .get(`/api/v1/products?meta=${this.filterMeta}`)
        .then(response => {
          this.loading = false;
          this.products = response.data.data;
          this.pagination0 = response.data.meta.last_page;
        })
        .catch(error => {});
    },

    getListForRange() {
      if (this.page == 1) {
        axios
          .get('/api/v1/product-ranges')
          .then(response => {
            this.loading = false;
            this.productForRange = response.data.data;
            this.pagination = response.data.meta.last_page;
            this.spinnerLoading = false;
          })
          .catch(error => {});
      } else {
        axios
          .get(`/api/v1/product-ranges?page=${this.page}`)
          .then(response => {
            this.loading = false;
            this.productForRange = response.data.data;
            this.pagination = response.data.meta.last_page;
            this.spinnerLoading = false;
          })
          .catch(error => {});
      }
    },

    deleteItem(item) {
      let storage = localStorage.getItem('tab');
      if (storage == 'tab-1') {
        this.idDeleteProductRange = item.id;
        this.dialogDelete = true;
      } else {
        this.idDeleteProduct = item.id;
        this.dialogDelete = true;
      }
    },

    deleteItemConfirm() {
      let storage = localStorage.getItem('tab');
      if (storage == 'tab-1') {
        axios
          .delete(`/api/v1/product-ranges/${this.idDeleteProductRange}`)
          .then(response => {
            this.getListForRange();
            this.closeDelete();
          })
          .catch(error => {});
      } else {
        axios
          .delete(`/api/v1/products/${this.idDeleteProduct}`)
          .then(response => {
            this.getList();
            this.closeDelete();
          })
          .catch(error => {});
      }
    },

    closeDelete() {
      this.dialogDelete = false;
    },

    editItem(item) {
      let storage = localStorage.getItem('tab');
      if (storage == 'tab-1') {
        this.$router.push({
          name: 'editProductRange',
          params: {
            id: item.id,
          },
        });
      } else {
        this.$router.push({
          name: 'editProduct',
          params: {
            id: item.id,
          },
        });
      }
    },
    newProduct() {
      let storage = localStorage.getItem('tab');
      if (storage == 'tab-1') {
        this.$router.push({
          name: 'addProductRange',
        });
      } else {
        this.$router.push({
          name: 'addProduct',
        });
      }
    },
    tab0() {
      localStorage.setItem('tab', 'tab-0');
    },
    tab1() {
      localStorage.setItem('tab', 'tab-1');
    },
    next(page) {
      if (this.searchName == null) {
        this.searchName = '';
      }
      if (this.searchCategory == null) {
        this.searchCategory = '';
      }
      if (this.searchCatalogue == null) {
        this.searchCatalogue = '';
      }
      if (this.searchType == null) {
        this.searchType = '';
      }
      axios
        .get(
          `/api/v1/product-ranges?page=${page}&category_id=${this.searchCategory}&catalogue_id=${this.searchCatalogue}&model=${this.searchName}`
        )
        .then(response => {
          this.loading = false;
          this.productForRange = response.data.data;
          this.pagination = response.data.meta.last_page;
        })
        .catch(error => {});
    },
    next0(page) {
      if (this.searchName == null) {
        this.searchName = '';
      }
      if (this.searchCategory == null) {
        this.searchCategory = '';
      }
      if (this.searchCatalogue == null) {
        this.searchCatalogue = '';
      }
      if (this.searchType == null) {
        this.searchType = '';
      }
      axios
        .get(
          `/api/v1/products?page=${page}&category_id=${this.searchCategory}&catalogue_id=${this.searchCatalogue}&measure=${this.searchType}&model=${this.searchName}`
        )
        .then(response => {
          this.loading = false;
          this.products = response.data.data;
          this.pagination0 = response.data.meta.last_page;
        })
        .catch(error => {});
    },

    getCatalogues() {
      axios
        .get(`/api/v1/list-catalogues`)
        .then(response => {
          this.catalogues = response.data.data;
        })
        .catch(error => {});
    },
    getCategories() {
      axios
        .get(`/api/v1/list-categories`)
        .then(response => {
          this.categories = response.data.data;
        })
        .catch(error => {});
    },
    getTypes() {
      axios
        .get(`/api/v1/measures`)
        .then(response => {
          this.types = response.data;
        })
        .catch(error => {});
    },
    searchProduct() {
      if (this.page0 != 1) {
        this.page0 = 1;
      }
      if (this.searchName == null) {
        this.searchName = '';
      }
      if (this.searchCategory == null) {
        this.searchCategory = '';
      }
      if (this.searchCatalogue == null) {
        this.searchCatalogue = '';
      }
      if (this.searchType == null) {
        this.searchType = '';
      }

      axios
        .get(
          `/api/v1/products?model=${this.searchName}&sku=${this.searchName}&category_id=${this.searchCategory}&catalogue_id=${this.searchCatalogue}&measure=${this.searchType}&page=${this.page0}`
        )
        .then(response => {
          this.products = response.data.data;
          this.pagination0 = response.data.meta.last_page;
        })
        .catch(error => {});
    },
    clearProduct() {
      this.getList();
      this.searchName = '';
      this.searchCategory = '';
      this.searchCatalogue = '';
      this.searchType = '';
    },
    searchRange() {
      if (this.page != 1) {
        this.page = 1;
      }
      if (this.searchName == null) {
        this.searchName = '';
      }
      if (this.searchCategory == null) {
        this.searchCategory = '';
      }
      if (this.searchCatalogue == null) {
        this.searchCatalogue = '';
      }
      if (this.searchType == null) {
        this.searchType = '';
      }

      axios
        .get(
          `/api/v1/product-ranges?model=${this.searchName}&sku=${this.searchName}&category_id=${this.searchCategory}&catalogue_id=${this.searchCatalogue}&page=${this.page0}`
        )
        .then(response => {
          this.productForRange = response.data.data;
          this.pagination = response.data.meta.last_page;
        })
        .catch(error => {});
    },
    clearRange() {
      this.getListForRange();
      this.searchName = '';
      this.searchCategory = '';
      this.searchCatalogue = '';
    },
  },
  mounted() {
    this.getList();
    this.getCatalogues();
    this.getCategories();
    this.getTypes();
    this.currentTab = localStorage.getItem('tab');
  },
};
</script>
<style scoped>
.expand {
  background-color: white;
}
.border {
  border: 1px solid #d2d6de;
  background-color: white;
}
</style>
