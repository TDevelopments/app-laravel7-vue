<template>
  <div class="m-page">
    <v-col>
      <h2>{{ catalogue.name }}</h2>
      <v-divider></v-divider>
      <v-row>
        <v-col cols="12" sm="12" md="5" lg="5">
          <v-img
            contain
            src="https://ep01.epimg.net/elpais/imagenes/2020/11/30/escaparate/1606750893_769867_1606751114_noticia_normal_recorte1.jpg"
          />
        </v-col>
        <v-col cols="12" sm="12" md="7" lg="7">
          <v-card-title class="pt-0">
            Información y Condiciones
            <v-spacer></v-spacer>
            Moneda &nbsp;
            <v-avatar size="40" color="#0D52D6" class="text-white">{{
              catalogue.coin == "soles" ? "S./" : "$"
            }}</v-avatar>
          </v-card-title>
          <v-card-text class="font-weight-medium pb-0 pt-1">
            <v-icon color="black">mdi-unfold-more-vertical</v-icon>
            El monto para separar un <strong>cupo</strong> es de:
            <v-chip class="mr-2">
              <v-icon left> mdi-cash </v-icon>
              {{ catalogue.quota_price | currency }}
            </v-chip>
          </v-card-text>
          <v-card-text class="font-weight-medium pb-0 pt-1">
            <v-icon color="black">mdi-unfold-more-vertical</v-icon>
            El ultimo dia para separar un <strong>cupo</strong> es:
            <v-chip class="mr-2">
              <v-icon left> mdi-calendar-month </v-icon>
              {{ catalogue.quota_date | date }}
            </v-chip>
          </v-card-text>
          <v-card-text class="font-weight-medium pb-0 pt-1">
            <v-icon color="black">mdi-unfold-more-vertical</v-icon>
            El ultimo dia para pagar el monto de separación de un
            <strong>cupo</strong> es:
            <v-chip class="mr-2">
              <v-icon left> mdi-calendar-month </v-icon>
              {{ catalogue.quota_date | date }}
            </v-chip>
          </v-card-text>
          <v-card-text class="font-weight-medium pb-0 pt-1">
            <v-icon color="black">mdi-unfold-more-vertical</v-icon>
            El <strong>monto minimo</strong> de inversión es de:
            <v-chip class="mr-2">
              <v-icon left> mdi-cash </v-icon>
              {{ catalogue.minimum_investment | currency }}
            </v-chip>
          </v-card-text>
          <v-card-text class="font-weight-medium pb-0 pt-1">
            <v-icon color="black">mdi-unfold-more-vertical</v-icon>
            El porcentaje de la primera cuota es de:
            <v-chip class="mr-2">
              <v-icon left> mdi-percent </v-icon>
              {{ catalogue.first_payment * 100 }}
            </v-chip>
          </v-card-text>
          <v-card-text class="font-weight-medium pb-0 pt-1">
            <v-icon color="black">mdi-unfold-more-vertical</v-icon>
            El porcentaje de la segunda cuota es de:
            <v-chip class="mr-2">
              <v-icon left> mdi-percent </v-icon>
              {{ catalogue.second_payment * 100 }}
            </v-chip>
          </v-card-text>
          <v-card-text class="font-weight-medium pb-0 pt-1">
            <v-icon color="black">mdi-unfold-more-vertical</v-icon>
            La fecha limite para pagar la primera cuota es:
            <v-chip class="mr-2">
              <v-icon left> mdi-calendar-month </v-icon>
              {{ catalogue.date_first_payment | date }}
            </v-chip>
          </v-card-text>
          <v-card-text class="font-weight-medium pb-0 pt-1">
            <v-icon color="black">mdi-unfold-more-vertical</v-icon>
            La fecha limite para pagar la segunda cuota es:
            <v-chip class="mr-2">
              <v-icon left> mdi-calendar-month </v-icon>
              {{ catalogue.date_second_payment | date }}
            </v-chip>
          </v-card-text>
        </v-col>
      </v-row>
      <v-avatar></v-avatar>
      <v-data-table
        v-model="selected"
        :single-select="singleSelect"
        show-select
        :headers="headers"
        :items="catalogue.products"
        hide-default-footer
        class="elevation-1"
        @click:row="prueba"
      >
        <template v-slot:[`item.images`]="{ item }">
          <v-img
            v-if="item.images == null || item.images.length == 0"
            src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"
            max-width="150"
            contain
            class="m-1"
          />
          <v-img
            v-else
            contain
            :src="item.images[0].path"
            max-width="150"
            class="text-center align-center"
          />
        </template>
        <template v-slot:[`item.quantity`]="{ item }">
          <v-text-field
            class="m-3"
            solo
            dense
            append-outer-icon="mdi-plus"
            prepend-icon="mdi-minus"
            @click:append-outer="plusFunctionO(item)"
            @click:prepend="minusFunction(item)"
            readonly
            v-model="item.quantity"
            hide-details
            ></v-text-field>
        </template>
        <template v-slot:[`item.cart`]="{ item }">
          <v-row>
            <v-icon
              small
              class="mx-auto"
              color="#D6B331"
              @click="prueba"
            >
              mdi-cart
            </v-icon>
          </v-row>
        </template>
      </v-data-table>
      <div class="mx-auto">
        Probando
        <v-card>
          <p class="py-3 px-3">Resumen de mi pedido</p>
          <div v-for="catalogue in cart" :key="catalogue.id">
            <p class="py-3 px-3">{{ catalogue.name }}</p>
            <p class="py-3 px-3">
              Total:
            </p>
            <v-btn @click="generateOrderAction(catalogue)">
              Generar Orden
            </v-btn>
          </div>
        </v-card>
      </div>
      <Product v-model="showScheduleForm" :product="itemSelected" v-if="showScheduleForm"/>
    </v-col>
  </div>
</template>
<script>
import Product from "./product";
import { mapActions, mapGetters } from "vuex";
import moment from "moment";

export default {
  comments:{
    Product
  },
  data: () => ({
    itemSelected: null,
    showScheduleForm: false,
    singleSelect: false,
    selected: [],
    description: [],
    headers: [
      { text: "Imagen", value: "images", align: "center", sortable: false },
      {
        text: "Modelo",
        value: "model",
        align: "center",
        sortable: false,
      },
      {
        text: "Marca",
        value: "brand",
        align: "center",
        sortable: false,
      },
      {
        text: "Precio unitario(A)",
        value: "price_unit",
        align: "center",
        sortable: false,
      },
      {
        text: "Cantidad Mínima de Pedido(B)",
        value: "quantity_group",
        align: "center",
        sortable: false,
      },
      {
        text: "Precio Total por Cantidad Mínima(AxB)",
        value: "price_group",
        align: "center",
        sortable: false,
      },
      {
        text: "Unidad Medida",
        value: "type_group",
        align: "center",
        sortable: false,
      },
      {
        text: "Cantidad de Pedido",
        value: "quantity",
        align: "center",
        sortable: false,
      },
      { text: "Carrito", value: "cart", sortable: false, align: "center" },
    ],
  }),
  components: {
    Product,
  },
  computed: {
    ...mapGetters("groupImport", ["catalogue", "cart"]),
  },
  methods: {
    ...mapActions("groupImport", ["getCatalogue", "addCart"]),
    minusFunction(item) {
      // this.product.quantity--;
      let productId = item.id;
      this.catalogue.products.forEach(product => {
        if (product.id === productId)
        {
          product.quantity--;
        }
      });
    },
    plusFunctionO(item) {
      // this.product.quantity++;
      console.log("test", item);
      item.quantity++;
    },
    reserve() {
      this.loading = true;
      setTimeout(() => (this.loading = false), 2000);
    },
    prueba(value){
      this.itemSelected = value;
      this.showScheduleForm = true;
      console.log(this.itemSelected);
    }
  },
  mounted() {
    this.getCatalogue(this.$route.params.id);
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
<style scoped>
.m-page {
  margin-right: 10%;
  margin-left: 10%;
}
.p-page {
  padding-right: 10%;
  padding-left: 10%;
}
@media (max-width: 360px) {
  .m-page {
    margin-right: auto;
    margin-left: auto;
  }
}
@media (max-width: 500px) {
  .m-page {
    margin-right: auto;
    margin-left: auto;
  }
}
@media (max-width: 1200px) {
  .m-page {
    margin-right: 0;
    margin-left: 0;
  }
  .p-page {
    padding-right: 0;
    padding-left: 0;
  }
}
</style>
