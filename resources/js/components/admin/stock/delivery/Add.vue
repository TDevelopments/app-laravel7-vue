<template>
  <div class="my-3 mx-5">
    <v-row>
      <h3>Añadir Delivery</h3>
    </v-row>
    <v-row class="border mb-3">
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
        Cantidad
        <v-text-field
          v-model="Quantity"
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
    <v-btn color="success" class="mr-4 mt-3" @click="addDelivery">
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
    stockrecord: [],
  }),
  methods: {
    validate() {
      console.log(this.arrivalsDates);
    },
    getProducts() {
      axios
        .get('/api/v1/sale-products?list=true')
        .then(response => {})
        .catch(error => {
          console.log(error);
        });
    },
    getCustomers() {
      axios
        .get('/api/v1/sale-customers?list=true')
        .then(response => {
          this.customers = response.data.data;
          console.log(response.data);
        })
        .catch(error => {
          console.log(error);
        });
    },
    getStockRecord() {
      axios
        .get(`/api/v1/sale-stock-records?ByCustomer=${this.sale_customer_id}`)
        .then(response => {
          console.log(response);
          this.stockrecord = response.data.data;
          this.stockrecord.forEach(element => {
            this.products.push(element.Product);
          });
        })
        .catch(error => {
          console.log(error);
        });
    },
    addDelivery() {
      let data = {
        sale_product_id: this.sale_product_id,
        sale_customer_id: this.sale_customer_id,
        Quantity: this.Quantity,
      };
      axios
        .post('/api/v1/sale-deliveries', data)
        .then(response => {
          this.$router.replace({ name: 'listStockDelivery' });
        })
        .catch(error => {
          console.log(error);
        });
    },
  },
  watch: {
    sale_customer_id: function(newQuestion, oldQuestion) {
      this.getStockRecord();
    },
  },
  mounted() {
    this.getProducts();
    this.getCustomers();
  },
};
</script>
<style scoped>
.border {
  border: 1px solid #d2d6de;
  background-color: white;
}
</style>
