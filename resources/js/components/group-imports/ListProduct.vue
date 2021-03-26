<template>
  <div class="m-page">
    <v-col class="mt-5">
      <h2>{{ catalogue.name }}</h2>
      <v-divider></v-divider>
      <v-row>
        <v-col cols="12" sm="12" md="5" lg="5" class="d-flex align-center">
          <v-img
            contain
            src="https://ep01.epimg.net/elpais/imagenes/2020/11/30/escaparate/1606750893_769867_1606751114_noticia_normal_recorte1.jpg"
            v-if="catalogue.image == null || catalogue.image.length == 0"
          />
          <v-img v-else contain :src="catalogue.image.path" />
        </v-col>
        <v-col cols="12" sm="12" md="7" lg="7">
          <v-card-title class="pt-1">
            <v-row>
              <v-col cols="12" class="pt-0"> Información y Condiciones </v-col>
            </v-row>
          </v-card-title>
          <v-card-text class="font-weight-medium pb-0 pt-1">
            <v-row>
              <v-col sm="6" md="8">
                <v-icon color="black" x-small>mdi-circle</v-icon>
                Todos los montos se encuentran en:
              </v-col>
              <v-col sm="6" md="4" class="text-right">
                <v-chip class="mr-2 text-capitalize">
                  {{ catalogue.coin }}
                </v-chip>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-text class="font-weight-medium pb-0 pt-1">
            <v-row>
              <v-col sm="6" md="8">
                <v-icon color="black" x-small>mdi-circle</v-icon>
                Monto de separación de cupo / Garantía de participación:
                <br />
              </v-col>
              <v-col sm="6" md="4" class="text-right">
                <v-chip class="mr-2">
                  {{ catalogue.coin == 'soles' ? 'S./' : '$' }}
                  {{ catalogue.quota_price | currency }}
                </v-chip>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-text class="font-weight-medium pb-2 pt-1">
            <v-row>
              <v-col sm="6" md="8">
                <v-icon color="black" x-small>mdi-circle</v-icon>
                El monto de separación es parte de la primera cuota)
                <br />
              </v-col>
              <v-col sm="6" md="4" class="text-right"> </v-col>
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
                  {{ catalogue.coin == 'soles' ? 'S./' : '$' }}
                  {{ catalogue.minimum_investment | currency }}
                </v-chip>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-text class="font-weight-medium pb-0 pt-1">
            <v-row>
              <v-col sm="6" md="8">
                <v-icon color="black" x-small>mdi-circle</v-icon> % de Primera cuota:
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
                <v-icon color="black" x-small>mdi-circle</v-icon> % de Segunda cuota:
              </v-col>
              <v-col sm="6" md="4" class="text-right">
                <v-chip class="mr-2">
                  <v-icon left> mdi-percent </v-icon>
                  {{ catalogue.second_payment }}
                </v-chip>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-title>
            <v-row>
              <v-col cols="12"> Fechas </v-col>
            </v-row>
          </v-card-title>
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
          <v-card-text
            class="font-weight-medium pb-0 pt-1"
            v-for="(arrival, index) in catalogue.arrivals"
            :key="index"
          >
            <v-row>
              <v-col sm="6" md="8">
                <v-icon color="black" x-small>mdi-circle</v-icon>
                Fecha estimada para recojos y envios desde {{ arrival.city }}
              </v-col>
              <v-col sm="6" md="4" class="text-right">
                <v-chip class="mr-2">
                  <v-icon left> mdi-calendar-month </v-icon>
                  {{ arrival.arrival_date | date }}
                </v-chip>
              </v-col>
            </v-row>
          </v-card-text>
        </v-col>
      </v-row>
      <v-col class="px-0 content-card pt-0 mt-5">
        <v-toolbar color="black" class="px-0 text-h6" dark flat>Términos y Condiciones</v-toolbar>
        <v-card-text
          v-for="(element, index) in catalogue.conditions"
          :key="index"
          class="pb-0 pt-1 text-justify"
        >
          <v-icon color="black" x-small>mdi-circle</v-icon>
          {{ element }}
        </v-card-text>
      </v-col>
      <v-row class="mt-5">
        <v-col cols="12" sm="12" md="9" lg="9">
          <v-tabs
            fixed-tabs
            background-color="#6694BB"
            v-model="currentTab"
            dark
            show-arrows=""
            v-if="catalogue.products.length != 0 || catalogue.productRanges != 0"
          >
            <v-tab v-if="catalogue.products.length != 0"> Productos </v-tab>
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
                class="elevation-1 hidden-xs-only p-page px-0"
                disable-pagination
                v-if="catalogue.products.length != 0"
              >
                <template v-slot:[`item.images`]="{ item, index }">
                  <v-row class="d-flex align-center justify-center">
                    <div>
                      <strong>{{ index }}</strong>
                    </div>
                    <v-img
                      v-if="item.images == null || item.images.length == 0"
                      src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"
                      max-width="150"
                      max-height="150"
                      contain
                      class="m-1 my-5"
                    />
                    <v-img
                      v-else
                      contain
                      :src="item.images[0].path"
                      max-width="150"
                      class="text-center align-center my-5"
                    />
                  </v-row>
                </template>
                <template v-slot:[`item.model`]="{ item }">
                  {{ item.model }}
                  <br />
                  <v-btn small class="mt-2 mx-2" @click="prueba(item)">
                    Ver Mas
                  </v-btn>
                </template>
                <template v-slot:[`item.quantity_group`]="{ item }">
                  {{ item.quantity_group + ' ' }}
                  <br />
                  {{ item.type_group }}
                </template>
                <template v-slot:[`item.quantity_order`]="{ item, index }">
                  <div class="form-inline justify-content-center">
                    <v-btn
                      @click="minusFunction(item, index)"
                      color="secondary"
                      fab
                      x-small
                      elevation="1"
                    >
                      <v-icon>mdi-minus</v-icon>
                    </v-btn>
                    <input type="text" class="w mx-2 text-center" v-model="item.quantity" />
                    <v-btn
                      @click="plusFunctionO(index)"
                      color="secondary"
                      fab
                      elevation="1"
                      x-small
                    >
                      <v-icon>mdi-plus</v-icon>
                    </v-btn>
                  </div>
                </template>
                <template class="bb" v-slot:[`item.cart`]="{ item }">
                  <v-row>
                    <v-icon small class="mx-auto" color="#D6B331" @click="prueba">
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
                  <tr class="mt-5 bb">
                    <td class="px-0">
                      <v-row class="px-2">
                        <div>
                          <v-checkbox
                            :input-value="props.isSelected"
                            @change="props.select($event)"
                            dense
                            hide-details
                            style="display: block"
                            class="px-0 mx-0"
                          ></v-checkbox>
                        </div>
                        <div sm="11" md="11" lg="11">
                          <v-img
                            v-if="props.item.images == null || props.item.images.length == 0"
                            src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"
                            max-width="75"
                            max-height="75"
                            contain
                            class="m-1"
                          />
                          <v-img
                            v-else
                            contain
                            :src="props.item.images[0].path"
                            max-width="75"
                            max-height="75"
                            class="text-center align-center"
                          />
                        </div>
                      </v-row>
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
                      <v-btn small class="my-5" @click="prueba(props.item)">Ver Mas</v-btn>
                      <br />
                      <div class="form-inline justify-content-center">
                        <v-btn
                          @click="minusFunction(props.item, props.index)"
                          color="#000"
                          icon
                          x-small
                          elevation="1"
                        >
                          <v-icon>mdi-minus</v-icon>
                        </v-btn>
                        <input type="text" class="w mx-2" v-model="props.item.quantity" />
                        <v-btn
                          @click="plusFunctionO(props.index)"
                          color="#000"
                          icon
                          elevation="1"
                          x-small
                        >
                          <v-icon>mdi-plus</v-icon>
                        </v-btn>
                      </div>
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
                    <v-icon x-small>mdi-circle</v-icon> De {{ range.min }} a {{ range.max }} el
                    precio es
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
          <br />
          <br />
          <v-card class="float mx-auto display-md" max-width="80%" elevation="5">
            <p class="font-text text-center mb-0">
              RESUMEN DE MI PEDIDO
            </p>
            <p class="px-3 pb-0 mb-0 text-subtitle-1">
              Minima Inversión:
              <strong>
                {{ (catalogue.coin == 'soles' ? 'S/.' : '$') + ' ' }}
                {{ catalogue.minimum_investment | currency }}
              </strong>
            </p>
            <v-expansion-panels flat class="color">
              <v-expansion-panel class="color">
                <v-expansion-panel-header class="color p-2">
                  <v-btn small dark color="black" class="mr-2">Ver Productos</v-btn>
                </v-expansion-panel-header>
                <v-expansion-panel-content
                  class="color"
                  style="
                    max-height: 400px;
                    overflow: scroll;
                    overflow-x: hidden;
                  "
                >
                  <v-card-text
                    v-for="(product, index) in selected"
                    :key="'A' + index"
                    class="py-0 px-0"
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
                        Pago:{{ catalogue.coin == 'soles' ? 'S/.' : '$'
                        }}{{ (product.quantity * product.price_unit) | currency }}
                        <br />
                        Cantidad
                        {{ product.quantity + ' ' + product.type_group }}
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
                          v-if="productRange.images == null || productRange.images.length == 0"
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
                        Pago:{{ catalogue.coin == 'soles' ? 'S/.' : '$' }}
                        {{ productRange.total }}
                        <br />
                        Cantidad
                        {{
                          productRange.quantity +
                            ' ' +
                            (productRange.quantity == 1 ? 'Unidad' : 'Unidades')
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
              <v-col class="text-subtitle-1 pb-0">Total: {{ totalGeneral | currency }}</v-col>
            </v-row>
            <br />
            <v-dialog v-model="dialog" persistent max-width="290">
              <template v-slot:activator="{ on, attrs }">
                <div class="d-flex justify-space-around pb-5">
                  <div>
                    <v-btn v-if="!isLoggedIn" v-bind="attrs" v-on="on" small class="px-2">
                      Generar Orden
                    </v-btn>
                  </div>
                  <div>
                    <v-btn
                      v-if="isLoggedIn"
                      v-bind="attrs"
                      v-on="on"
                      :disabled="validate"
                      small
                      class="px-2"
                    >
                      Generar Orden
                    </v-btn>
                  </div>
                  <div>
                    <v-btn
                      v-if="!isLoggedIn"
                      color="blue"
                      small
                      :to="{ name: 'register' }"
                      class="px-2"
                    >
                      Registraste
                    </v-btn>
                  </div>
                </div>
              </template>
              <v-card>
                <v-card-title class="headline"> Generar Orden </v-card-title>
                <v-card-text v-if="isLoggedIn">
                  Antes de generar esta orden,
                  <strong class="text-red"
                    >tienes que estar seguro de que los datos con los que te registraste son
                    validos</strong
                  >, ya que mediante estos estaremos generando una orden de compra.
                </v-card-text>
                <v-card-text v-else>
                  Para generar su orden debe registrarse
                  <strong class="text-red">¡ES FACILÍSIMO!</strong>.
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="green darken-1" text @click="dialog = false">
                    Cancelar
                  </v-btn>
                  <v-btn
                    v-if="isLoggedIn"
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
                  <v-btn v-else color="green darken-1" text :to="{ name: 'register' }">
                    registrarse
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-card>
        </v-col>
        <v-col cols="12" sm="12" md="3" lg="3" class="content-cart display-sm">
          <v-card class="float mx-auto" elevation="5">
            <p class="py-3 px-3 font-text text-center">
              RESUMEN DE MI PEDIDO
            </p>
            <p class="px-3 pb-0 mb-0 text-subtitle-1">
              Minima Inversión:
              <strong>
                {{ (catalogue.coin == 'soles' ? 'S/.' : '$') + ' ' }}
                {{ catalogue.minimum_investment | currency }}
              </strong>
            </p>
            <v-expansion-panels flat class="color">
              <v-expansion-panel class="color">
                <v-expansion-panel-header class="color p-2">
                  <v-btn small dark color="black" class="mr-2">Ver Productos</v-btn>
                </v-expansion-panel-header>
                <v-expansion-panel-content
                  class="color"
                  style="
                    max-height: 500px;
                    overflow: scroll;
                    overflow-x: hidden;
                  "
                >
                  <v-card-text
                    v-for="(product, index) in selected"
                    :key="'A' + index"
                    class="py-0 px-0"
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
                        Pago:{{ catalogue.coin == 'soles' ? 'S/.' : '$'
                        }}{{ (product.quantity * product.price_unit) | currency }}
                        <br />
                        Cantidad
                        {{ product.quantity + ' ' + product.type_group }}
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
                          v-if="productRange.images == null || productRange.images.length == 0"
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
                        Pago:{{ catalogue.coin == 'soles' ? 'S/.' : '$' }}
                        {{ productRange.total }}
                        <br />
                        Cantidad
                        {{
                          productRange.quantity +
                            ' ' +
                            (productRange.quantity == 1 ? 'Unidad' : 'Unidades')
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
              <v-col class="text-subtitle-1">Total: {{ totalGeneral | currency }}</v-col>
            </v-row>
            <br />
            <v-dialog v-model="dialog" persistent max-width="500">
              <template v-slot:activator="{ on, attrs }">
                <div class="d-flex justify-space-around mb-3">
                  <div>
                    <v-btn v-if="!isLoggedIn" v-bind="attrs" v-on="on" small class="px-2">
                      Generar Orden
                    </v-btn>
                  </div>
                  <div>
                    <v-btn
                      v-if="isLoggedIn"
                      v-bind="attrs"
                      v-on="on"
                      :disabled="validate"
                      small
                      class="px-2"
                    >
                      Generar Orden
                    </v-btn>
                  </div>
                  <div>
                    <v-btn
                      v-if="!isLoggedIn"
                      color="blue"
                      small
                      :to="{ name: 'register' }"
                      class="px-2"
                    >
                      Registraste
                    </v-btn>
                  </div>
                </div>
              </template>
              <v-card>
                <v-card-title class="headline text-center" v-if="isLoggedIn">
                  IMPORTANTE
                </v-card-title>
                <v-card-title class="headline text-center" v-else> Generar Orden </v-card-title>
                <v-card-text v-if="isLoggedIn" class="font-weight-medium black--text">
                  Para realizar su separación de pedido debe pagar
                  <strong>${{ catalogue.quota_price }}</strong> a cualquiera de las siguientes
                  cuentas:
                  <br />
                  BCP A NOMBRE DE BIZZPERU SA:
                  <ul>
                    <li>
                      CUENTA SOLES: 215-31690893-0-98 CÓDIGO DE CUENTA INTERBANCARIA:
                      00221513169089309824
                    </li>
                    <li>
                      CUENTA DÓLARES: 215-91784070-1-76 CÓDIGO DE CUENTA INTERBANCARIA:
                      00221519178407017621
                    </li>
                  </ul>

                  BBVA A NOMBRE DE BIZZPERU COMPANY EIRL:
                  <ul>
                    <li>
                      CUENTA SOLES:0011-0220-0201770773 CÓDIGO DE CUENTA INTERBANCARIA:
                      01122000020177077314
                    </li>

                    <li>
                      CUENTA DÓLARES: 0011-0220-0201770803 CÓDIGO DE CUENTA INTERBANCARIA:
                      01122000020177080319
                    </li>

                    <li>
                      YAPE A NOMBRE DE BIZZPERU SA: 958073710
                    </li>
                  </ul>

                  Y enviar su constancia al siguiente número: <strong>927750048</strong>
                </v-card-text>
                <v-card-text v-else class="font-weight-medium black--text">
                  Para generar su orden debe registrarse
                  <strong class="text-red">¡ES FACILISIMO!</strong>.
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn text @click="dialog = false" color="red" x-large>
                    Cancelar
                  </v-btn>
                  <v-btn v-if="isLoggedIn" color="blue" text x-large @click="generateOrderAction">
                    Generar
                  </v-btn>
                  <v-btn v-else color="blue" x-large text :to="{ name: 'register' }">
                    registrarse
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-card>
        </v-col>
      </v-row>
      <br />
      <br />
      <Product
        v-model="showScheduleForm"
        :product="itemSelected"
        v-if="showScheduleForm"
        :catalogue="catalogue"
      />
    </v-col>
    <v-dialog v-model="dialogSuccess" persistent max-width="290">
      <v-card>
        <v-card-title class="headline">
          ¡Operación exitosa!
        </v-card-title>
        <v-card-text>
          Su orden fue regitrada con éxito
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" text @click="dialogSuccess = false" x-large>
            Aceptar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
import Product from './product';
import { mapActions, mapGetters } from 'vuex';
import moment from 'moment';

export default {
  comments: {
    Product,
  },
  data: () => ({
    dialogSuccess: false,
    dialog: false,
    baseURL: '',
    totalItems: 0,
    itemSelected: null,
    showScheduleForm: false,
    singleSelect: false,
    singleSelectRange: false,
    selectedRange: [],
    description: [],
    number: 1,
    currentTab: 0,
    headers: [
      { text: 'Imagen', value: 'images', align: 'center', sortable: false },
      {
        text: 'Modelo',
        value: 'model',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Marca',
        value: 'brand',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Precio unitario (A)',
        value: 'price_unit',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Cantidad Mínima de Pedido (B)',
        value: 'quantity_group',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Precio Total (AxB)',
        value: 'price_group',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Cantidad de Pedido',
        value: 'quantity_order',
        align: 'center',
        sortable: false,
        width: 135,
      },
    ],
    headersItem: [
      { text: 'Imagen', value: 'images', align: 'center', sortable: false },
      {
        text: 'Modelo',
        value: 'model',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Marca',
        value: 'brand',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Precio por cantidad de Pedido',
        value: 'ranges',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Cantidad de Pedido',
        value: 'quantity_order',
        align: 'center',
        sortable: false,
      },
    ],
    catalogueGet: null,
    alert: true,
    proCa: [],
  }),
  components: {
    Product,
  },
  computed: {
    ...mapGetters('groupImport', ['catalogue', 'cart']),
    ...mapGetters('account', ['isLoggedIn']),

    total() {
      let t = 0;
      this.selected.forEach(element => {
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
      this.selectedRange.forEach(element => {
        q = element.quantity;
        if (element.ranges.length != 0) {
          element.ranges.forEach(range => {
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
    selected: {
      get() {
        let pro = [];
        this.cart.forEach(catalo => {
          if (catalo.id === this.catalogue.id) {
            pro = catalo.products;
          }
        });
        return pro;
      },
      set(v) {
        let cat = this.catalogue;
        // cat.products = v;
        this.addCart({ cat, products: v });
        return (this.proCa = v);
      },
    },
  },
  methods: {
    ...mapActions('groupImport', ['removeCart']),
    ...mapActions('groupImport', ['getCatalogue', 'addCart', 'setCart', 'generateOrder']),

    generateOrderAction() {
      let order;
      this.cart.forEach(catalogue => {
        if (catalogue.id === this.catalogue.id) {
          order = catalogue;
        }
      });
      this.generateOrder(order);
      this.dialog = false;
      this.dialogSuccess = true;
    },

    minusFunction(item, index) {
      if (item.quantity <= item.quantity_group) {
        alert(
          `Lo sentimos, la candidad minima de de compra de este producto es ${item.quantity_group}`
        );
      } else {
        this.catalogue.products[index].quantity =
          this.catalogue.products[index].quantity - this.catalogue.products[index].magnifying;
      }
    },
    plusFunctionO(index) {
      console.log(this.catalogue.products[index]);
      this.catalogue.products[index].quantity =
        this.catalogue.products[index].quantity + this.catalogue.products[index].magnifying;
    },

    minusFunctionR(item, index) {
      if (item.quantity <= item.min) {
        alert(`Lo sentimos, la candidad minima de de compra de este producto es ${item.min}`);
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
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800&display=swap');

.font-text {
  font-family: 'Poppins', sans-serif;
  font-size: 1.2rem;
  font-weight: 500;
  color: #444;
  font-weight: bold;
}
.v-data-table /deep/ tbody /deep/ tr:hover:not(.v-data-table__expanded__content) {
  background: #ff7676 !important;
}
.v-data-table /deep/ tbody /deep/ tr:not(.v-data-table__expanded__content) {
  border-top: 2px solid black;
}
.v-data-table /deep/ tbody /deep/ td:not(.v-data-table__expanded__content) {
  padding-right: 0;
  padding-left: 0;
  text-align: center !important;
}
.v-data-table /deep/ thead /deep/ th:not(.v-data-table__expanded__content) {
  padding-right: 0;
  padding-left: 0;
  text-align: center !important;
}
.display-md {
  visibility: hidden;
}
.bb:hover {
  background-color: chartreuse;
}
.bb {
  border-bottom: 2px solid rgb(124, 121, 121);
}
.content-cart {
  display: flex;
  flex-direction: row;
}
.color {
  background-color: #bcdaf1;
}
.pc {
  color: red;
}
.w {
  display: flex;
  max-width: 20px;
}
.w1 {
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
  position: sticky;
  bottom: 30px;
  background-color: #bcdaf1;
  align-self: flex-end;
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
  .display-sm {
    display: none;
  }
}
@media (max-width: 600px) {
  .m-page {
    margin-right: auto;
    margin-left: auto;
  }
  .display-sm {
    display: none;
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
@media (max-width: 960px) {
  .display-sm {
    display: none;
  }
  .display-md {
    visibility: visible;
  }
}
</style>
