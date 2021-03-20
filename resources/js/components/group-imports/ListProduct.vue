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
      <v-row>
        <v-col cols="12" sm="12" md="9" lg="9">
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
              {{
                item.quantity +
                " " +
                (item.type_group == "units"
                  ? "unidades"
                  : item.quantity == 1
                  ? "caja"
                  : "cajas")
              }}
            </template>
            <template v-slot:[`item.quantity_order`]="{ item, index }">
              <v-text-field
                class="m-3"
                solo
                dense
                append-outer-icon="mdi-plus"
                prepend-icon="mdi-minus"
                @click:append-outer="plusFunctionO(index)"
                @click:prepend="minusFunction(item, index)"
                readonly
                v-model="item.quantity_group"
                hide-details
              ></v-text-field>
            </template>
            <template v-slot:[`item.cart`]="{ item }">
              <v-row>
                <v-icon small class="mx-auto" color="#D6B331" @click="prueba">
                  mdi-cart
                </v-icon>
              </v-row>
            </template>
          </v-data-table>
          <v-data-table
            v-model="selectedRange"
            :single-select="singleSelectRange"
            show-select
            :headers="headersItem"
            :items="catalogue.productRanges"
            hide-default-footer
            class="elevation-1 mt-3"
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
            <template v-slot:[`item.ranges`]="{ item, index }">
              <div v-for="range in item.ranges" :key="range.id">
                <v-icon>mdi-unfold-more-vertical</v-icon> De {{ range.min }} a
                {{ range.max }} el precio es {{ range.price }}
              </div>
            </template>
            <template v-slot:[`item.quantity_order`]="{ item, index }">
              <v-text-field
                class="m-3"
                solo
                dense
                append-outer-icon="mdi-plus"
                prepend-icon="mdi-minus"
                @click:append-outer="plusFunctionR(index)"
                @click:prepend="minusFunctionR(item, index)"
                readonly
                hide-details
              ></v-text-field>
            </template>
          </v-data-table>
        </v-col>
        <v-col cols="12" sm="12" md="3" lg="3">
          <v-card>
            <p class="py-3 px-3 text-h6">Resumen de mi pedido</p>
            <p class="pb-3 px-3 text-subtitle-1">
              Minima Inversión:
              <strong>
                {{ (catalogue.coin == "soles" ? "S/." : "$") + " " }}
                {{ catalogue.minimum_investment | currency }}
              </strong>
            </p>
            <v-divider></v-divider>
            <v-card-text
              v-for="product in selected"
              :key="product.id"
              class="py-0"
            >
              <v-row>
                <v-col cols="4">
                  <v-img
                    v-if="product.images == null || product.images.length == 0"
                    src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"
                    max-width="75"
                    height="50"
                    contain
                    class="m-1"
                  />
                  <v-img
                    v-else
                    contain
                    :src="product.images[0].path"
                    max-width="75"
                    height="50"
                    class="text-center align-center"
                  />
                </v-col>
                <v-col cols="8">
                  Modelo:{{ product.model }}
                  <br />
                  Pago:{{ catalogue.coin == "soles" ? "S/." : "$"
                  }}{{
                    (product.quantity_group * product.price_unit) | currency
                  }}
                  <br />
                  Cantidad
                  {{
                    product.quantity_group +
                    " " +
                    (product.type_group == "units"
                      ? "unidades"
                      : product.quantity == 1
                      ? "caja"
                      : "cajas")
                  }}
                  <br />
                </v-col>
              </v-row>
            </v-card-text>
            <v-row class="text-right mx-2">
              <v-spacer></v-spacer>
              <v-col class="text-subtitle-1"
                >Total: {{ total | currency }}</v-col
              >
            </v-row>
            <br />
            <v-btn
              @click="generateOrderAction(catalogue)"
              class="mt-3"
              :disabled="validate"
            >
              Generar Orden
            </v-btn>
          </v-card>
        </v-col>
      </v-row>

      <Product
        v-model="showScheduleForm"
        :product="itemSelected"
        v-if="showScheduleForm"
        :catalogue="catalogue"
      />
    </v-col>
  </div>
</template>
<script>
import Product from "./product";
import { mapActions, mapGetters } from "vuex";
import moment from "moment";

export default {
  comments: {
    Product,
  },
  data: () => ({
    totalItems: 0,
    itemSelected: null,
    showScheduleForm: false,
    singleSelect: false,
    selected: [],
    singleSelectRange: false,
    selectedRange: [],
    description: [],
    number: 1,
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
        value: "quantity",
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
        text: "Cantidad de Pedido",
        value: "quantity_order",
        align: "center",
        sortable: false,
      },
    ],
    headersItem: [
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
        text: "Precio por cantidad de Pedido",
        value: "ranges",
        align: "center",
        sortable: false,
      },
      {
        text: "Cantidad de Pedido",
        value: "quantity_order",
        align: "center",
        sortable: false,
      },
    ],
  }),
  components: {
    Product,
  },
  computed: {
    ...mapGetters("groupImport", ["catalogue", "cart"]),
    total() {
      let t = 0;
      this.selected.forEach((element) => {
        t += element.quantity_group * element.price_unit;
      });
      this.totalItems = t;
      return t;
    },
    validate() {
      if (this.totalItems < this.catalogue.minimum_investment) {
        return true;
      } else {
        return false;
      }
    },
  },
  methods: {
    ...mapActions("groupImport", ["getCatalogue", "addCart"]),
    minusFunction(item, index) {
      if (item.quantity_group <= item.quantity) {
        alert(
          `Lo sentimos, la candidad minima de de compra de este producto es ${item.quantity}`
        );
      } else {
        this.catalogue.products[index].quantity_group--;
      }
    },
    plusFunctionO(index) {
      console.log(this.catalogue.products[index]);
      this.catalogue.products[index].quantity_group++;
    },

    minusFunctionR(item, index) {
      if (item.quantity <= 1) {
        alert(
          `Lo sentimos, la candidad minima de de compra de este producto es ${item.quantity}`
        );
      } else {
        this.catalogue.productRanges[index].quantity--;
      }
    },
    plusFunctionR(index) {
      console.log(this.catalogue.productRanges[index]);
      this.catalogue.productRanges[index].quantity = 0
      ;
    },

    reserve() {
      this.loading = true;
      setTimeout(() => (this.loading = false), 2000);
    },
    prueba(value) {
      this.itemSelected = value;
      this.showScheduleForm = true;
      console.log(this.itemSelected);
    },
  },
  mounted() {
    this.getCatalogue(this.$route.params.id);
  },
  filters: {
    currency: function (value) {
      return parseFloat(value).toFixed(2);
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
