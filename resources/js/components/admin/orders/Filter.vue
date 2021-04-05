<template>
  <v-card>
    <v-select
      placeholder="Ingresa el nombre del catálogo"
      solo
      v-model="catSelect"
      :items="catalogues"
      item-text="name"
      item-value="id"
      dense
    />
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th scope="col" class="sticky-col first-col">Nombre</th>
            <th v-for="(product, index) in products" :key="index">
              {{ product.model }}
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(order, index) in orders" :key="index">
            <th class="sticky-col first-col">{{ order.user.name }}</th>
            <td v-for="(product, index) in products" :key="index">
              <div v-for="(op, index) in order.orderDetails" :key="index">
                {{ op.product.id == product.id ? op.quantity : '' }}
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </v-card>
</template>

<script>
import axios from 'axios';

export default {
  data: () => ({
    orders: [],
    idDelete: '',
    dialogDelete: false,
    page: 1,
    pageCount: 0,
    itemsPerPage: 15,
    pagination: null,
    catSelect: '',
    catalogues: [],
    products: [],
    object: [],
  }),
  watch: {
    catSelect: function() {
      this.getProducts();
    },
  },
  methods: {
    search() {
      console.log('Hola');
    },
    getCatalogues() {
      axios
        .get('/api/v1/list-catalogues')
        .then(response => {
          this.catalogues = response.data.data;
          console.log(response);
        })
        .catch(error => {});
    },
    getProducts() {
      axios
        .get(`/api/v1/catalogues/${this.catSelect}`)
        .then(response => {
          this.products = response.data.data.products;
          console.log(response.data.data.products);
          this.getOrders();
        })
        .catch(error => {});
    },
    getOrders() {
      axios
        .get(`/api/v1/orders?catalogueId=${this.catSelect}`)
        .then(response => {
          this.orders = response.data.data;
          console.log(response.data.data);
        })
        .catch(error => {});
    },
    createObject(){
      this.orders.forEach(order => {          
        this.object.push({name: order.user.name})
        this.products.forEach(product => {
          order.forEach(op => {
            
          });
        });
      });
    },
    editItem(item) {
      console.log(item.id);
      this.$router.push({
        name: 'editOrder',
        params: {
          id: item.id,
        },
      });
    },
    next(page) {
      axios
        .get(`/api/v1/orders?page=${page}`)
        .then(response => {
          console.log(response);
          this.orders = response.data.data;
          this.pagination = response.data.meta.last_page;
        })
        .catch(error => {});
    },
  },
  mounted() {
    this.getCatalogues();
  },
};
</script>
<style scoped>
.sticky-col {
  position: -webkit-sticky;
  position: sticky;
  background-color: white;
}

.first-col {
  width: 100px;
  min-width: 100px;
  max-width: 100px;
  left: 0px;
}

.second-col {
  width: 150px;
  min-width: 150px;
  max-width: 150px;
  left: 100px;
}
</style>
