<template>
  <div>
    <v-col>
      <h3>Crear nueva orden</h3>
      <v-btn @click="generateOrder">Crear</v-btn>
    </v-col>
    <v-divider></v-divider>
    <v-data-table
      v-model="selected"
      :single-select="false"
      show-select
      :headers="headers"
      :items="products"
      hide-default-footer
      disable-pagination
    >
      <template v-slot:item="props">
        <tr class="style-table-th">
          <td>
            <v-checkbox
              :input-value="props.isSelected"
              @change="props.select($event)"
              hide-details
              style="display: block"
              class="px-0 mx-0"
            ></v-checkbox>
          </td>
          <td class="style-table-td">
            <v-row class="d-flex align-center justify-center">
              <v-col cols="1" class="p-0 m-0 pt-4">
                <strong>{{ props.index + 1 }}</strong>
              </v-col>
              <v-col cols="9">
                <v-img
                  v-if="props.item.Picture == null || props.item.Picture.length == 0"
                  src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"
                  max-width="200"
                  max-height="200"
                  contain
                  class="m-1 my-5"
                />
                <v-img
                  v-else
                  contain
                  :src="props.item.Picture[0].PicturePath"
                  max-width="200"
                  class="text-center align-center my-5"
                />
              </v-col>
            </v-row>
          </td>
          <td class="style-table-td">
            {{ props.item.ProductName }}
          </td>
          <td class="style-table-td">
            {{
              props.item.SellingPrice == null ? 'No se encontro precio' : props.item.SellingPrice
            }}
          </td>
          <td class="style-table-td">
            {{ props.item.UnitPrice == null ? 'No se encontro precio' : props.item.UnitPrice }}
          </td>
          <td class="style-table-td pr-5">
            <div class="form-inline justify-content-center">
              <v-icon class="back" @click="minusFunction(props.item, props.index)" small dark>
                mdi-minus
              </v-icon>
              <input type="text" class="w text-center" v-model="props.item.Quantity" />
              <v-icon class="back" @click="plusFunctionO(props.index)" small dark>
                mdi-plus
              </v-icon>
            </div>
          </td>
        </tr>
      </template>
    </v-data-table>
    <br />
    <br />
    <div class="my-3 mx-3">
      <v-row class="border mb-3">
        <v-col cols="12" sm="6" md="3">
          Metodo de Pago
          <v-select
            v-model="payment.PaymentMethodId"
            solo
            required
            placeholder="Example"
            v-on:keyup.enter="addCategorie"
            class="border"
            flat
            dense
            hide-details
            :items="paymentMethod"
            item-text="PaymentMethodName"
            item-value="id"
          ></v-select>
        </v-col>
        <v-col cols="12" sm="6" md="3">
          Estado de Pago
          <v-select
            v-model="payment.PaymentStatusId"
            solo
            required
            placeholder="Example"
            v-on:keyup.enter="addCategorie"
            class="border"
            flat
            dense
            hide-details
            :items="paymentStatus"
            item-value="id"
            item-text="PaymentStatusName"
          ></v-select>
        </v-col>
        <v-col cols="12" sm="6" md="3">
          Total Pagado
          <v-text-field
            v-model="payment.TotalPaid"
            solo
            required
            placeholder="Example"
            v-on:keyup.enter="addCategorie"
            class="border"
            flat
            dense
            hide-details
          ></v-text-field>
        </v-col>
        <v-col cols="12" sm="6" md="3">
          Nota de Venta
          <v-text-field
            v-model="payment.SellNote"
            solo
            required
            placeholder="Example"
            v-on:keyup.enter="addCategorie"
            class="border"
            flat
            dense
            hide-details
          ></v-text-field>
        </v-col>
      </v-row>
    </div>
  </div>
</template>

<script>
export default {
  data: () => ({
    catalogues: [],
    customers: [],
    cusSelect: '',
    products: [],
    productsRanges: [],
    catalogue: {},
    catSelect: '',
    currentTab: '',
    selected: [],
    selectedRange: [],
    headers: [
      { text: 'Imagen', value: 'images', align: 'center', sortable: false },
      {
        text: 'Modelo',
        value: 'model',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Precio de Venta',
        value: 'brand',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Precio unitario',
        value: 'price_unit',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Cantidad de Pedido',
        value: 'quantity_order',
        align: 'center',
        sortable: false,
        width: 135,
      },
    ],
    status: false,
    payment: {},
    paymentMethod: [],
    paymentStatus: [],
  }),
  methods: {
    getProducts() {
      axios.get('/api/v1/sale-products?availableStock=true').then(response => {
        this.products = response.data.data;
        this.products.forEach(element => {
          Vue.set(element, 'Quantity', 0);
          Vue.set(element, 'ProductId', element.id);
        });
        console.log(this.products);
      });
    },
    getPaymentMethod() {
      axios.get('/api/v1/sale-payment-methods?list=true').then(response => {
        this.paymentMethod = response.data.data;
        console.log(response);
      });
    },
    getPaymentStatus() {
      axios.get('/api/v1/sale-payment-status?list=true').then(response => {
        this.paymentStatus = response.data.data;
        console.log(response);
      });
    },
    isObjEmpty(obj) {
      for (var prop in obj) {
        if (obj[prop] == '') return true;
        if (obj.hasOwnProperty(prop)) return false;
      }
      return true;
    },
    generateOrder() {
      let dat = {};
      if (!this.isObjEmpty(this.payment)) {
        dat.Payment = this.payment;
      }
      dat.Products = this.selected;
      console.log(dat);
      axios({
        url: '/api/v1/sale-orders',
        method: 'POST',
        data: dat,
      })
        .then(resp => {
          this.$router.replace({ name: 'listStockOrder' });
        })
        .catch(err => console.log(err));
    },
    minusFunction(item, index) {
      if (item.Quantity <= 0) {
        alert(
          `Lo sentimos, la candidad minima de compra de este producto es ${item.quantity_group}`
        );
      } else {
        this.products[index].Quantity = this.products[index].Quantity - 1;
      }
    },
    plusFunctionO(index) {
      this.products[index].Quantity = this.products[index].Quantity + 1;
    },
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
    name: function(value) {
      let c = value;
      let s = ' ';
      let a = c.split(s);
      switch (a.length) {
        case 1:
          return value;
        case 2:
          return value;
        case 3:
          return a[0] + ' ' + a[1];
        case 4:
          return a[0] + ' ' + a[2];
        default:
          return value;
      }
    },
  },
  mounted() {
    this.getProducts();
    this.getPaymentMethod();
    this.getPaymentStatus();
  },
};
</script>
<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800&display=swap');
.border {
  border: 1px solid #d2d6de;
  background-color: white;
}
.back {
  background-color: black;
  border-radius: 100%;
  padding: 2px;
}
.style-table-th:hover {
  background-color: #ffcdd2 !important;
}
.style-table-td {
  text-align: center !important;
  padding-left: 2px !important;
  padding-right: 2px !important;
}
.font-text {
  font-family: 'Poppins', sans-serif;
  font-size: 1.2rem;
  font-weight: 500;
  color: #444;
  font-weight: bold;
}
.b-input {
  border: 1px solid black;
  border-radius: 10%;
}
.display-md {
  visibility: hidden;
}
.bb:hover {
  background-color: chartreuse;
}
.bb {
  border-bottom: 2px solid rgb(124, 121, 121);
}
.content-cart {
  display: flex;
  flex-direction: row;
}
.color {
  background-color: #bcdaf1;
}
.pc {
  color: red;
}
.w {
  display: flex;
  max-width: 30px;
  text-align: center;
}
.w1 {
  display: flex;
  max-width: 25px;
}
.header-card {
  background-color: black;
  color: white;
  align-items: center;
}
.content-card {
  border: 1px solid black;
}
.float {
  position: sticky;
  bottom: 30px;
  background-color: #bcdaf1;
  align-self: flex-end;
}
.float-movil {
  visibility: hidden;
}
.m-page {
  margin-right: 5%;
  margin-left: 5%;
}
.p-page {
  padding-right: 5%;
  padding-left: 5%;
}
</style>
