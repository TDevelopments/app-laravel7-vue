<template>
  <div class="m-page">
    <v-col class="mt-5">
      <h2>Mis Pedidos</h2>
      <v-divider></v-divider>
      <v-expansion-panels v-model="panel">
        <v-expansion-panel v-for="order in orders" :key="order.id">
          <v-expansion-panel-header>
            <v-row class="d-flex d-flex justify-space-between align-center">
              <v-col cols="4" class="pr-0"> Pedido de {{ order.catalogue.name }} </v-col>
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
            <v-data-table
              :items="order.orderDetails"
              :headers="orderHeaders"
              dense
              class="hidden-xs-only"
            >
              <template v-slot:[`item.image`]="{ item }">
                <div class="d-flex justify-center aling-center">
                  <v-img
                    v-if="item.product.images == null || item.product.images.length == 0"
                    src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"
                    max-width="150"
                    max-height="150"
                    contain
                    class="m-1 my-5"
                  />
                  <v-img
                    v-else
                    contain
                    :src="item.product.images[0].path"
                    max-width="150"
                    class="text-center align-center my-5"
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
                          props.item.product.images == null || props.item.product.images.length == 0
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
                    <v-btn small class="my-5" @click="prueba(props.item.product)">Ver Mas</v-btn>
                  </td>
                </tr>
              </template>
            </v-data-table>
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
