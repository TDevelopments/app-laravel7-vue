<template>
  <div v-if="spinnerLoading">
    <Spinner />
  </div>
  <div v-else class="px-2">
    <!-- <v-card elevation="1">
      <v-breadcrumbs :items="items" class="py-2 pl-3">
        <template v-slot:item="{ item }">
          <v-breadcrumbs-item :href="item.href" :disabled="item.disabled">
            {{ item.text }}
          </v-breadcrumbs-item>
        </template>
      </v-breadcrumbs>
    </v-card> -->
    <div class="pt-5">
      <div class="mb-7">
        <h1 class="font-weight-thin">Dashboard</h1>
        <h5>Bienvenido, nos encanta verte de nuevo.</h5>
      </div>
      <v-row>
        <v-col sm="12" md="6" lg="3">
          <v-card :loading="loading">
            <v-row>
              <v-col>
                <v-avatar color="primary" size="120" tile>
                  <v-icon size="75" color="white">mdi-bookshelf</v-icon>
                </v-avatar>
              </v-col>
              <v-col class="text-right my-auto">
                <div class="pr-5">
                  <h1>{{ xCatalogues }}</h1>
                  <h5>Catálogos</h5>
                </div>
              </v-col>
            </v-row>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn elevation="0" small color="primary" @click="toCatalogue">
                Ver Más
                <v-icon class="ml-2" small>mdi-send</v-icon>
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
        <v-col sm="12" md="6" lg="3">
          <v-card :loading="loading">
            <v-row>
              <v-col>
                <v-avatar color="#28B779" size="120" tile>
                  <v-icon size="75" color="white">mdi-archive</v-icon>
                </v-avatar>
              </v-col>
              <v-col class="text-right my-auto">
                <div class="pr-5">
                  <h1>{{ xProducts }}</h1>
                  <h5>Productos</h5>
                </div>
              </v-col>
            </v-row>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn elevation="0" small color="#28B779" dark @click="toProduct">
                Ver Más
                <v-icon class="ml-2" small>mdi-send</v-icon>
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
        <v-col sm="12" md="6" lg="3">
          <v-card :loading="loading">
            <v-row>
              <v-col>
                <v-avatar color="#832B98" size="120" tile>
                  <v-icon size="75" color="white">mdi-view-list</v-icon>
                </v-avatar>
              </v-col>
              <v-col class="text-right my-auto">
                <div class="pr-5">
                  <h1>{{ xCategories }}</h1>
                  <h5>Categorias</h5>
                </div>
              </v-col>
            </v-row>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn elevation="0" small color="#832B98" dark @click="toCategorie">
                Ver Más
                <v-icon class="ml-2" small>mdi-send</v-icon>
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
        <v-col sm="12" md="6" lg="3">
          <v-card :loading="loading">
            <v-row>
              <v-col>
                <v-avatar color="#FFB849" size="120" tile>
                  <v-icon size="75" color="white">mdi-account-circle</v-icon>
                </v-avatar>
              </v-col>
              <v-col class="text-right my-auto">
                <div class="pr-5">
                  <h1>{{ xUsers }}</h1>
                  <h5>Usuarios</h5>
                </div>
              </v-col>
            </v-row>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn elevation="0" small color="#FFB849" dark @click="toUser">
                Ver Más
                <v-icon class="ml-2" small>mdi-send</v-icon>
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </div>
  </div>
</template>
<script>
import Spinner from '../component/SpinnerLoading';
export default {
  components: {
    Spinner,
  },
  data: () => ({
    show: false,
    xCatalogues: 0,
    xProducts: 0,
    xCategories: 0,
    xUsers: 0,
    loading: true,
    spinnerLoading: true,
    items: [
      {
        text: 'Dashboard',
        disabled: false,
        href: 'breadcrumbs_dashboard',
      },
      {
        text: 'Link 1',
        disabled: false,
        href: 'breadcrumbs_link_1',
      },
      {
        text: 'Link 2',
        disabled: true,
        href: 'breadcrumbs_link_2',
      },
    ],
  }),
  mounted() {
    this.getCatalogues();
  },
  methods: {
    getCatalogues() {
      axios
        .get('/api/v1/catalogues')
        .then(response => {
          console.log(response);
          this.xCatalogues = response.data.meta.total;
          this.getProducts();
        })
        .catch(error => {
          //console.log(error)
          // reject(error);
        });
    },
    getProducts() {
      axios
        .get('/api/v1/product-ranges')
        .then(response => {
          console.log(response);
          this.xProducts = this.xProducts + response.data.meta.total;
          this.getCategories();
        })
        .catch(error => {
          //console.log(error)
          // reject(error);
        });
    },
    getProductsRange() {
      axios
        .get('/api/v1/products')
        .then(response => {
          console.log(response);
          this.xProducts = response.data.meta.total;
          this.getCategories();
        })
        .catch(error => {
          //console.log(error)
          // reject(error);
        });
    },
    getCategories() {
      axios
        .get('/api/v1/categories')
        .then(response => {
          console.log(response);
          this.xCategories = response.data.meta.total;
          this.getUsers();
        })
        .catch(error => {
          //console.log(error)
          // reject(error);
        });
    },
    getUsers() {
      axios
        .get('/api/v1/users')
        .then(response => {
          console.log(response);
          this.xUsers = response.data.meta.total;
          this.loading = false;
          this.spinnerLoading = false;
        })
        .catch(error => {
          //console.log(error)
          // reject(error);
        });
    },
    toCatalogue() {
      this.$router.push({ name: 'listCatalogue' });
    },
    toCategorie() {
      this.$router.push({ name: 'listCategory' });
    },
    toUser() {
      this.$router.push({ name: 'listUser' });
    },
    toProduct() {
      this.$router.push({ name: 'listProduct' });
    },
  },
};
</script>
