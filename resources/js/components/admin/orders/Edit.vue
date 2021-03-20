<template>
  <v-window class="elevation-1" vertical>
    <v-window-item>
      <v-card flat>
        <v-card-text>
          <h3>Edicion de Orden</h3>
          <v-divider></v-divider>
          <v-form ref="form" v-model="valid" lazy-validation>
            <v-row>
              <v-col cols="12" sm="6" md="6">
                Nombre de Catalogo
                <v-text-field
                  v-model="order.catalogue.name"
                  solo
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                Total de Orden
                <v-text-field
                  v-model="order.total_order"
                  solo
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                Estado de Orden
                <v-text-field
                  v-model="order.status"
                  solo
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                Nombre de Usuario
                <v-text-field
                  v-model="order.user.name"
                  solo
                  required
                ></v-text-field>
              </v-col>
            </v-row>
          </v-form>
          <v-data-table
            :headers="headers"
            :items="product"
            loading-text="Loading... Please wait"
          ></v-data-table>
        </v-card-text>
      </v-card>
    </v-window-item>
  </v-window>
</template>
<script lang="ts">
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
  }),
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
        .put(`/api/v1/orders/${this.$route.params.id}`)
        .then((response) => {
          console.log(response);
          this.product = response.data.data.orderDetails; 
          this.order = response.data.data;
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