<template>
  <div class="my-3 mx-5">
    <v-row>
      <h3>Editar Producto</h3>
    </v-row>
    <v-row class="border mb-3">
      <v-col cols="12" md="3" sm="6">
        Cantidad
        <v-text-field
          class="border"
          flat
          hide-details
          solo
          dense
          v-model="stock.Quantity"
        ></v-text-field>
      </v-col>
      <v-col cols="12" md="3" sm="6">
        Producto
        <v-select
          hide-details
          flat
          class="border"
          solo
          dense
          v-model="sale_product_id"
          :items="products"
          item-text="ProductName"
          item-value="id"
          no-data-text="No hay se encontraron datos"
        ></v-select>
      </v-col>
      <v-col cols="12" md="3" sm="6">
        Estado
        <v-select
          hide-details
          flat
          class="border"
          solo
          dense
          v-model="sale_product_status_id"
          :items="status"
          item-text="StatusName"
          item-value="id"
          no-data-text="No hay se encontraron datos"
        ></v-select>
      </v-col>
      <v-col cols="12" md="3" sm="6">
        Almacen
        <v-select
          hide-details
          flat
          class="border"
          solo
          dense
          v-model="sale_business_location_id"
          :items="locations"
          item-text="Name"
          item-value="id"
          no-data-text="No hay se encontraron datos"
        ></v-select>
      </v-col>
      <v-col cols="12" md="3" sm="6">
        Cliente
        <v-select
          hide-details
          flat
          class="border"
          solo
          dense
          v-model="sale_customer_id"
          :items="customers"
          item-text="FirstName"
          item-value="Id"
          no-data-text="No hay se encontraron datos"
        ></v-select>
      </v-col>
    </v-row>
    <v-row class="my-3">
      <v-spacer></v-spacer>
      <v-btn
        class="mx-1 my-4 border"
        elevation="0"
        color="#0D52D6"
        dark
        small
        @click="updateStockRecord"
      >
        Guardar
      </v-btn>
      <v-btn class="mx-1 my-4 border" elevation="0" small>Cancelar</v-btn>
    </v-row>
  </div>
</template>
<script>
export default {
  data: () => ({
    stock: [],
    products: [],
    customers: [],
    status: [],
    locations: [],
    sale_product_id: null,
    sale_product_status_id: null,
    sale_business_location_id: null,
    sale_customer_id: null,
  }),
  methods: {
    getStock() {
      axios
        .get(`/api/v1/sale-stock-records/${this.$route.params.id}`)
        .then(response => {
          this.stock = response.data.data;
          this.sale_product_id = response.data.data.Product.id;
          this.sale_customer_id = response.data.data.Customer.id;
          this.sale_product_status_id = response.data.data.ProductStatus.id;
          this.sale_business_location_id = response.data.data.BusinessLocation.id;
          console.log(response);
        })
        .catch(error => {});
    },
    getProducts() {
      axios
        .get('/api/v1/sale-products?list=true')
        .then(response => {
          this.products = response.data.data;
          console.log(response);
        })
        .catch(error => {});
    },
    getProductStatus() {
      axios
        .get('/api/v1/sale-product-status?list=true')
        .then(response => {
          this.status = response.data.data;
          console.log(response);
        })
        .catch(error => {});
    },
    getLocations() {
      axios
        .get('/api/v1/business-locations?list=true')
        .then(response => {
          this.locations = response.data.data;
          console.log(response);
        })
        .catch(error => {});
    },
    getCustomers() {
      axios
        .get('/api/v1/sale-customers?list=true')
        .then(response => {
          this.customers = response.data.data;
          console.log(response);
        })
        .catch(error => {});
    },
    updateStockRecord() {
      axios
        .post('/api/v1/sale-stock-records', {
          ...this.stock,
          sale_customer_id: this.sale_customer_id,
          sale_product_status_id: this.sale_product_status_id,
          sale_business_location_id: this.sale_business_location_id,
          sale_product_id: this.sale_product_id,
        })
        .then(response => {
          console.log(response);
          this.$router.replace({
            name: 'listStockStockRecord',
          });
        })
        .catch(error => {});
    },
  },
  mounted() {
    this.getProducts();
    this.getProductStatus();
    this.getLocations();
    this.getCustomers();
    this.getStock();
  },
};
</script>
<style scoped>
.border {
  border: 1px solid #d2d6de;
  background-color: white;
}
</style>
