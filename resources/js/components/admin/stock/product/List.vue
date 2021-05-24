<template>
  <div>
    <div>
      <h3>Filtros</h3>
      <v-row>
        <v-col>
          Nombre Producto
          <v-text-field
            class="border"
            flat
            hide-details
            solo
            dense
            append-icon="mdi-magnify"
            v-model="nameProduct"
            ref="nomCli"
          ></v-text-field>
        </v-col>
        <v-col class="text-center align-center justify-center px-0 d-flex">
          <v-btn small @click="search" class="mx-1" color="#0D52D6" dark> Buscar </v-btn>
          <v-btn small @click="clear" class="mx-1"> Limpiar </v-btn>
        </v-col>
      </v-row>
    </div>
    <v-divider></v-divider>
    <div class="d-flex my-3">
      <h3>Productos</h3>
      <v-spacer></v-spacer>
      <v-btn @click="newItem" small>
        Nuevo Producto
      </v-btn>
    </div>
    <v-data-table
      class="border"
      disable-pagination
      hide-default-footer
      show-expand
      :expanded.sync="expanded"
      single-expand
      no-data-text="No se encontraron datos"
      :headers="headers"
      :items="prodc"
    >
      <template v-slot:expanded-item="{ headers, item }">
        <td :colspan="headers.length" class="p-0">
          <v-data-table
            v-if="item.StockRecords != null"
            :headers="headersStock"
            :items="item.StockRecords"
            disable-pagination
            hide-default-footer
          >
            <template v-slot:[`item.actions`]="{ item }">
              <div>
                <div v-if="item.Customer != null">
                  {{ item.Customer.FullName }}
                </div>
                <div v-if="item.Customer == null">
                  No se Encontro un Cliente
                </div>
              </div>
            </template>
          </v-data-table>
          <div v-else>
            No se entontraron datos
          </div>
        </td>
      </template>
      <template v-slot:[`item.image`]="{ item }">
        <div>
          <div v-if="item.Picture.length != 0 && item.Picture != null">
            <v-img max-height="150" max-width="250" :src="item.Picture[0].PicturePath"></v-img>
          </div>

          <div v-else>
            <v-img
              lazy-src="https://picsum.photos/id/11/10/6"
              max-height="150"
              max-width="250"
              src="/images/image-not-found.png"
            ></v-img>
          </div>
        </div>
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
export default {
  data: () => ({
    prodc: [],
    expanded: [],
    headers: [
      {
        text: 'Imagen',
        value: 'image',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Nombre del Producto',
        value: 'ProductName',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Precio Unitario',
        value: 'UnitPrice',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Precio de Venta',
        value: 'SellingPrice',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Stock',
        value: 'Stock',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Acciones',
        value: 'actions',
        align: 'center',
        sortable: false,
      },
    ],
    headersStock: [
      {
        text: 'Almacen',
        value: 'BusinessLocation.Name',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Estado',
        value: 'ProductStatus.StatusName',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Cantidad',
        value: 'Quantity',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Cliente',
        value: 'Customer.FullName',
        align: 'center',
        sortable: false,
      },
    ],
    nameProduct: '',
    nameModel: '',
    page: 1,
    pageCount: 0,
    itemsPerPage: 15,
    pagination: null,
  }),
  methods: {
    getList() {
      if (this.nameProduct == null) {
        this.nameProduct = '';
      }
      if (this.nameModel == null) {
        this.nameModel = '';
      }
      axios
        .get('/api/v1/sale-products')
        .then(response => {
          this.prodc = response.data.data;
          this.pagination = response.data.meta.last_page;
          console.log(response);
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
        .get(`/api/v1/sale-products?Search=${this.nameProduct}&page=${page}`)
        .then(response => {
          this.loading = false;
          this.prodc = response.data.data;
          this.pagination = response.data.meta.last_page;
          console.log(response);
        })
        .catch(error => {});
    },
    editItem(item) {
      this.$router.push({
        name: 'editStockProduct',
        params: {
          id: item.id,
        },
      });
    },
    newItem() {
      this.$router.push({
        name: 'addStockProduct',
      });
    },
    search() {
      if (this.page != 1) {
        this.page = 1;
      }
      if (this.nameProduct == null) {
        this.nameProduct = '';
      }
      if (this.nameModel == null) {
        this.nameModel = '';
      }
      axios
        .get(`/api/v1/sale-products?Search=${this.nameProduct}&page=${this.page}`)
        .then(response => {
          this.loading = false;
          this.prodc = response.data.data;
          this.pagination = response.data.meta.last_page;
          console.log(response);
        })
        .catch(error => {});
    },
    clear() {
      this.nameProduct = '';
      this.nameModel = '';
      this.getList();
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
