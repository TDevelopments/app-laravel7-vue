<template>
  <v-card>
    <v-data-table
      :headers="headers"
      :items="orders"
      item-key="item.id"
      loading-text="Loading... Please wait"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Ordenes de Clientes</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>
        </v-toolbar>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-row>
          <v-col class="px-0">
            <ProductForCatalogue :idCatalogue="item.catalogue.id" />
          </v-col>
          <v-col class="px-0">
            <v-icon small @click="editItem(item)" color="#D6B331">
              mdi-pencil
            </v-icon>
          </v-col>
        </v-row>
      </template>
    </v-data-table>
  </v-card>
</template>
<script>
import axios from "axios";

export default {
  data: () => ({
    orders: [],
    headers: [
      {
        text: "Nro Orden",
        value: "id",
        align: "center",
        sortable: false,
      },
      {
        text: "Catalogo",
        value: "catalogue.name",
        align: "center",
        sortable: false,
      },
      {
        text: "Estado",
        value: "status",
        align: "center",
        sortable: false,
      },
      {
        text: "Total de Orden",
        value: "total_order",
        align: "center",
        sortable: false,
      },
      { text: "Actions", value: "actions", sortable: false, align: "center" },
    ],
  }),
  methods: {
    getOrders() {
      axios
        .get("/api/v1/orders")
        .then((response) => {
          console.log(response);
          this.orders = response.data.data;
        })
        .catch((error) => {});
    },
    editItem(item) {
      console.log(item.id);
      this.$router.push({
        name: "editOrder",
        params: {
          id: item.id,
        },
      });
    },
  },
  mounted() {
    this.getOrders();
  },
};
</script>
