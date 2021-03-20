<template>
  <div>
    <v-data-table
      :headers="headers"
      :items="catalogues"
      :loading="loading"
      item-key="item.id"
      loading-text="Loading... Please wait"
      :page.sync="page"
      :items-per-page="itemsPerPage"
      hide-default-footer
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Catálogos</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>

          <v-btn color="#1B1B1B" dark @click="newCatalogue">
            Nuevo Catálogo
          </v-btn>

          <v-dialog v-model="dialogDelete" max-width="290">
            <v-card>
              <v-card-title class="headline"> Eliminar Catálogo </v-card-title>

              <v-card-text>
                ¿Estas seguro de eliminar este <strong>catálogo</strong>?
              </v-card-text>
              <v-card-text>
                Si lo eliminas, se borraran todos los productos que esten
                relacionados a este catálogo.
              </v-card-text>

              <v-card-actions>
                <v-spacer></v-spacer>

                <v-btn color="green darken-1" text @click="closeDelete">
                  Cancelar
                </v-btn>

                <v-btn color="green darken-1" text @click="deleteItemConfirm">
                  Aceptar
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>
      <template v-slot:[`item.minimum_investment`]="{ item }">
        {{ item.minimum_investment | currency }}
      </template>
      <template v-slot:[`item.quota_price`]="{ item }">
        {{ item.quota_price | currency }}
      </template>
      <template v-slot:[`item.quota_date`]="{ item }">
        {{ item.quota_date | date }}
      </template>
      <template v-slot:[`item.first_payment`]="{ item }">
        {{ item.first_payment }}
      </template>
      <template v-slot:[`item.date_first_payment`]="{ item }">
        {{ item.date_first_payment | date }}
      </template>
      <template v-slot:[`item.second_payment`]="{ item }">
        {{ item.second_payment }}
      </template>
      <template v-slot:[`item.date_second_payment`]="{ item }">
        {{ item.date_second_payment | date }}
      </template>
      <template v-slot:[`item.is_available`]="{ item }">
        {{ item.is_available == 1 ? "Si" : "No" }}
      </template>
      <template v-slot:[`item.arrivals`]="{ item }">
        <p v-for="(ar, index) in item.arrivals" :key="index">
          {{ ar.city }} {{ ar.arrival_date | date }}
        </p>
      </template>
      <template v-slot:[`item.actions`]="{ item }">
        <v-row>
          <v-col class="px-0">
            <ProductForCatalogue :idCatalogue="item.id" />
          </v-col>
          <v-col class="px-0">
            <v-icon small @click="editItem(item)" color="#D6B331">
              mdi-pencil
            </v-icon>
          </v-col>
          <v-col class="px-0">
            <v-icon small @click="deleteItem(item)" color="#FF0000">
              mdi-delete
            </v-icon>
          </v-col>
        </v-row>
      </template>
    </v-data-table>
    <div class="text-center pt-2">
      <v-pagination
        v-model="page"
        :length="pagination"
        @input="next"
      ></v-pagination>
    </div>
  </div>
</template>

<script>
import moment from "moment";
import ProductForCatalogue from "./ProductForCatalogue";

export default {
  components: {
    ProductForCatalogue,
  },
  data: () => ({
    dialogComponent: false,
    dialogDelete: false,
    loading: false,
    headers: [
      {
        text: "Nombre de Catálogo",
        value: "name",
        align: "center",
        sortable: false,
      },
      {
        text: "Inversión Mínima",
        value: "minimum_investment",
        align: "center",
        sortable: false,
      },
      {
        text: "Monto de Separación",
        value: "quota_price",
        align: "center",
        sortable: false,
      },
      {
        text: "Fecha Pago Monto de Separación",
        value: "quota_date",
        align: "center",
        sortable: false,
      },
      {
        text: "% Primer Pago",
        value: "first_payment",
        align: "center",
        sortable: false,
      },
      {
        text: "Fecha Primer Pago",
        value: "date_first_payment",
        align: "center",
        sortable: false,
      },
      {
        text: "% Segundo Pago",
        value: "second_payment",
        align: "center",
        sortable: false,
      },
      {
        text: "Fecha Segundo Pago",
        value: "date_second_payment",
        align: "center",
        sortable: false,
      },
      {
        text: "Tipo de Moneda",
        value: "coin",
        align: "center",
        sortable: false,
      },
      {
        text: "Fecha de Llegada",
        value: "arrivals",
        align: "center",
        sortable: false,
      },
      {
        text: "Disponible",
        value: "is_available",
        align: "center",
        sortable: false,
      },
      { text: "Acciones", value: "actions", sortable: false, align: "center" },
    ],
    catalogues: [],
    idDelete: null,
    page: 1,
    pageCount: 0,
    itemsPerPage: 15,
    pagination: null,
  }),
  methods: {
    getList() {
      axios
        .get("/api/v1/catalogues")
        .then((response) => {
          this.loading = false;
          this.catalogues = response.data.data;
          this.pagination = response.data.meta.last_page;
        })
        .catch((error) => {});
    },

    editItem(item) {
      this.$router.push({
        name: "editCatalogue",
        params: {
          id: item.id,
        },
      });
    },

    deleteItem(item) {
      this.dialogDelete = true;
      this.idDelete = item.id;
    },

    deleteItemConfirm() {
      axios
        .delete(`http://applaravel.test/api/v1/catalogues/${this.idDelete}`)
        .then((response) => {
          this.closeDelete();
          this.getList();
        })
        .catch((error) => {});
    },

    closeDelete() {
      this.dialogDelete = false;
    },
    newCatalogue() {
      this.$router.push({
        name: "addCatalogue",
      });
    },
    viewProduct() {
      this.dialogComponent = true;
    },
    next(page) {
      axios
        .get(`/api/v1/catalogues?page=${page}`)
        .then((response) => {
          this.loading = false;
          this.catalogues = response.data.data;
          this.pagination = response.data.meta.last_page;
          console.log(response);
        })
        .catch((error) => {});
    },
  },
  mounted() {
    this.getList();
  },

  filters: {
    currency: function (value) {
      return parseFloat(value).toFixed(2);
      moment(element.arrival_date).format("YYYY-MM-DD");
    },
    date: function (value) {
      return moment(value).format("YYYY-MM-DD");
    },
    porcent: function (value) {
      return parseFloat(value) * 100 + " %";
    },
  },
};
</script>
