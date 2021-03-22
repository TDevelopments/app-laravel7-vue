<template>
  <div class="m-page">
    <v-col class="mt-5">
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
          <v-card-title>
            <v-row>
              <v-col cols="12">
                Información y Condiciones &nbsp;<strong
                  >{{ catalogue.name }}
                </strong>
                <v-spacer></v-spacer>
              </v-col>
              <v-col cols="12">
                Moneda &nbsp;
                <v-avatar size="40" color="#0D52D6" class="text-white">{{
                  catalogue.coin == "soles" ? "S./" : "$"
                }}</v-avatar>
              </v-col>
            </v-row>
          </v-card-title>
          <v-card-text class="font-weight-medium pb-0 pt-1">
            <v-row>
              <v-col cols="12" sm="8">
                <v-icon color="black">mdi-unfold-more-vertical</v-icon>
                Monto de separación de cupo:
              </v-col>
              <v-col cols="12" sm="4" class="text-right">
                <v-chip class="mr-2">
                  <v-icon left> mdi-cash </v-icon>
                  {{ catalogue.quota_price | currency }}
                </v-chip>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-text class="font-weight-medium pb-0 pt-1">
            <v-row>
              <v-col cols="12" sm="8">
                <v-icon color="black">mdi-unfold-more-vertical</v-icon>
                Ultimo día para la separación de cupo:
              </v-col>
              <v-col cols="12" sm="4" class="text-right">
                <v-chip class="mr-2">
                  <v-icon left> mdi-calendar-month </v-icon>
                  {{ catalogue.quota_date | date }}
                </v-chip>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-text class="font-weight-medium pb-0 pt-1">
            <v-row>
              <v-col cols="12" sm="8">
                <v-icon color="black">mdi-unfold-more-vertical</v-icon>
                Inversión minima:
              </v-col>
              <v-col cols="12" sm="4" class="text-right">
                <v-chip class="mr-2">
                  <v-icon left> mdi-cash </v-icon>
                  {{ catalogue.minimum_investment | currency }}
                </v-chip>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-text class="font-weight-medium pb-0 pt-1">
            <v-row>
              <v-col cols="12" sm="8">
                <v-icon color="black">mdi-unfold-more-vertical</v-icon> % de
                Primera cuota:
              </v-col>
              <v-col cols="12" sm="4" class="text-right">
                <v-chip class="mr-2">
                  <v-icon left> mdi-percent </v-icon>
                  {{ catalogue.first_payment }}
                </v-chip>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-text class="font-weight-medium pb-0 pt-1">
            <v-row>
              <v-col cols="12" sm="8">
                <v-icon color="black">mdi-unfold-more-vertical</v-icon> % de
                Segunda cuota:
              </v-col>
              <v-col cols="12" sm="4" class="text-right">
                <v-chip class="mr-2">
                  <v-icon left> mdi-percent </v-icon>
                  {{ catalogue.second_payment }}
                </v-chip>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-text class="font-weight-medium pb-0 pt-1">
            <v-row>
              <v-col cols="12" sm="8">
                <v-icon color="black">mdi-unfold-more-vertical</v-icon>
                Fecha limite para el pago de la primera cuota:
              </v-col>
              <v-col cols="12" sm="4" class="text-right">
                <v-chip class="mr-2">
                  <v-icon left> mdi-calendar-month </v-icon>
                  {{ catalogue.date_first_payment | date }}
                </v-chip>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-text class="font-weight-medium pb-0 pt-1">
            <v-row>
              <v-col cols="12" sm="8">
                <v-icon color="black">mdi-unfold-more-vertical</v-icon>
                Fecha Limite Segunda Cuota:
              </v-col>
              <v-col cols="12" sm="4" class="text-right">
                <v-chip class="mr-2">
                  <v-icon left> mdi-calendar-month </v-icon>
                  {{ catalogue.date_second_payment | date }}
                </v-chip>
              </v-col>
            </v-row>
          </v-card-text>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="12" sm="12" md="9" lg="9">
          <v-tabs
            fixed-tabs
            background-color="#546E7A"
            v-model="currentTab"
            dark
            show-arrows
          >
            <v-tab v-if="catalogue.products.length != 0">
              Productos por conjunto
            </v-tab>
            <v-tab v-if="catalogue.productRanges.length != 0">
              Productos por rango
            </v-tab>
          </v-tabs>
          <v-tabs-items v-model="currentTab">
            <v-tab-item>
              <v-data-table
                v-model="selected"
                :single-select="singleSelect"
                show-select
                :headers="headers"
                :items="catalogue.products"
                hide-default-footer
                class="elevation-1 mouse"
                @click:row="prueba"
                disable-pagination
                v-if="catalogue.products.length != 0"
              >
                <template v-slot:top>
                  <v-toolbar flat>
                    <v-toolbar-title>Productos</v-toolbar-title>
                  </v-toolbar>
                </template>
                <template v-slot:headers>
                  <tr>
                    HOla Mundo
                  </tr>
                </template>
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
                    :src="baseURL + item.images[0].path"
                    max-width="150"
                    class="text-center align-center"
                  />
                </template>
                <template v-slot:[`item.quantity_group`]="{ item }">
                  {{ item.quantity_group + " " }}
                  <br />
                  {{
                    item.type_group == "units"
                      ? "unidades"
                      : item.quantity_group == 1
                      ? "caja"
                      : "cajas"
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
            </v-tab-item>
            <v-tab-item>
              <v-data-table
                v-model="selectedRange"
                :single-select="singleSelectRange"
                show-select
                :headers="headersItem"
                :items="catalogue.productRanges"
                hide-default-footer
                disable-pagination
                class="elevation-1 mt-3"
                @click:row="prueba"
                v-if="catalogue.productRanges.length != 0"
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
                    :src="baseURL + item.images[0].path"
                    max-width="150"
                    class="text-center align-center"
                  />
                </template>
                <template v-slot:[`item.ranges`]="{ item, index }">
                  <div v-for="range in item.ranges" :key="range.id">
                    <v-icon>mdi-unfold-more-vertical</v-icon> De
                    {{ range.min }} a {{ range.max }} el precio es
                    {{ range.price }}
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
                    v-model="item.quantity"
                    hide-details
                  ></v-text-field>
                </template>
              </v-data-table>
            </v-tab-item>
          </v-tabs-items>
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
              v-for="(product, index) in selected"
              :key="'A' + index"
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
                    :src="baseURL + product.images[0].path"
                    max-width="75"
                    height="50"
                    class="text-center align-center"
                  />
                </v-col>
                <v-col cols="8">
                  Modelo:{{ product.model }}
                  <br />
                  Pago:{{ catalogue.coin == "soles" ? "S/." : "$"
                  }}{{ (product.quantity * product.price_unit) | currency }}
                  <br />
                  Cantidad
                  {{
                    product.quantity +
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

            <v-card-text
              v-for="(productRange, index) in selectedRange"
              :key="index"
              class="py-0"
            >
              <v-row>
                <v-col cols="4">
                  <v-img
                    v-if="
                      productRange.images == null ||
                      productRange.images.length == 0
                    "
                    src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"
                    max-width="75"
                    height="50"
                    contain
                    class="m-1"
                  />
                  <v-img
                    v-else
                    contain
                    :src="baseURL + productRange.images[0].path"
                    max-width="75"
                    height="50"
                    class="text-center align-center"
                  />
                </v-col>
                <v-col cols="8">
                  Modelo:{{ productRange.model }}
                  <br />
                  Pago:{{ catalogue.coin == "soles" ? "S/." : "$" }}
                  {{ productRange.total }}
                  <br />
                  Cantidad
                  {{
                    productRange.quantity +
                    " " +
                    (productRange.quantity == 1 ? "Unidad" : "Unidades")
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
            <v-row class="text-right mx-2">
              <v-spacer></v-spacer>
              <v-col class="text-subtitle-1"
                >Total: {{ totalRange | currency }}</v-col
              >
            </v-row>
            <v-row class="text-right mx-2">
              <v-spacer></v-spacer>
              <v-col class="text-subtitle-1"
                >Total: {{ totalGeneral | currency }}</v-col
              >
            </v-row>
            <br />
            <v-btn
              @click="
                generateOrder({
                  id: catalogue.id,
                  products: selected,
                  product_ranges: selectedRange,
                })
              "
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
    baseURL: "",
    totalItems: 0,
    itemSelected: null,
    showScheduleForm: false,
    singleSelect: false,
    selected: [],
    singleSelectRange: false,
    selectedRange: [],
    description: [],
    number: 1,
    currentTab: 0,
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
    catalogueGet: null,
  }),
  components: {
    Product,
  },
  computed: {
    ...mapGetters("groupImport", ["catalogue", "cart"]),

    total() {
      let t = 0;
      this.selected.forEach((element) => {
        t += element.quantity * element.price_unit;
      });
      this.totalItems += t;
      return t;
    },

    validate() {
      if (this.totalItems < this.catalogue.minimum_investment) {
        return true;
      } else {
        return false;
      }
    },

    totalRange() {
      let t = 0;
      let q = 0;
      let p = 0;
      let tot = 0;
      this.selectedRange.forEach((element) => {
        q = element.quantity;
        if (element.ranges.length != 0) {
          element.ranges.forEach((range) => {
            if ((q >= range.min) & (q <= range.max)) {
              t = range.price * q;
            }
            p = range.price;
            console.log(range.price);
          });
        }

        element.total = t;

        if (element.total == 0) {
          element.total = p * element.quantity;
        }

        tot += element.total;
      });
      return tot;
    },

    totalGeneral() {
      let t = this.total + this.totalRange;
      return t;
    },
  },
  methods: {
    ...mapActions("groupImport", ["removeCart"]),
    ...mapActions("groupImport", [
      "getCatalogue",
      "addCart",
      "setCart",
      "generateOrder",
    ]),
    minusFunction(item, index) {
      if (item.quantity <= item.quantity_group) {
        alert(
          `Lo sentimos, la candidad minima de de compra de este producto es ${item.quantity_group}`
        );
      } else {
        this.catalogue.products[index].quantity--;
      }
    },
    plusFunctionO(index) {
      console.log(this.catalogue.products[index]);
      this.catalogue.products[index].quantity++;
    },

    minusFunctionR(item, index) {
      if (item.quantity <= item.min) {
        alert(
          `Lo sentimos, la candidad minima de de compra de este producto es ${item.min}`
        );
      } else {
        this.catalogue.productRanges[index].quantity--;
      }
    },
    plusFunctionR(index) {
      console.log(this.catalogue.productRanges[index]);
      this.catalogue.productRanges[index].quantity++;
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
    mas() {
      this.catalogue.productRanges[1].quantity++;
      console.log(this.catalogue.productRanges[1].quantity);
    },
  },
  mounted() {
    this.getCatalogue(this.$route.params.id);
    console.log("Imbesil", process.env.MIX_NODE_URL);
    this.baseURL = process.env.MIX_NODE_URL;
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
.mouse {
  cursor: pointer;
}
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
