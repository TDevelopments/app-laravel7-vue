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
            v-if="catalogue.image == null || catalogue.image.length == 0"
            height="400"
          />
          <v-img
            v-else
            contain
            :src="catalogue.image.path"
            class="text-center align-center"
            height="400"
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
              <v-col cols="12" class="text-capitalize">
                Moneda &nbsp; {{ catalogue.coin }}
              </v-col>
            </v-row>
          </v-card-title>
          <v-card-text class="font-weight-medium pb-0 pt-1">
            <v-row>
              <v-col sm="6" md="8">
                <v-icon color="black" x-small>mdi-circle</v-icon>
                Monto de separación de cupo:
              </v-col>
              <v-col sm="6" md="4" class="text-right">
                <v-chip class="mr-2">
                  {{ catalogue.coin == "soles" ? "S./" : "$" }}
                  {{ catalogue.quota_price | currency }}
                </v-chip>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-text class="font-weight-medium pb-0 pt-1">
            <v-row>
              <v-col sm="6" md="8">
                <v-icon color="black" x-small>mdi-circle</v-icon>
                Inversión minima:
              </v-col>
              <v-col sm="6" md="4" class="text-right">
                <v-chip class="mr-2">
                  {{ catalogue.coin == "soles" ? "S./" : "$" }}
                  {{ catalogue.minimum_investment | currency }}
                </v-chip>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-text class="font-weight-medium pb-0 pt-1">
            <v-row>
              <v-col sm="6" md="8">
                <v-icon color="black" x-small>mdi-circle</v-icon> % de Primera
                cuota:
              </v-col>
              <v-col sm="6" md="4" class="text-right">
                <v-chip class="mr-2">
                  <v-icon left> mdi-percent </v-icon>
                  {{ catalogue.first_payment }}
                </v-chip>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-text class="font-weight-medium pb-0 pt-1">
            <v-row>
              <v-col sm="6" md="8">
                <v-icon color="black" x-small>mdi-circle</v-icon> % de Segunda
                cuota:
              </v-col>
              <v-col sm="6" md="4" class="text-right">
                <v-chip class="mr-2">
                  <v-icon left> mdi-percent </v-icon>
                  {{ catalogue.second_payment }}
                </v-chip>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-text class="font-weight-medium pb-0 pt-1">
            <v-row>
              <v-col sm="6" md="8">
                <v-icon color="black" x-small>mdi-circle</v-icon>
                Ultimo día para la separación de cupo:
              </v-col>
              <v-col sm="6" md="4" class="text-right">
                <v-chip class="mr-2">
                  <v-icon left> mdi-calendar-month </v-icon>
                  {{ catalogue.quota_date | date }}
                </v-chip>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-text class="font-weight-medium pb-0 pt-1">
            <v-row>
              <v-col sm="6" md="8">
                <v-icon color="black" x-small>mdi-circle</v-icon>
                Fecha limite para el pago de la primera cuota:
              </v-col>
              <v-col sm="6" md="4" class="text-right">
                <v-chip class="mr-2">
                  <v-icon left> mdi-calendar-month </v-icon>
                  {{ catalogue.date_first_payment | date }}
                </v-chip>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-text class="font-weight-medium pb-0 pt-1">
            <v-row>
              <v-col sm="6" md="8">
                <v-icon color="black" x-small>mdi-circle</v-icon>
                Fecha limite para el pago de la segunda cuota:
              </v-col>
              <v-col sm="6" md="4" class="text-right">
                <v-chip class="mr-2">
                  <v-icon left> mdi-calendar-month </v-icon>
                  {{ catalogue.date_second_payment | date }}
                </v-chip>
              </v-col>
            </v-row>
          </v-card-text>
        </v-col>
      </v-row>
      <v-col class="px-0 content-card pt-0 mt-5">
        <v-toolbar color="black" class="px-0 text-h6" dark flat
          >Terminos y condiciones</v-toolbar
        >
        <v-card-text
          v-for="(element, index) in catalogue.conditions"
          :key="index"
          class="pb-0 pt-1"
        >
          <v-icon color="black" x-small>mdi-circle</v-icon>
          {{ element }}
        </v-card-text>
      </v-col>
      <v-row class="mt-5">
        <v-col cols="12" sm="12" md="9" lg="9">
          <v-tabs
            fixed-tabs
            background-color="#546E7A"
            v-model="currentTab"
            dark
            show-arrows=""
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
                class="elevation-1 hidden-xs-only p-page"
                disable-pagination
                v-if="catalogue.products.length != 0"
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
                <template v-slot:[`item.quantity_group`]="{ item }">
                  {{ item.quantity_group + " " }}
                  <br />
                  {{ item.type_group }}
                </template>
                <template v-slot:[`item.quantity_order`]="{ item, index }">
                  <v-row>
                    <v-btn
                      @click="minusFunction(item, index)"
                      color="secondary"
                      fab
                      x-small
                      elevation="1"
                    >
                      <v-icon>mdi-minus</v-icon>
                    </v-btn>
                    <input
                      type="text"
                      class="w mx-2"
                      v-model="item.quantity"
                    />

                    <v-btn
                      @click="plusFunctionO(index)"
                      color="secondary"
                      fab
                      elevation="1"
                      x-small
                    >
                      <v-icon>mdi-plus</v-icon>
                    </v-btn>
                  </v-row>
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
              <v-data-table
                v-model="selected"
                :single-select="singleSelect"
                :headers="headers"
                :items="catalogue.products"
                hide-default-footer
                hide-default-header
                class="elevation-1 hidden-sm-and-up"
                disable-pagination
                v-if="catalogue.products.length != 0"
              >
                <template v-slot:item="props">
                  <tr class="mt-5">
                    <td class="px-0">
                      <v-checkbox
                        :input-value="props.isSelected"
                        @change="props.select($event)"
                      ></v-checkbox>
                      <v-img
                        v-if="
                          props.item.images == null ||
                          props.item.images.length == 0
                        "
                        src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"
                        max-width="100"
                        max-height="75"
                        contain
                        class="m-1"
                      />
                      <v-img
                        v-else
                        contain
                        :src="props.item.images[0].path"
                        max-width="100"
                        max-height="75"
                        class="text-center align-center"
                      />
                    </td>
                    <td class="px-0 py-5">
                      <strong>Modelo:</strong> {{ props.item.model }}
                      <br />
                      <strong>Marca:</strong> {{ props.item.brand }}
                      <br />
                      <strong>P.U:</strong> {{ props.item.price_unit }}
                      <br />
                      <strong>Cant.Min:</strong> {{ props.item.quantity_group }}
                      <br />
                      <strong>Total:</strong> {{ props.item.price_group }}
                    </td>
                    <td class="px-0 py-5">
                      <v-btn small class="my-5" @click="prueba(props.item)"
                        >Ver Mas</v-btn
                      >
                      <br />
                      <v-row class="mx-auto my-2">
                        <v-btn
                          @click="minusFunction(props.item, props.index)"
                          color="#000"
                          icon
                          x-small
                          elevation="1"
                        >
                          <v-icon>mdi-minus</v-icon>
                        </v-btn>
                        <input
                          type="text"
                          class="w mx-2"
                          v-model="props.item.quantity"
                        />
                        <v-btn
                          @click="plusFunctionO(props.index)"
                          color="#000"
                          icon
                          elevation="1"
                          x-small
                        >
                          <v-icon>mdi-plus</v-icon>
                        </v-btn>
                      </v-row>
                    </td>
                  </tr>
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
                    :src="item.images[0].path"
                    max-width="150"
                    class="text-center align-center"
                  />
                </template>
                <template v-slot:[`item.ranges`]="{ item, index }">
                  <div v-for="range in item.ranges" :key="range.id">
                    <v-icon x-small>mdi-circle</v-icon> De {{ range.min }} a
                    {{ range.max }} el precio es
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
                    v-model="item.quantity"
                    hide-details
                  ></v-text-field>
                </template>
              </v-data-table>
            </v-tab-item>
          </v-tabs-items>
        </v-col>
        <v-col cols="12" sm="12" md="3" lg="3">
          <v-card class="float">
            <p class="py-3 px-3 text-h6">Resumen de mi pedido</p>
            <v-expansion-panels flat>
              <v-expansion-panel>
                <v-expansion-panel-header>
                  <p class="pb-3 px-3 text-subtitle-1">
                    Minima Inversión:
                    <strong>
                      {{ (catalogue.coin == "soles" ? "S/." : "$") + " " }}
                      {{ catalogue.minimum_investment | currency }}
                    </strong>
                  </p>
                </v-expansion-panel-header>
                <v-expansion-panel-content>
                  <v-card-text
                    v-for="(product, index) in selected"
                    :key="'A' + index"
                    class="py-0"
                  >
                    <v-row>
                      <v-col cols="4">
                        <v-img
                          v-if="
                            product.images == null || product.images.length == 0
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
                          (product.quantity * product.price_unit) | currency
                        }}
                        <br />
                        Cantidad
                        {{ product.quantity + " " + product.type_group }}
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
                          :src="productRange.images[0].path"
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
                </v-expansion-panel-content>
              </v-expansion-panel>
            </v-expansion-panels>
            <v-row class="text-right mx-2">
              <v-spacer></v-spacer>
              <v-col class="text-subtitle-1"
                >Total: {{ totalGeneral | currency }}</v-col
              >
            </v-row>
            <br />
            <v-dialog v-model="dialog" persistent max-width="290">
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                  v-bind="attrs"
                  v-on="on"
                  class="mt-3"
                  :disabled="validate"
                >
                  Generar Orden
                </v-btn>
              </template>
              <v-card>
                <v-card-title class="headline"> Generar Orden </v-card-title>
                <v-card-text>
                  Antes de generar esta orden,
                  <strong class="text-red"
                    >tienes que estar seguro de que los datos con los que te
                    registraste son validos</strong
                  >, ya que mediante estos estaremos generando una orden de
                  compra.
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="green darken-1" text @click="dialog = false">
                    Cancelar
                  </v-btn>
                  <v-btn
                    color="green darken-1"
                    text
                    @click="
                      generateOrder({
                        id: catalogue.id,
                        products: selected,
                        product_ranges: selectedRange,
                      }),
                        (dialog = false),
                        (alert = false)
                    "
                  >
                    Generar
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-card>
        </v-col>
      </v-row>
      <Product
        v-model="showScheduleForm"
        :product="itemSelected"
        v-if="showScheduleForm"
        :catalogue="catalogue"
      />
      <v-alert dense text type="success" :hidden="alert" dismissible>
        Se genero correctamente su orden
      </v-alert>
    </v-col>
    <v-card class="float-movil">
      <v-card-text> Total de orden : {{ totalGeneral }} </v-card-text>
    </v-card>
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
    dialog: false,
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
        width: 135,
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
    alert: true,
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
      if (this.totalGeneral < this.catalogue.minimum_investment) {
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
        this.catalogue.products[index].quantity =
          this.catalogue.products[index].quantity -
          this.catalogue.products[index].magnifying;
      }
    },
    plusFunctionO(index) {
      console.log(this.catalogue.products[index]);
      this.catalogue.products[index].quantity =
        this.catalogue.products[index].quantity +
        this.catalogue.products[index].magnifying;
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
    console.log(this.catalogue);
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
.w {
  display: flex;
  max-width: 20px;
}
.w {
  display: flex;
  max-width: 25px;
}
.header-card {
  background-color: black;
  color: white;
  align-items: center;
}
.content-card {
  border: 1px solid black;
}
.float {
  position: fixed;
  bottom: 0px;
}
.float-movil {
  visibility: hidden;
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
  .float {
    position: relative;
  }
  .float-movil {
    visibility: visible;
    position: fixed;
    bottom: 0;
    right: 0;
  }
}
@media (max-width: 500px) {
  .m-page {
    margin-right: auto;
    margin-left: auto;
  }
  .float {
    position: relative;
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
