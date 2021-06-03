<template>
  <div>
    <div>
      <h3>Filtros</h3>
      <v-row>
        <v-col>
          Numero de Orden
          <v-text-field
            class="border"
            flat
            hide-details
            solo
            dense
            append-icon="mdi-magnify"
            v-model="numberOrder"
            ref="nomCli"
          ></v-text-field>
        </v-col>
        <v-col>
          Nombre de Cliente
          <v-text-field
            class="border"
            flat
            hide-details
            solo
            dense
            append-icon="mdi-magnify"
            v-model="nameClient"
          ></v-text-field>
        </v-col>
        <v-col>
          Estado
          <v-select
            hide-details
            flat
            class="border"
            solo
            dense
            v-model="nameState"
            :items="states"
            item-text="name"
            item-value="name"
            append-icon="mdi-magnify"
            no-data-text="No hay se encontraron datos"
          ></v-select>
        </v-col>
        <v-col>
          Catalogo
          <v-select
            hide-details
            flat
            class="border"
            solo
            dense
            v-model="idCatalogue"
            :items="catalogues"
            item-text="name"
            item-value="id"
            append-icon="mdi-magnify"
            no-data-text="No hay se encontraron datos"
          ></v-select>
        </v-col>
        <v-col class="text-center align-center justify-center px-0 d-flex">
          <v-btn small @click="getOrders" class="mx-1" color="#0D52D6" dark>
            Buscar
          </v-btn>
          <v-btn small @click="clear" class="mx-1">
            Limpiar
          </v-btn>
        </v-col>
      </v-row>
    </div>
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
  </div>
</template>
<script>
import axios from 'axios';

export default {
  data: () => ({
    orders: [],
    headers: [
      {
        text: 'Nro Orden',
        value: 'OrderId',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Creado por',
        value: 'CreatedBy.name',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Cliente',
        value: 'Customer.FullName',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Orden',
        value: 'StateOrder.Name',
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
    numberOrder: '',
    nameClient: '',
    nameState: '',
    states: [],
    idCatalogue: '',
    catalogues: [],
  }),
  methods: {
    // `/api/v1/sale-orders?orderId=${this.numberOrder}&username=${this.nameClient}&stateOrder=${this.nameState}&catalogueId=${this.idCatalogue}`

    getOrders() {
      axios
        .get(`/api/v1/sale-orders`)
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
        .delete(`/api/v1/sale-orders/${this.idDelete}`)
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
        .get(
          `/api/v1/sale-orders?orderId=${this.numberOrder}&username=${this.nameClient}&stateOrder=${this.nameState}&catalogueId=${this.idCatalogue}&page=${page}`
        )
        .then(response => {
          console.log(response);
          this.orders = response.data.data;
          this.pagination = response.data.meta.last_page;
        })
        .catch(error => {});
    },
    // getStateOrder() {
    //   axios
    //     .get('/api/v1/state-orders')
    //     .then(response => {
    //       this.states = response.data;
    //       console.log(response.data);
    //     })
    //     .catch(error => {});
    // },
    // getCatalogue() {
    //   axios
    //     .get('/api/v1/catalogues')
    //     .then(response => {
    //       console.log(response.data);
    //       this.catalogues = response.data.data;
    //     })
    //     .catch(error => {});
    // },
    clear() {
      this.numberOrder = '';
      this.nameClient = '';
      this.nameState = '';
      this.idCatalogue = '';
      this.getOrders();
    },
  },
  mounted() {
    this.getOrders();
    // this.getStateOrder();
    // this.getCatalogue();
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
