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
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col" class="sticky-col first-col">Nombre</th>
            <th scope="col" class="sticky-col second-col">DNI</th>
            <th scope="col" class="sticky-col third-col">Numero</th>
            <th v-for="(product, index) in products" :key="index">
              {{ product.model }}
            </th>
            <th scope="col" class="sticky-col end-col">Total</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(order, index) in orders" :key="index">
            <th class="sticky-col first-col">{{ order.user.name }}</th>
            <th class="sticky-col second-col">{{ order.user.dni ? order.user.dni : '' }}</th>
            <th class="sticky-col third-col">{{ order.user.phone ? order.user.phone : '' }}</th>
            <td v-for="(product, index) in products" :key="index">
              <div v-for="(op, index) in order.orderDetails" :key="index">
                <div v-if="op.product">
                  {{ op.product.model == product.model ? op.quantity : '' }}
                </div>
                <div v-if="op.product_range">
                  {{ op.product_range.model == product.model ? op.quantity : '' }}
                </div>
              </div>
            </td>
            <td class="sticky-col end-col">{{ order.total_order | currency }}</td>
          </tr>
          <tr>
            <th colspan="3" class="sticky-col first-col">Total</th>
            <td v-for="(ob, index) in object" :key="index">
              {{ ob }}
            </td>
            <td class="sticky-col end-col"></td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- <vue-excel-editor v-model="orders">
      <vue-excel-column field="user" label="User" />
      <vue-excel-column field="payment" label="Name" />
      <vue-excel-column field="total_order" label="Contact" />
    </vue-excel-editor> -->
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
      this.products = [];
      axios
        .get(`/api/v1/catalogues/${this.catSelect}`)
        .then(response => {
          console.log(response.data.data);
          if (response.data.data.products != null || response.data.data.products.length != 0) {
            response.data.data.products.forEach(element => {
              this.products.push(element);
            });
          }
          if (
            response.data.data.productRanges != null ||
            response.data.data.productRanges.length != 0
          ) {
            response.data.data.productRanges.forEach(element => {
              this.products.push(element);
            });
          }
          console.log(this.products);
          this.getOrders();
        })
        .catch(error => {});
    },
    getOrders() {
      axios
        .get(`/api/v1/orders?catalogueId=${this.catSelect}`)
        .then(response => {
          this.object = [];
          for (let index = 0; index < this.products.length; index++) {
            this.object.push(0);
          }
          this.orders = response.data.data;
          this.orders.forEach(order => {
            this.products.forEach((element, index) => {
              let toPro = 0;
              order.orderDetails.forEach(op => {
                if (op.product) {
                  if (op.product.model == element.model) {
                    toPro = toPro + op.quantity;
                  }
                }
                if (op.product_range) {
                  if (op.product_range.model == element.model) {
                    toPro = toPro + op.quantity;
                  }
                }
              });
              this.object[index] = this.object[index] + toPro;
            });
          });
          console.log('Hola', this.object);
          console.log(response.data.data);
        })
        .catch(error => {});
    },
    // createObject() {
    //   this.orders.forEach(order => {
    //     this.object.push({ name: order.user.name });
    //     this.products.forEach(product => {
    //       order.forEach(op => {});
    //     });
    //   });
    // },
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
  filters: {
    currency: function(value) {
      return parseFloat(value).toFixed(2);
    },
    date: function(value) {
      return moment(value).format('DD-MM-YYYY');
    },
    porcent: function(value) {
      return parseFloat(value) * 100 + ' %';
    },
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
  width: 150px;
  min-width: 150px;
  max-width: 150px;
  left: 0;
}

.second-col {
  width: 150px;
  min-width: 150px;
  max-width: 150px;
  left: 150px;
}
.third-col {
  width: 150px;
  min-width: 150px;
  max-width: 150px;
  left: 300px;
}
.end-col {
  width: 100px;
  min-width: 100px;
  max-width: 100px;
  right: 0;
}
</style>
