<template>
  <div class="my-3 mx-5">
    <v-row>
      <h3>Editar Delivery</h3>
    </v-row>
    <v-row class="border mb-3">
      <v-col cols="12" sm="4" md="4">
        Nombre Producto
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
      <v-col cols="12" sm="4" md="4">
        Nombre Cliente
        <v-select
          hide-details
          flat
          class="border"
          solo
          dense
          v-model="sale_customer_id"
          :items="customers"
          item-text="FullName"
          item-value="id"
          no-data-text="No hay se encontraron datos"
        ></v-select>
      </v-col>
      <v-col cols="12" sm="4" md="4">
        Cantidad
        <v-text-field
          v-model="delivery.Quantity"
          solo
          required
          placeholder="Example"
          v-on:keyup.enter="addUnit"
          class="border"
          flat
          dense
          hide-details
        ></v-text-field>
      </v-col>
    </v-row>
    <v-btn color="success" class="mr-4 mt-3" @click="updateDelevery">
      Guardar
    </v-btn>
  </div>
</template>

<script>
export default {
  data: () => ({
    valid: true,
    name: '',
    descripcion: '',
    products: [],
    customers: [],
    sale_product_id: '',
    sale_customer_id: '',
    Quantity: '',
    delivery: {},
  }),
  methods: {
    validate() {
      console.log(this.arrivalsDates);
    },
    getDelivery() {
      axios
        .get(`/api/v1/sale-deliveries/${this.$route.params.id}`)
        .then(response => {
          this.delivery = response.data.data;
          this.sale_product_id = response.data.data.Product.id;
          this.sale_customer_id = response.data.data.Customer.id;
        })
        .catch(error => {
          console.log(error);
        });
    },
    getProducts() {
      axios
        .get('/api/v1/sale-products?list=true')
        .then(response => {
          this.products = response.data.data;
        })
        .catch(error => {
          console.log(error);
        });
    },
    getCustomers() {
      axios
        .get('/api/v1/sale-customers?list=true')
        .then(response => {
          this.customers = response.data.data;
        })
        .catch(error => {
          console.log(error);
        });
    },
    updateDelevery() {
      axios
        .put('/api/v1/sale-deliveries', {
          ...this.delivery,
          sale_product_id: this.sale_product_id,
          sale_customer_id: this.sale_customer_id,
        })
        .then(response => {
          this.$router.replace({ name: 'listStockDelivery' });
        })
        .catch(error => {
          console.log(error);
        });
    },
  },
  mounted() {
    this.getProducts();
    this.getCustomers();
    this.getDelivery();
  },
};
</script>
<style scoped>
.border {
  border: 1px solid #d2d6de;
  background-color: white;
}
</style>
