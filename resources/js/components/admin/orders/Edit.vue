<template>
  <v-card flat>
    <v-card-text>
      <h3>Edición de Orden</h3>
      <v-divider></v-divider>
      <v-form ref="form" v-model="valid" lazy-validation>
        <v-row>
          <v-col cols="12" sm="6" md="6">
            Nombre de Catálogo
            <v-text-field v-model="catalogue.name" solo required readonly></v-text-field>
          </v-col>
          <v-col cols="12" sm="6" md="6">
            Total de Orden
            <v-text-field v-model="totalOrder" solo required readonly></v-text-field>
          </v-col>
          <v-col cols="12" sm="6" md="6">
            Estado de Orden
            <v-select
              v-model="order.state_order"
              item-value="id"
              item-text="name"
              :items="state"
              menu-props="auto"
              hide-details
              prepend-inner-icon="mdi-credit-card"
              solo
            ></v-select>
          </v-col>
          <v-col cols="12" sm="6" md="6">
            Nombre de Cliente
            <v-text-field v-model="user.name" solo required readonly></v-text-field>
          </v-col>
        </v-row>
      </v-form>
      <v-expansion-panels>
        <v-expansion-panel>
          <v-expansion-panel-header>
            Productos de Orden
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <v-data-table
              :headers="headers"
              :items="product"
              hide-default-footer
              disable-pagination
              loading-text="Loading... Please wait"
            >
              <template v-slot:[`item.image`]="{ item }">
                <div class="d-flex justify-center aling-center" v-if="item.product">
                  <v-img
                    v-if="!item.product.images || item.product.images.length == 0"
                    src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"
                    max-width="150"
                    max-height="150"
                    contain
                  />
                  <v-img
                    v-else
                    contain
                    :src="item.product.images[0].path"
                    max-width="150"
                    max-height="150"
                  />
                </div>
                <div class="d-flex justify-center aling-center" v-else>
                  <v-img
                    v-if="!item.product_range.images || item.product_range.images.length == 0"
                    src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"
                    max-width="150"
                    max-height="150"
                    contain
                  />
                  <v-img
                    v-else
                    contain
                    :src="item.product_range.images[0].path"
                    max-width="150"
                    max-height="150"
                  />
                </div>
              </template>
              <template v-slot:[`item.model`]="{ item }">
                {{ item.product ? item.product.model : item.product_range.model }}
              </template>
              <template v-slot:[`item.actions`]="{ item, index }">
                <v-icon @click="deleteProducts(item.id, index)">mdi-delete</v-icon>
              </template>
              <template v-slot:[`item.total`]="{ item }">
                {{ item.total | currency }}
              </template>
              <template v-slot:[`item.quantity`]="{ item }">
                <v-text-field
                  v-model="item.quantity"
                  solo
                  style="width:100px"
                  type="number"
                  hide-details
                />
              </template>
            </v-data-table>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>
      <br /><br />
      <div class="d-flex">
        <h4 class="mt-5">Pagos</h4>
      </div>
      <div v-for="(paymentG, index) in payments" :key="index">
        <v-row>
          <v-col cols="1" class="text-center">
            <v-img
              v-if="paymentG.image == null || !paymentG.image || paymentG.image.length == 0"
              src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"
              max-width="100"
              max-height="100"
              contain
              class="my-auto"
              @click="prueba('https://cdn.vuetifyjs.com/images/parallax/material.jpg')"
            />
            <v-img
              @click="prueba(paymentG.image.path)"
              v-else
              contain
              class="my-auto"
              :src="paymentG.image.path"
              max-width="100"
              max-height="100"
            />
          </v-col>
          <v-col cols="12" md="2">
            Imagen
            <v-file-input
              accept="image/png, image/jpeg"
              prepend-icon="mdi-camera"
              solo
              multiple
              dense
              placeholder="Pago"
              v-model="paymentG.image_upload"
              @change="addImages(paymentG.image_upload, index)"
            ></v-file-input>
          </v-col>
          <v-col cols="12" md="3">
            Concepto
            <v-select
              v-model="paymentG.payment_concept_id"
              :items="concept"
              item-text="name"
              dense
              item-value="id"
              menu-props="auto"
              hide-details
              prepend-inner-icon="mdi-map"
              solo
            ></v-select>
          </v-col>
          <v-col cols="12" md="2">
            <v-menu
              v-model="paymentG.calendar"
              :close-on-content-click="false"
              :nudge-right="40"
              dense
              transition="scale-transition"
              offset-y
              min-width="auto"
            >
              <template v-slot:activator="{ on, attrs }">
                Fecha de Pago
                <v-text-field
                  v-model="paymentG.payment_date"
                  prepend-inner-icon="mdi-calendar"
                  solo
                  dense
                  v-bind="attrs"
                  v-on="on"
                ></v-text-field>
              </template>
              <v-date-picker
                v-model="paymentG.payment_date"
                @input="paymentG.calendar = false"
              ></v-date-picker>
            </v-menu>
          </v-col>
          <v-col cols="12" md="2">
            Monto
            <v-text-field v-model="paymentG.mount" dense placeholder="0.00" solo type="number">
            </v-text-field>
          </v-col>
          <v-col cols="12" md="2">
            Nro Operación
            <v-text-field
              v-model="paymentG.nro_operation"
              dense
              placeholder="0.00"
              solo
              type="number"
            >
            </v-text-field>
          </v-col>
          <v-col cols="12" md="2">
            Tipo moneda
            <v-select
              v-model="paymentG.type_coin"
              :items="typeCoin"
              dense
              menu-props="auto"
              hide-details
              prepend-inner-icon="mdi-map"
              solo
              placeholder="Selecciona"
            ></v-select>
          </v-col>
          <v-col cols="12" md="2" v-if="paymentG.type_coin == 'dolares'">
            Precio Dolar
            <v-text-field
              v-model="paymentG.dollar_price"
              dense
              placeholder="0.00"
              solo
              type="number"
            >
            </v-text-field>
          </v-col>
          <v-col cols="12" md="2">
            Banco
            <v-select
              v-model="paymentG.bank_entity_id"
              :items="bank"
              dense
              item-value="id"
              item-text="name"
              menu-props="auto"
              hide-details
              prepend-inner-icon="mdi-map"
              solo
              placeholder="Selecciona"
            ></v-select>
          </v-col>
        </v-row>
        <v-divider></v-divider>
      </div>
    </v-card-text>
    <v-btn @click="validate">Guardar</v-btn>
    <v-btn @click="validateProduct">Guardar Productos</v-btn>
    <ImagePaymen v-model="dialogImage" v-if="dialogImage" :image="itemSelected" />
  </v-card>
</template>
<script>
import axios from 'axios';
import moment from 'moment';
import ImagePaymen from './ImagePayment';

export default {
  components: {
    ImagePaymen,
  },
  data: () => ({
    dialogImage: false,
    headers: [
      {
        text: 'Imagen',
        value: 'image',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Model',
        value: 'model',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Cantidad de Producto',
        value: 'quantity',
        align: 'center',
        sortable: false,
        width: 10,
      },
      {
        text: 'Precio del Producto Total',
        value: 'total',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Acciones',
        value: 'actions',
        align: 'center',
        sortable: false,
      },
    ],
    order: [],
    valid: true,
    product: [],
    catalogue: {
      name: '',
    },
    user: {
      name: '',
    },
    payments: [],
    concept: [],
    state: [],
    bank: [],
    itemSelected: '',
    idDelete: [],
    typeCoin: ['soles', 'dolares'],
  }),
  computed: {
    totalOrder() {
      let a = this.order.total_order;

      return parseFloat(a).toFixed(2);
    },
  },
  methods: {
    validate() {
      this.addPayment();
    },
    addImages(images, id) {
      const data = new FormData();
      images.forEach((elements, index) => {
        data.append(`image_uploads[${index}]`, elements);
      });

      axios
        .post(`/api/v1/uploads`, data, {
          headers: {
            Accept: 'application/json',
            'Content-Type': 'multipart/form-data',
          },
        })
        .then(response => {
          this.payments[id].image = response.data[0];
          console.log('aqui', response.data[0]);
        })
        .catch(error => {
          console.log(error);
          // reject(error);
        });
    },

    editOrders() {
      axios
        .get('/api/v1/orders', this.user)
        .then(response => {
          console.log(response);
        })
        .catch(error => {
          console.log(error);
          // reject(error);
        });
    },

    addPayment() {
      let ultimo = this.payments.length - 1;
      if (this.payments[ultimo].mount == '' || null) {
        this.payments.splice(ultimo, 1);
        axios
          .post(`/api/v1/orders/${this.$route.params.id}/payments`, { payments: this.payments })
          .then(response => {
            console.log(response);
            this.updateOrders();
          })
          .catch(error => {
            console.log(error);
            // reject(error);
          });
      } else {
        axios
          .post(`/api/v1/orders/${this.$route.params.id}/payments`, { payments: this.payments })
          .then(response => {
            console.log(response);
            this.getOrders();
          })
          .catch(error => {
            console.log(error);
            // reject(error);
          });
      }
    },

    getOrders() {
      axios
        .get(`/api/v1/orders/${this.$route.params.id}`)
        .then(response => {
          console.log(response);
          this.product = response.data.data.orderDetails;
          this.order = response.data.data;
          this.user = response.data.data.user;
          this.catalogue = response.data.data.catalogue;
          this.payments = response.data.data.payment;
          if (this.payments.length != 0 && this.payments != null) {
            this.payments.forEach(payment => {
              this.order.total_order =
                parseFloat(this.order.total_order) - parseFloat(payment.mount);
              console.log(this.order.total_order);
            });
          }
          this.payments.push({
            mount: '',
            payment_date: '',
            image: [],
            image_upload: [],
            payment_concept_id: '',
            bank_entity_id: '',
            type_coin: 'soles',
            dollar_price: 0.0,
          });
          console.log(this.payments);
        })
        .catch(error => {
          console.log(error);
          // reject(error);
        });
    },

    updateOrders() {
      axios
        .put(`/api/v1/orders/${this.$route.params.id}`, { state_order_id: this.order.state_order })
        .then(response => {
          console.log(response);
          this.getOrders();
        })
        .catch(error => {
          console.log(error);
          // reject(error);
        });
    },

    updateCreate() {
      let data = [];
      this.product.forEach(element => {
        data.push({
          product_id: element.product.id,
          quantity: element.quantity,
        });
      });

      axios
        .post(`/api/v1/orders/${this.$route.params.id}/order-details`, { products: data })
        .then(response => {
          console.log(response);
          this.getOrders();
        })
        .catch(error => {
          console.log(error);
          // reject(error);
        });
    },

    deleteItems() {
      axios
        .delete(`/api/v1/order-details`, {
          data: {
            order_details: this.idDelete,
          },
        })
        .then(response => {
          console.log(response);
          this.updateCreate();
        })
        .catch(error => {
          console.log(error);
          // reject(error);
        });
    },

    validateProduct() {
      if (this.idDelete.length != 0) {
        this.deleteItems();
      } else {
        this.updateCreate();
      }
    },

    deleteProducts(id, index) {
      this.idDelete.push(id);
      this.product.splice(index, 1);
      console.log(this.idDelete);
    },

    getConcept() {
      axios
        .get('/api/v1/payment-concepts')
        .then(response => {
          this.concept = response.data;
          console.log(response);
        })
        .catch(error => {});
    },

    getState() {
      axios
        .get('/api/v1/state-orders')
        .then(response => {
          this.state = response.data;
          console.log(response);
        })
        .catch(error => {});
    },
    getBanks() {
      axios
        .get('/api/v1/banks')
        .then(response => {
          this.bank = response.data;
          console.log(response);
        })
        .catch(error => {});
    },

    prueba(value) {
      this.itemSelected = value;
      this.dialogImage = true;
      console.log(this.itemSelected);
    },
  },
  filters: {
    currency: function(value) {
      return parseFloat(value).toFixed(2);
    },
    porcent: function(value) {
      return parseFloat(value) * 100 + ' %';
    },
    date: function(value) {
      return moment(value).format('YYYY-MM-DD');
    },
  },
  mounted() {
    this.getOrders();
    this.getConcept();
    this.getState();
    this.getBanks();
  },
};
</script>
