<template>
  <v-window class="elevation-1" vertical>
    <v-window-item>
      <v-card flat>
        <v-card-text>
          <h3>Edición de Orden</h3>
          <v-divider></v-divider>
          <v-form ref="form" v-model="valid" lazy-validation>
            <v-row>
              <v-col cols="12" sm="6" md="6">
                Nombre de Catálogo
                <v-text-field
                  v-model="catalogue.name"
                  solo
                  required
                  readonly
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                Total de Orden
                <v-text-field
                  v-model="order.total_order"
                  solo
                  required
                  readonly
                ></v-text-field>
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
                <v-text-field
                  v-model="completeName"
                  solo
                  required
                  readonly
                ></v-text-field>
              </v-col>
            </v-row>
          </v-form>
          <v-col class="ma-2">
            <v-row>
              <h4 class="mt-5">Añadir Pago</h4>
              <v-btn color="black" fab x-small class="mt-4 ml-3" dark>
                <v-icon>mdi-plus</v-icon>
              </v-btn>
            </v-row>
          </v-col>
          <v-card flat>
            <v-card-text>
              <v-row>
                <v-col cols="12" sm="11" md="11">
                  <v-row>
                    <v-col cols="12" md="6">
                      Ciudad
                      <v-select
                        :items="states"
                        menu-props="auto"
                        hide-details
                        prepend-inner-icon="mdi-map"
                        solo
                      ></v-select>
                    </v-col>
                    <v-col cols="12" md="6">
                      <v-menu
                        :close-on-content-click="false"
                        :nudge-right="40"
                        transition="scale-transition"
                        offset-y
                        min-width="auto"
                      >
                        <template v-slot:activator="{ on, attrs }">
                          Fechas de Llegada
                          <v-text-field
                            prepend-inner-icon="mdi-calendar"
                            solo
                            v-bind="attrs"
                            v-on="on"
                          ></v-text-field>
                        </template>
                        <v-date-picker
                          @input="input.calendar = false"
                        ></v-date-picker>
                      </v-menu>
                    </v-col>
                  </v-row>
                </v-col>
                <v-col cols="12" sm="1" md="1" class="">
                  <div class="text-center">
                    <v-btn
                      color="error"
                      fab
                      x-small
                      class="mt-5"
                    >
                      <v-icon>mdi-minus</v-icon>
                    </v-btn>
                  </div>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>

          <v-data-table
            :headers="headers"
            :items="product"
            hide-default-footer
            disable-pagination
            loading-text="Loading... Please wait"
          >
            <template v-slot:top>
              <v-toolbar flat>
                <v-toolbar-title>Productos de Orden</v-toolbar-title>
              </v-toolbar>
            </template>
          </v-data-table>
        </v-card-text>
      </v-card>
    </v-window-item>
  </v-window>
</template>
<script>
import axios from "axios";
export default {
  data: () => ({
    headers: [
      {
        text: "Model",
        value: "model",
        align: "center",
        sortable: false,
      },
      {
        text: "Precio del Producto Total",
        value: "total",
        align: "center",
        sortable: false,
      },
      {
        text: "Cantidad de Producto",
        value: "quantity",
        align: "center",
        sortable: false,
      },
    ],
    order: [],
    valid: true,
    product: [],
    catalogue: {
      name: "",
    },
    user: {
      name: "",
    },
  }),
  computed: {
    completeName() {
      return this.user.name + " " + this.user.lastname;
    },
    states() {
      let s = [
        {
          name: "Pendiente",
          send: "pending",
        },
        {
          name: "Pagado",
          send: "paid",
        },
        {
          name: "Cancelado",
          send: "cancelled",
        },
        {
          name: "Separado",
          send: "separated",
        },
        {
          name: "Primer Pago del " + this.catalogue.first_payment + " %",
          send: "first_payment",
        },
      ];
      return s;
    },
  },
  methods: {
    editOrders() {
      axios
        .get("/api/v1/orders", this.user)
        .then((response) => {
          console.log(response);
        })
        .catch((error) => {
          console.log(error);
          // reject(error);
        });
    },
    getOrders() {
      axios
        .get(`/api/v1/orders/${this.$route.params.id}`)
        .then((response) => {
          console.log(response);
          this.product = response.data.data.orderDetails;
          this.order = response.data.data;
          this.user = response.data.data.user;
          this.catalogue = response.data.data.catalogue;
        })
        .catch((error) => {
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