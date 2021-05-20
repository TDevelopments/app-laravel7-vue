<template>
  <div>
    <v-col>
      <h3>Crear nueva orden</h3>
    </v-col>
    <v-row>
      <v-col class="d-flex aling-center justify-center my-auto">
        <v-select
          v-model="catSelect"
          :items="catalogues"
          item-text="name"
          item-value="id"
          label="Seleccionar Catalogo"
          no-data-text="No hay se encontraron datos"
          dense
          outline
          solo
          hide-details
        ></v-select>
      </v-col>
      <v-col class="d-flex aling-center justify-center my-auto">
        <v-select
          v-model="cusSelect"
          :items="customers"
          item-text="FullName"
          item-value="Id"
          label="Seleccionar Cliente"
          no-data-text="No hay se encontraron datos"
          dense
          outline
          solo
          hide-details
        ></v-select>
      </v-col>
      <v-col class="d-flex aling-center justify-center my-auto">
        <v-checkbox v-model="status" label="Orden de Empresa"></v-checkbox>
      </v-col>
      <v-spacer></v-spacer>
      <v-col class="text-right d-flex my-auto">
        <v-btn @click="generateOrder">
          Generar Orden
        </v-btn>
      </v-col>
    </v-row>
    <v-divider></v-divider>
    <v-col cols="12">
      <v-data-table
        v-model="selected"
        :single-select="false"
        show-select
        :headers="headers"
        :items="catalogue.products"
        hide-default-footer
        height="1000"
        fixed-header
        disable-pagination
        v-if="products.length != 0"
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
                    v-if="props.item.images == null || props.item.images.length == 0"
                    src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"
                    max-width="200"
                    max-height="200"
                    contain
                    class="m-1 my-5"
                  />
                  <v-img
                    v-else
                    contain
                    :src="props.item.images[0].path"
                    max-width="200"
                    class="text-center align-center my-5"
                  />
                </v-col>
              </v-row>
            </td>
            <td class="style-table-td">
              {{ props.item.model }}
              <br />
              <v-btn small class="mt-2 mx-2" @click="prueba(props.item, 'normal')">
                Ver Mas
              </v-btn>
            </td>
            <td class="style-table-td">
              {{ props.item.brand }}
            </td>
            <td class="style-table-td">
              {{ (catalogue.coin == 'soles' ? 'S/.' : '$') + ' ' }}
              {{ props.item.price_unit | currency }}
            </td>
            <td class="style-table-td">
              {{ props.item.quantity_group + ' ' }}
              <br />
              {{ props.item.type_group }}
            </td>
            <td class="style-table-td">
              {{ (catalogue.coin == 'soles' ? 'S/.' : '$') + ' ' }}
              {{ props.item.price_group | currency }}
            </td>
            <td class="style-table-td pr-5">
              <div class="form-inline justify-content-center">
                <v-icon class="back" @click="minusFunction(props.item, props.index)" small dark>
                  mdi-minus
                </v-icon>
                <input type="text" class="w text-center" v-model="props.item.quantity" />
                <v-icon class="back" @click="plusFunctionO(props.index)" small dark>
                  mdi-plus
                </v-icon>
              </div>
            </td>
          </tr>
        </template>
      </v-data-table>

      <v-data-table
        v-model="selectedRange"
        :single-select="false"
        show-select
        :headers="headersItem"
        :items="catalogue.productRanges"
        hide-default-footer
        disable-pagination
        v-if="productsRanges.length != 0"
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
                    v-if="props.item.images == null || props.item.images.length == 0"
                    src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"
                    max-width="200"
                    max-height="200"
                    contain
                    class="m-1 my-5"
                  />
                  <v-img
                    v-else
                    contain
                    :src="props.item.images[0].path"
                    max-width="200"
                    class="text-center align-center my-5"
                  />
                </v-col>
              </v-row>
            </td>
            <td class="style-table-td">
              {{ props.item.model }}
              <br />
              <v-btn small class="mt-2 mx-2" @click="prueba(props.item, 'range')">
                Ver Mas
              </v-btn>
            </td>
            <!-- <td class="style-table-td">
                      {{ props.item.brand }}
                    </td> -->
            <td class="style-table-td">
              <div v-for="(range, index) in props.item.ranges" :key="index">
                De {{ range.min }} a
                {{ props.item.ranges.length - 1 != index ? range.max : 'mas' }} :
                {{ (catalogue.coin == 'soles' ? 'S/.' : '$') + ' ' }} {{ range.price }}
              </div>
            </td>
            <td class="style-table-td pr-5">
              <div class="form-inline justify-content-center">
                <v-icon class="back" dark small @click="minusFunctionR(props.item, props.index)"
                  >mdi-minus</v-icon
                >

                <input type="text" class="w text-center" v-model="props.item.quantity" />

                <v-icon class="back" dark small @click="plusFunctionR(props.index)"
                  >mdi-plus</v-icon
                >
              </div>
            </td>
            <td class="style-table-td">
              <div v-if="props.item.meta">
                <div
                  v-for="(c, index) in props.item.meta"
                  :key="index"
                  class="d-flex justify-center align-center my-1 "
                >
                  <v-avatar :color="c.color" size="15" />
                  <input type="text" class="w mx-2 text-center b-input" v-model="c.quantity" />
                </div>
              </div>
            </td>
            <td class="style-table-td">
              {{ (catalogue.coin == 'soles' ? 'S/.' : '$') + ' ' }}
              {{ props.item.total | currency }}
            </td>
          </tr>
        </template>
      </v-data-table>
    </v-col>
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
        text: 'Marca',
        value: 'brand',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Precio unitario (A)',
        value: 'price_unit',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Cantidad Mínima de Pedido (B)',
        value: 'quantity_group',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Precio Total (AxB)',
        value: 'price_group',
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
    headersItem: [
      { text: 'Imagen', value: 'images', align: 'center', sortable: false },
      {
        text: 'Modelo',
        value: 'model',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Precio por cantidad de Pedido',
        value: 'ranges',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Cantidad de Pedido',
        value: 'quantity_order',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Colores',
        value: 'colors',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Precio del Pedido',
        value: 'total',
        align: 'center',
        sortable: false,
      },
    ],
    status: false,
  }),
  methods: {
    getCatalogues() {
      axios.get('/api/v1/catalogues-availables').then(response => {
        this.catalogues = response.data.data;
      });
    },
    getCustomers() {
      axios.get('/api/v1/sale-customers?list=true').then(response => {
        this.customers = response.data.data;
      });
    },
    getProducts() {
      axios.get(`/api/v1/catalogues/${this.catSelect}`).then(response => {
        if (response.data.data.products != null) {
          this.products = response.data.data.products;
        }
        if (response.data.data.productRanges != null) {
          this.productsRanges = response.data.data.productRanges;
        }
        this.catalogue = response.data.data;
        this.catalogue.products.forEach((product, index) => {
          Vue.set(product, 'quantity', product.quantity_group);
        });
        this.catalogue.productRanges.forEach((productRange, index) => {
          let minRange = 1;
          let price = 0;
          let col = [];
          if (productRange.ranges.length != 0) {
            minRange = productRange.ranges[0].min;
            price = productRange.ranges[0].price;
            productRange.ranges.forEach((range, index) => {
              if (range.min < minRange) {
                minRange = range.min;
                price = range.price;
              }
            });
          }
          if (productRange.colors != null && productRange.colors.length != 0) {
            productRange.colors.forEach(color => {
              col.push({
                color: color,
                quantity: 0,
              });
            });
          }
          Vue.set(productRange, 'meta', col);
          Vue.set(productRange, 'quantity', minRange);
          Vue.set(productRange, 'min', minRange);
          Vue.set(productRange, 'total', price * minRange);
        });
      });
    },

    generateOrder() {
      if (this.selected.length != 0) {
        console.log('me estas jodiendo');
        this.selected.forEach(product => {
          product.product_id = product.id;
        });
      }
      if (this.selectedRange.length != 0) {
        this.selectedRange.forEach(product_range => {
          product_range.product_id = product_range.id;
          console.log(product_range.id);
        });
      }
      axios({
        url: '/api/v1/orders',
        method: 'POST',
        data: {
          catalogue_id: this.catalogue.id,
          products: this.selected.length != 0 ? this.selected : [],
          product_ranges: this.selectedRange.length != 0 ? this.selectedRange : [],
          customer_id: this.cusSelect,
          sale_product_status: this.status != false ? 1 : 0,
        },
      })
        .then(resp => {
          this.$router.replace({ name: 'listOrder' });
        })
        .catch(err => console.log(err));
    },
    minusFunction(item, index) {
      if (item.quantity <= item.quantity_group) {
        alert(
          `Lo sentimos, la candidad minima de compra de este producto es ${item.quantity_group}`
        );
      } else {
        this.catalogue.products[index].quantity =
          this.catalogue.products[index].quantity - this.catalogue.products[index].magnifying;
      }
    },
    plusFunctionO(index) {
      this.catalogue.products[index].quantity =
        this.catalogue.products[index].quantity + this.catalogue.products[index].magnifying;
    },

    minusFunctionR(item, index) {
      if (item.quantity <= item.min) {
        alert(`Lo sentimos, la candidad minima de compra de este producto es ${item.min}`);
      } else {
        this.catalogue.productRanges[index].quantity--;
        let t = 0;
        let p = 0;
        if (this.catalogue.productRanges[index].ranges.length != 0) {
          this.catalogue.productRanges[index].ranges.forEach(range => {
            if (
              this.catalogue.productRanges[index].quantity >= range.min &&
              this.catalogue.productRanges[index].quantity <= range.max
            ) {
              t = range.price * this.catalogue.productRanges[index].quantity;
            }
            p = range.price;
          });
        }

        this.catalogue.productRanges[index].total = t;

        if (this.catalogue.productRanges[index].total == 0) {
          this.catalogue.productRanges[index].total =
            p * this.catalogue.productRanges[index].quantity;
        }
      }
    },
    plusFunctionR(index) {
      this.catalogue.productRanges[index].quantity++;
      let t = 0;
      let p = 0;
      if (this.catalogue.productRanges[index].ranges.length != 0) {
        this.catalogue.productRanges[index].ranges.forEach(range => {
          if (
            this.catalogue.productRanges[index].quantity >= range.min &&
            this.catalogue.productRanges[index].quantity <= range.max
          ) {
            t = range.price * this.catalogue.productRanges[index].quantity;
          }
          p = range.price;
        });
      }

      this.catalogue.productRanges[index].total = t;

      if (this.catalogue.productRanges[index].total == 0) {
        this.catalogue.productRanges[index].total =
          p * this.catalogue.productRanges[index].quantity;
      }
    },
  },
  watch: {
    catSelect: function() {
      this.getProducts();
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
    this.getCatalogues();
    this.getCustomers();
  },
};
</script>
<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800&display=swap');
.back {
  background-color: black;
  border-radius: 100%;
  padding: 2px;
}
.style-table-th {
  border-bottom: 2px solid !important;
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
