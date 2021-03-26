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
            <v-text-field v-model="order.total_order" solo required readonly></v-text-field>
          </v-col>
          <v-col cols="12" sm="6" md="6">
            Estado de Orden
            <v-select
              v-model="order.status"
              :items="states"
              item-text="name"
              item-value="send"
              menu-props="auto"
              hide-details
              prepend-inner-icon="mdi-credit-card"
              solo
            ></v-select>
          </v-col>
          <v-col cols="12" sm="6" md="6">
            Nombre de Cliente
            <v-text-field v-model="completeName" solo required readonly></v-text-field>
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
                <div class="d-flex justify-center aling-center">
                  <v-img
                    v-if="item.product.images == null || item.product.length == 0"
                    src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"
                    max-width="75"
                    max-height="75"
                    contain
                    class="m-1 my-5"
                  />
                  <v-img
                    v-else
                    contain
                    :src="item.product.images[0].path"
                    max-width="75"
                    class="text-center align-center my-5"
                  />
                </div>
              </template>
            </v-data-table>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>
      <br /><br />
      <div class="d-flex">
        <h4 class="mt-5">Añadir Pago</h4>
        <v-btn color="black" fab x-small class="mt-4 ml-3" dark>
          <v-icon>mdi-plus</v-icon>
        </v-btn>
      </div>

      <v-row>
        <v-col cols="12" md="3">
          Concepto
          <v-select
            :items="concept"
            menu-props="auto"
            hide-details
            prepend-inner-icon="mdi-map"
            solo
          ></v-select>
        </v-col>
        <v-col cols="12" md="2">
          Monto
          <v-text-field placeholder="0.00" solo type="number"> </v-text-field>
        </v-col>
        <v-col cols="12" md="2">
          <v-menu
            :close-on-content-click="false"
            :nudge-right="40"
            transition="scale-transition"
            offset-y
            min-width="auto"
          >
            <template v-slot:activator="{ on, attrs }">
              Fecha
              <v-text-field
                prepend-inner-icon="mdi-calendar"
                solo
                v-bind="attrs"
                v-on="on"
                placeholder="2001-02-03"
              ></v-text-field>
            </template>
            <v-date-picker @input="input.calendar = false"></v-date-picker>
          </v-menu>
        </v-col>
        <v-col cols="12" md="2">
          Nro Orden
          <v-text-field solo placeholder="120"> </v-text-field>
        </v-col>
        <v-col cols="12" md="2">
          Banco
          <v-select
            :items="bank"
            menu-props="auto"
            hide-details
            prepend-inner-icon="mdi-map"
            solo
            placeholder="Selecciona"
          ></v-select>
        </v-col>
        <v-col cols="1" md="1" class="text-center">
          <v-btn color="error" fab x-small class="mt-5" elevation="2">
            <v-icon>mdi-minus</v-icon>
          </v-btn>
        </v-col>
      </v-row>
      <div class="text-center"></div>
    </v-card-text>
  </v-card>
</template>
<script>
import axios from 'axios';
export default {
  data: () => ({
    headers: [
      {
        text: 'Imagen',
        value: 'image',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Model',
        value: 'product.model',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Cantidad de Producto',
        value: 'quantity',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Precio del Producto Total',
        value: 'total',
        align: 'center',
        sortable: false,
      },
    ],
    concept: ['Pago primer 40%', 'Pago primer 60%'],
    bank: ['BCP', 'BBVA'],
    order: [],
    valid: true,
    product: [],
    catalogue: {
      name: '',
    },
    user: {
      name: '',
    },
  }),
  computed: {
    completeName() {
      return this.user.name;
    },
    states() {
      let s = [
        {
          name: 'Pendiente',
          send: 'pending',
        },
        {
          name: 'Separado',
          send: 'separated',
        },
        {
          name: 'Primer Pago del ' + this.catalogue.first_payment + ' %',
          send: 'first_payment',
        },
        {
          name: 'Segundo Pago del ' + this.catalogue.second_payment + ' %',
          send: 'second_payment',
        },
        {
          name: 'Pago Completado',
          send: 'paid',
        },
        {
          name: 'Anulado',
          send: 'cancelled',
        },
      ];
      return s;
    },
  },
  methods: {
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
    getOrders() {
      axios
        .get(`/api/v1/orders/${this.$route.params.id}`)
        .then(response => {
          console.log(response);
          this.product = response.data.data.orderDetails;
          this.order = response.data.data;
          this.user = response.data.data.user;
          this.catalogue = response.data.data.catalogue;
        })
        .catch(error => {
          console.log(error);
          // reject(error);
        });
    },
  },
  mounted() {
    this.getOrders();
  },
};
</script>
