<template>
  <v-card>
    <v-row>
      <v-col>
        <v-combobox solo append-icon="mdi-magnify" dense class="mt-3"></v-combobox>
      </v-col>
      <v-col>
        <v-combobox solo append-icon="mdi-magnify" dense class="mt-3"></v-combobox>
      </v-col>
      <v-col>
        <v-combobox solo append-icon="mdi-magnify" dense class="mt-3"></v-combobox>
      </v-col>
      <v-col>
        <v-combobox solo append-icon="mdi-magnify" dense class="mt-3"></v-combobox>
      </v-col>
    </v-row>
    <v-card-title>
      Ordenes de Cliente
      <v-spacer></v-spacer>
    </v-card-title>
    <v-data-table
      :headers="headers"
      :items="orders"
      item-key="item.id"
      loading-text="Loading... Please wait"
    >
      <template v-slot:[`item.status`]="{ item }">
        <v-chip color="red" dark small>
          {{ item.status }}
        </v-chip>
      </template>
      <template v-slot:[`item.actions`]="{ item }">
        <v-row>
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
import axios from 'axios';

export default {
  data: () => ({
    orders: [],
    headers: [
      {
        text: 'Nro Orden',
        value: 'id',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Cliente',
        value: 'user.name',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Catalogo',
        value: 'catalogue.name',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Estado',
        value: 'status',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Total de Orden',
        value: 'total_order',
        align: 'center',
        sortable: false,
      },
      { text: 'Actions', value: 'actions', sortable: false, align: 'center' },
    ],
  }),
  methods: {
    getOrders() {
      axios
        .get('/api/v1/orders')
        .then(response => {
          console.log(response);
          this.orders = response.data.data;
        })
        .catch(error => {});
    },
    editItem(item) {
      console.log(item.id);
      this.$router.push({
        name: 'editOrder',
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
