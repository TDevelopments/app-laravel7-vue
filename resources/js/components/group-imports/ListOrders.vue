<template>
  <div class="m-page">
    <v-col class="mt-5">
      <h2>Mis Pedidos</h2>
      <v-divider></v-divider>
      <v-expansion-panels>
        <v-expansion-panel v-for="order in orders" :key="order.id">
          <v-expansion-panel-header>
            <v-row class="d-flex d-flex justify-space-between align-center">
              <v-col cols="4" class="pr-0">
                Pedido de {{ order.catalogue.name }} <br />
                Nro. Pedido {{ order.id }}
              </v-col>
              <v-col cols="4" class="d-flex justify-center align-center">
                <v-row>
                  <v-col class="p-0 pb-1 pr-2 d-flex justify-end align-center text-center">
                    Estado Pago:
                  </v-col>
                  <v-col class="p-0 pb-1">
                    <v-chip
                      :color="order.status == 'pending' ? 'red' : 'green'"
                      dark
                      small
                      class="text-capitalize d-flex justify-center align-center"
                      >{{ order.status == 'pending' ? 'Pendiente' : 'Otro' }}</v-chip
                    >
                  </v-col>
                </v-row>
              </v-col>
              <v-col cols="4" class="text-right pl-0 pr-5">
                Total de Pedido <br />
                {{ order.catalogue.coin == 'soles' ? ' S/. ' : ' $ '
                }}{{ order.total_order | currency }}
              </v-col>
            </v-row>
            <template v-slot:actions>
              <v-icon color="primary">
                $expand
              </v-icon>
            </template>
          </v-expansion-panel-header>
          <v-expansion-panel-content style="padding: 0 0 0 0 !important">
            <v-tabs v-model="currentTab" centered>
              <v-tab> Productos </v-tab>
              <v-tab> Pagos </v-tab>
            </v-tabs>
            <v-tabs-items v-model="currentTab">
              <v-tab-item v-if="order.orderDetails.length == 0 || order.orderDetails == null">
                No se encontraron pedidos
              </v-tab-item>
              <v-tab-item v-else>
                <br />
                <br />
                <v-data-table
                  :items="order.orderDetails"
                  :headers="orderHeaders"
                  dense
                  class="hidden-xs-only "
                >
                  <template v-slot:[`item.image`]="{ item }">
                    <div class="d-flex justify-center aling-center">
                      <v-img
                        v-if="item.product.images == null || item.product.images.length == 0"
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
                  </template>
                  <template v-slot:[`item.quantity`]="{ item }">
                    {{ item.quantity }}
                    <div class="text-capitalize">{{ item.product.type_group }}</div>
                  </template>
                  <template v-slot:[`item.price`]="{ item }">
                    {{ order.catalogue.coin == 'soles' ? 'S/. ' : '$ ' }}
                    {{ item.price | currency }}
                  </template>
                  <template v-slot:[`item.total`]="{ item }">
                    {{ order.catalogue.coin == 'soles' ? 'S/. ' : '$ ' }}
                    {{ item.total | currency }}
                  </template>
                  <template v-slot:[`item.button`]="{ item }">
                    <v-btn small class="my-5" @click="prueba(item.product)">Ver Mas</v-btn>
                  </template>
                </v-data-table>
                <v-data-table
                  :items="order.orderDetails"
                  :headers="orderHeaders"
                  dense
                  class="hidden-sm-and-up"
                  disable-pagination
                  hide-default-footer
                >
                  <template v-slot:item="props">
                    <tr class="mt-5 bb">
                      <td class="px-0">
                        <div class="d-flex justify-center aling-center">
                          <v-img
                            v-if="
                              props.item.product.images == null ||
                                props.item.product.images.length == 0
                            "
                            src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"
                            max-width="75"
                            max-height="75"
                            contain
                            class="m-1 my-5"
                          />
                          <v-img
                            v-else
                            contain
                            :src="props.item.product.images[0].path"
                            max-width="75"
                            class="text-center align-center my-5"
                          />
                        </div>
                      </td>
                      <td class="px-0 py-5">
                        <div class="d-flex">
                          <strong>Modelo: </strong> {{ props.item.product.model }}
                        </div>
                        <div class="d-flex">
                          <strong>Cant.</strong>
                          {{ props.item.quantity }}
                        </div>
                        <div class="d-flex">
                          <strong>P.U: </strong>
                          {{ order.catalogue.coin == 'soles' ? 'S/. ' : '$ ' }}
                          {{ props.item.price | currency }}
                        </div>
                        <div class="d-flex">
                          <strong>Tot.Prod: </strong>
                          {{ order.catalogue.coin == 'soles' ? 'S/. ' : '$ ' }}
                          {{ props.item.total | currency }}
                        </div>
                      </td>
                      <td class="px-0">
                        <v-btn small class="my-5" @click="prueba(props.item.product)"
                          >Ver Mas</v-btn
                        >
                      </td>
                    </tr>
                  </template>
                </v-data-table>
              </v-tab-item>
              <v-tab-item v-if="order.payment.length == 0 || order.payment == null">
                <br />
                <br />
                No se encontraron pagos hechos.
              </v-tab-item>
              <v-tab-item v-else>
                <br />
                <br />

                <div v-for="(item, index) in order.payment" :key="index">
                  <strong> Pago Nro :</strong> {{ index + 1 }} <br />
                  Monto Pagado: {{ item.mount }} <br />
                  Fecha de Pago: {{ item.payment_date | date }}
                  <v-divider></v-divider>
                </div>
              </v-tab-item>
            </v-tabs-items>
          </v-expansion-panel-content>
          <Product
            v-model="showScheduleForm"
            :product="itemSelected"
            v-if="showScheduleForm"
            :catalogue="order.catalogue"
          />
        </v-expansion-panel>
      </v-expansion-panels>
      <!-- <v-data-table :items="orders" :headers="orderHeaders"> </v-data-table> -->
    </v-col>
  </div>
</template>
<script>
import Product from './product';
import moment from 'moment';
export default {
  components: {
    Product,
  },
  comments: {
    Product,
  },
  data: () => ({
    showScheduleForm: false,
    itemSelected: null,
    panel: 0,
    orders: [],
    currentTab: 0,
    orderHeaders: [
      {
        text: 'Imagen',
        value: 'image',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Modelo de Producto',
        value: 'product.model',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Precio por Unidad',
        value: 'price',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Cantidad de Pedido de Producto',
        value: 'quantity',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Total de Producto',
        value: 'total',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Detalles',
        value: 'button',
        align: 'center',
        sortable: false,
      },
    ],
    paymentHeaders: [
      {
        text: 'Imagen',
        value: 'image',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Monto',
        value: 'mount',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Fecha de pago',
        value: 'payment_date',
        align: 'center',
        sortable: false,
      },
      // {
      //   text: 'Banco',
      //   value: 'bank_entity_id',
      //   align: 'center',
      //   sortable: false,
      // },
    ],
  }),
  methods: {
    getOrders() {
      axios
        .get('/api/v1/user-order')
        .then(response => {
          this.orders = response.data.data;
          console.log(response.data);
        })
        .catch(error => {
          console.log(error);
        });
    },
    prueba(value) {
      this.itemSelected = value;
      this.showScheduleForm = true;
      console.log(this.itemSelected);
    },
  },
  mounted() {
    this.getOrders();
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
.bb {
  border-top: 2px solid rgb(124, 121, 121);
}
</style>
