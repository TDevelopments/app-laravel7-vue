<template>
  <div>
    <div class="d-flex my-3">
      <h3>Historial de Cambios</h3>
    </div>
    <v-data-table
      class="border"
      hide-default-footer
      disable-pagination
      :headers="headers"
      :items="history"
      no-data-text="No se encontraron datos"
    >
      <template v-slot:[`item.creation_date`]="{ item }">
        {{ item.creation_date | date }}
      </template>
      <template v-slot:[`item.actions`]="{ item }">
        <v-icon color="#D6B331" small class="mr-2" @click="editItem(item)">
          mdi-pencil
        </v-icon>
        <v-icon color="black" small @click="deleteItem(item)">
          mdi-delete
        </v-icon>
      </template>
    </v-data-table>
    <div class="text-center pt-2">
      <v-pagination v-model="page" :length="pagination" @input="next"></v-pagination>
    </div>
  </div>
</template>

<script>
import moment from 'moment';
export default {
  data: () => ({
    headers: [
      {
        text: 'Accion',
        value: 'action',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Usuario',
        value: 'user.name',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Fecha',
        value: 'creation_date',
        align: 'center',
        sortable: false,
      },
    ],
    history: [],
    page: 1,
    pageCount: 0,
    itemsPerPage: 15,
    pagination: null,
  }),
  methods: {
    getList() {
      axios
        .get('/api/v1/history')
        .then(response => {
          this.history = response.data.data;
          this.pagination = response.data.meta.last_page;
        })
        .catch(error => {});
    },
    next(page) {
      if (this.nameProduct == null) {
        this.nameProduct = '';
      }
      if (this.nameModel == null) {
        this.nameModel = '';
      }
      axios
        .get(`/api/v1/history?page=${page}`)
        .then(response => {
          this.history = response.data.data;
          this.pagination = response.data.meta.last_page;
          console.log(response);
        })
        .catch(error => {});
    },
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
  mounted() {
    this.getList();
  },
};
</script>
<style scoped>
.border {
  border: 1px solid #d2d6de;
}
</style>
