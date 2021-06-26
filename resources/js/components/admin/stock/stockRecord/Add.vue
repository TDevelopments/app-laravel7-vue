<template>
  <div class="my-3 mx-5">
    <v-row>
      <h3>Añadir Stock</h3>
    </v-row>
    <v-row class="border mb-3">
      <v-col cols="12" md="3" sm="6">
        Cantidad (*)
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
        Producto (*)
        <v-select
          hide-details
          flat
          class="border"
          solo
          dense
          v-model="stock.sale_product_id"
          :items="products"
          item-text="ProductName"
          item-value="id"
          no-data-text="No hay se encontraron datos"
        ></v-select>
      </v-col>
      <v-col cols="12" md="3" sm="6">
        Estado (*)
        <v-select
          hide-details
          flat
          class="border"
          solo
          dense
          v-model="stock.sale_product_status_id"
          :items="status"
          item-text="StatusName"
          item-value="id"
          no-data-text="No hay se encontraron datos"
        ></v-select>
      </v-col>
      <v-col cols="12" md="3" sm="6">
        Almacen (*)
        <v-select
          hide-details
          flat
          class="border"
          solo
          dense
          v-model="stock.sale_business_location_id"
          :items="locations"
          item-text="Name"
          item-value="id"
          no-data-text="No hay se encontraron datos"
        ></v-select>
      </v-col>
      <v-col cols="12" md="3" sm="6" v-if="stateStock">
        Cliente (*)
        <v-select
          hide-details
          flat
          class="border"
          solo
          dense
          v-model="stock.sale_customer_id"
          :items="customers"
          item-text="FullName"
          item-value="id"
          no-data-text="No hay se encontraron datos"
        ></v-select>
      </v-col>
    </v-row>
    <v-row class="border mb-3">
      <v-col cols="12" md="3" sm="6">
        Color
        <v-select
          v-model="stock.Color"
          :items="colorsSelect"
          label="Select"
          item-text="name"
          item-value="code"
          solo
          flat
          dense
          class="border"
          hide-details
        ></v-select>
      </v-col>
      <v-col cols="12" md="3" sm="6">
        Talla
        <v-text-field
          class="border"
          flat
          hide-details
          solo
          dense
          v-model="stock.Size"
        ></v-text-field>
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
        @click="addStockRecord"
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
    products: [],
    customers: [],
    stock: {},
    status: [],
    locations: [],
    Quantity: null,
    sale_product_id: null,
    sale_product_status_id: null,
    sale_business_location_id: null,
    sale_customer_id: null,
    stateStock: false,
    Color: '',
    Size: '',
    colorsSelect: [],
  }),
  methods: {
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
    getColors() {
      axios
        .get('/api/v1/colors')
        .then(response => {
          console.log(response.data);
          this.colorsSelect = response.data.data;
        })
        .catch(error => {
          //console.log(error)
          // reject(error);
        });
    },
    addStockRecord() {
      let data = {
        Quantity: this.Quantity,
        sale_product_id: this.sale_product_id,
        sale_product_status_id: this.sale_product_status_id,
        sale_business_location_id: this.sale_business_location_id,
        sale_customer_id: this.sale_customer_id,
      };
      if (this.stock.sale_customer_id == null || this.stock.sale_customer_id == '') {
        delete this.stock.sale_customer_id;
      }
      console.log(data);
      axios
        .post('/api/v1/sale-stock-records', this.stock)
        .then(response => {
          console.log(response);
          this.$router.replace({
            name: 'listStockStockRecord',
          });
        })
        .catch(error => {});
    },
  },
  watch: {
    'stock.sale_product_status_id': function(val) {
      this.status.forEach(element => {
        let cont = 0;
        if (element.id == val && element.StatusName == 'Reservado' && cont == 0) {
          this.stateStock = true;
          cont++;
          console.log(this.stateStock);
        }
        if (element.id == val && element.StatusName != 'Reservado' && cont == 0) {
          this.stateStock = false;
          console.log(this.stateStock);
        }
      });
    },
  },
  mounted() {
    this.getProducts();
    this.getProductStatus();
    this.getLocations();
    this.getCustomers();
    this.getColors();
  },
};
</script>
<style scoped>
.border {
  border: 1px solid #d2d6de;
  background-color: white;
}
</style>
