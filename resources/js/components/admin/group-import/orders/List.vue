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
      :page.sync="page"
      :items-per-page="itemsPerPage"
      hide-default-footer
    >
      <template v-slot:[`item.status`]="{ item }">
        <v-chip color="red" dark small>
          {{ item.state_order | stateOrder }}
        </v-chip>
      </template>
      <template v-slot:[`item.actions`]="{ item }">
        <div class="d-flex justify-center">
          <v-icon small @click="editItem(item)" color="#D6B331">
            mdi-pencil
          </v-icon>
          <v-icon small color="black" @click="deleteItem(item.id)">
            mdi-delete
          </v-icon>
        </div>
      </template>
    </v-data-table>
    <div class="text-center pt-2">
      <v-pagination v-model="page" :length="pagination" @input="next"></v-pagination>
    </div>
    <v-dialog v-model="dialogDelete" max-width="290">
      <v-card>
        <v-card-title class="headline"> Eliminar Orden </v-card-title>

        <v-card-text> ¿Estas seguro de eliminar esta <strong>orden</strong>? </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn color="green darken-1" text @click="closeDelete">
            Cancelar
          </v-btn>

          <v-btn color="green darken-1" text @click="deleteConfirm">
            Aceptar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
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
    idDelete: '',
    dialogDelete: false,
    page: 1,
    pageCount: 0,
    itemsPerPage: 15,
    pagination: null,
    stateO: [],
  }),
  methods: {
    getOrders() {
      axios
        .get('/api/v1/orders')
        .then(response => {
          console.log(response);
          this.orders = response.data.data;
          this.pagination = response.data.meta.last_page;
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
    deleteItem(id) {
      this.idDelete = id;
      (this.dialogDelete = true), console.log(this.idDelete);
    },
    deleteConfirm() {
      axios
        .delete(`/api/v1/orders/${this.idDelete}`)
        .then(response => {
          console.log(response);
          this.getOrders();
          this.dialogDelete = false;
        })
        .catch(error => {});
    },
    closeDelete() {
      this.dialogDelete = false;
    },
    next(page) {
      axios
        .get(`/api/v1/orders?page=${page}`)
        .then(response => {
          console.log(response);
          this.orders = response.data.data;
          this.pagination = response.data.meta.last_page;
        })
        .catch(error => {});
    },
    getStateOrder() {
      axios
        .get('/api/v1/state-orders')
        .then(response => {
          this.stateO = response.data;
        })
        .catch(error => {});
    },
  },
  mounted() {
    this.getOrders();
    this.getStateOrder();
  },
  filters: {
    currency: function(value) {
      return parseFloat(value).toFixed(2);
      moment(element.arrival_date).format('YYYY-MM-DD');
    },
    date: function(value) {
      return moment(value).format('YYYY-MM-DD');
    },
    porcent: function(value) {
      return parseFloat(value) * 100 + ' %';
    },
    stateOrder: function(value) {
      let resp = '';

      return value;
    },
  },
};
</script>
