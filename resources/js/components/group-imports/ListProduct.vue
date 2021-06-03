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
          <v-card-title class="pt-1 pl-0 pb-0">
            <v-col cols="12" class="pt-0 pl-0"> Información y Condiciones </v-col>
          </v-card-title>
          <ul class="pb-0 mb-0">
            <li>
              <v-row>
                <v-col sm="6" md="8">
                  Todos los montos se encuentran en:
                </v-col>
                <v-col sm="6" md="4" class="text-right">
                  <v-chip class="mr-2 text-capitalize">
                    {{ catalogue.coin }}
                  </v-chip>
                </v-col>
              </v-row>
            </li>
          </ul>
          <ul class="pb-0 mb-0">
            <li>
              <v-row>
                <v-col sm="6" md="8">
                  Monto de separación de cupo / Garantía de participación:
                  <br />
                  <small class="my-0">(El monto de separación es parte de la primera cuota)</small>
                </v-col>
                <v-col sm="6" md="4" class="text-right">
                  <v-chip class="mr-2">
                    {{ catalogue.coin == 'soles' ? 'S./' : '$' }}
                    {{ catalogue.quota_price | currency }}
                  </v-chip>
                </v-col>
              </v-row>
            </li>
          </ul>
          <ul class="pb-0 mb-0">
            <li>
              <v-row>
                <v-col sm="6" md="8">
                  Inversión minima:
                </v-col>
                <v-col sm="6" md="4" class="text-right">
                  <v-chip class="mr-2">
                    {{ catalogue.coin == 'soles' ? 'S./' : '$' }}
                    {{ catalogue.minimum_investment | currency }}
                  </v-chip>
                </v-col>
              </v-row>
            </li>
          </ul>
          <ul class="pb-0 mb-0">
            <li>
              <v-row>
                <v-col sm="6" md="8">
                  % de Primera cuota:
                </v-col>
                <v-col sm="6" md="4" class="text-right">
                  <v-chip class="mr-2">
                    <v-icon left> mdi-percent </v-icon>
                    {{ catalogue.first_payment }}
                  </v-chip>
                </v-col>
              </v-row>
            </li>
          </ul>
          <ul class="pb-0 mb-0">
            <li>
              <v-row>
                <v-col sm="6" md="8">
                  % de Segunda cuota:
                </v-col>
                <v-col sm="6" md="4" class="text-right">
                  <v-chip class="mr-2">
                    <v-icon left> mdi-percent </v-icon>
                    {{ catalogue.second_payment }}
                  </v-chip>
                </v-col>
              </v-row>
            </li>
          </ul>
          <v-card-title class="pl-0 pb-0 pt-0">
            <v-col cols="12" class="pl-0"> Fechas </v-col>
          </v-card-title>
          <ul class="pb-0 mb-0">
            <li>
              <v-row>
                <v-col sm="6" md="8">
                  Ultimo día para la separación de cupo:
                </v-col>
                <v-col sm="6" md="4" class="text-right">
                  <v-chip class="mr-2">
                    <v-icon left> mdi-calendar-month </v-icon>
                    {{ catalogue.quota_date | date }}
                  </v-chip>
                </v-col>
              </v-row>
            </li>
          </ul>
          <ul class="pb-0 mb-0">
            <li>
              <v-row>
                <v-col sm="6" md="8">
                  Fecha limite para el pago de la primera cuota:
                </v-col>
                <v-col sm="6" md="4" class="text-right">
                  <v-chip class="mr-2">
                    <v-icon left> mdi-calendar-month </v-icon>
                    {{ catalogue.date_first_payment | date }}
                  </v-chip>
                </v-col>
              </v-row>
            </li>
          </ul>
          <ul class="pb-0 mb-0">
            <li>
              <v-row>
                <v-col sm="6" md="8">
                  Fecha limite para el pago de la segunda cuota:
                </v-col>
                <v-col sm="6" md="4" class="text-right">
                  <v-chip class="mr-2">
                    <v-icon left> mdi-calendar-month </v-icon>
                    {{ catalogue.date_second_payment | date }}
                  </v-chip>
                </v-col>
              </v-row>
            </li>
          </ul>
          <ul class="pb-0 mb-0" v-for="(arrival, index) in catalogue.arrivals" :key="index">
            <li>
              <v-row>
                <v-col sm="6" md="8">
                  Fecha estimada para recojos y envios desde {{ arrival.city }}
                </v-col>
                <v-col sm="6" md="4" class="text-right">
                  <v-chip class="mr-2">
                    <v-icon left> mdi-calendar-month </v-icon>
                    {{ arrival.arrival_date | date }}
                  </v-chip>
                </v-col>
              </v-row>
            </li>
          </ul>
        </v-col>
      </v-row>
      <v-col class="px-0 content-card pt-0 mt-5">
        <v-toolbar color="black" class="px-0 text-h6" dark flat>Información</v-toolbar>
        <br />
        <viewer :initialValue="catalogue.additional_information" height="500px" />
        <!-- <ul class="pb-0 mb-0">
          <li><strong>CUENTAS:</strong></li>
          <ul>
            <div v-for="(item, index) in bank" :key="index">
              <div v-if="item.short_name != 'YAPE' && item.short_name != 'Yape'">
                <li>{{ item.short_name }} A NOMBRE DE {{ item.account_name }}:</li>
                <ul>
                  <li>CUENTA SOLES: {{ item.account_soles }}</li>
                  <li>CÓDIGO DE CUENTA INTERBANCARIA: {{ item.account_interbank_soles }}</li>
                  <br />
                  <li>CUENTA DÓLARES: {{ item.account_dollar }}</li>
                  <li>CÓDIGO DE CUENTA INTERBANCARIA: {{ item.account_interbank_dollar }}</li>
                </ul>
                <br />
              </div>
              <div v-else>
                <li>
                  {{ item.short_name }} A NOMBRE DE {{ item.account_name }}:
                  {{ item.account_soles }}
                </li>
              </div>
            </div>
          </ul> -->
        <!-- <li>
            Y enviar su constancia al siguiente número de Whatsapp: <strong>927750048</strong>
          </li> -->
        <!-- </ul> -->
      </v-col>
      <v-col class="px-0 content-card pt-0 mt-5">
        <v-toolbar color="black" class="px-0 text-h6" dark flat>Términos y Condiciones</v-toolbar>
        <br />
        <viewer :initialValue="catalogue.conditions" height="500px" />
      </v-col>
      <v-row class="my-3">
        <v-col v-for="(item, index) in adviser" :key="index" class="px-0 text-center mx-1">
          <div class="text-h6">Asesor {{ index + 1 }}</div>
          <v-btn x-large color="#00E676" rounded @click="goToLink(item.link)" elevation="12">
            {{ item.name }}
            <br />
            {{ item.phone }}
            <v-icon class="ml-2">mdi-whatsapp</v-icon>
          </v-btn>
        </v-col>
      </v-row>
      <v-row class="mt-5">
        <v-col cols="12" sm="12" md="9" lg="9">
          <v-tabs fixed-tabs background-color="#bcdaf1" v-model="currentTab" show-arrows>
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
                height="1000"
                fixed-header
                class="elevation-1 hidden-xs-only p-page px-0"
                disable-pagination
                v-if="catalogue.products.length != 0"
              >
                <template v-slot:item="props">
                  <tr class="style-table-th">
                    <td>
                      <v-checkbox
                        :input-value="props.isSelected"
                        @change="props.select($event)"
                        hide-details
                        style="display: block"
                        class="px-0 mx-0"
                      ></v-checkbox>
                    </td>
                    <td class="style-table-td">
                      <v-row class="d-flex align-center justify-center">
                        <v-col cols="1" class="p-0 m-0 pt-4">
                          <strong>{{ props.index + 1 }}</strong>
                        </v-col>
                        <v-col cols="9">
                          <v-img
                            v-if="props.item.images == null || props.item.images.length == 0"
                            src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"
                            max-width="200"
                            max-height="200"
                            contain
                            class="m-1 my-5"
                          />
                          <v-img
                            v-else
                            contain
                            :src="props.item.images[0].path"
                            max-width="200"
                            class="text-center align-center my-5"
                          />
                        </v-col>
                      </v-row>
                    </td>
                    <td class="style-table-td">
                      {{ props.item.model }}
                      <br />
                      <v-btn small class="mt-2 mx-2" @click="prueba(props.item, 'normal')">
                        Ver Mas
                      </v-btn>
                    </td>
                    <td class="style-table-td">
                      {{ props.item.brand }}
                    </td>
                    <td class="style-table-td">
                      {{ (catalogue.coin == 'soles' ? 'S/.' : '$') + ' ' }}
                      {{ props.item.price_unit | currency }}
                    </td>
                    <td class="style-table-td">
                      {{ props.item.quantity_group + ' ' }}
                      <br />
                      {{ props.item.type_group }}
                    </td>
                    <td class="style-table-td">
                      {{ (catalogue.coin == 'soles' ? 'S/.' : '$') + ' ' }}
                      {{ props.item.price_group | currency }}
                    </td>
                    <td class="style-table-td pr-5">
                      <div class="form-inline justify-content-center">
                        <v-icon
                          class="back"
                          @click="minusFunction(props.item, props.index)"
                          small
                          dark
                        >
                          mdi-minus
                        </v-icon>
                        <input type="text" class="w text-center" v-model="props.item.quantity" />
                        <v-icon class="back" @click="plusFunctionO(props.index)" small dark>
                          mdi-plus
                        </v-icon>
                      </div>
                    </td>
                  </tr>
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
                      <strong>P.U:</strong> {{ (catalogue.coin == 'soles' ? 'S/.' : '$') + ' ' }}
                      {{ props.item.price_unit | currency }}
                      <br />
                      <strong>Cant.Min:</strong> {{ props.item.quantity_group }}
                      <br />
                      <strong>Total:</strong> {{ (catalogue.coin == 'soles' ? 'S/.' : '$') + ' ' }}
                      {{ props.item.price_group | currency }}
                    </td>
                    <td class="px-0 py-5">
                      <v-btn small class="my-5" @click="prueba(props.item, 'normal')"
                        >Ver Mas</v-btn
                      >
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

              <v-data-table
                v-model="selectedRange"
                :single-select="singleSelectRange"
                show-select
                :headers="headersItem"
                :items="catalogue.productRanges"
                hide-default-footer
                disable-pagination
                class="elevation-1 mt-3 hidden-xs-only p-page px-0"
                v-if="catalogue.productRanges.length != 0"
              >
                <template v-slot:item="props">
                  <tr class="style-table-th">
                    <td>
                      <v-checkbox
                        :input-value="props.isSelected"
                        @change="props.select($event)"
                        hide-details
                        style="display: block"
                        class="px-0 mx-0"
                      ></v-checkbox>
                    </td>
                    <td class="style-table-td">
                      <v-row class="d-flex align-center justify-center">
                        <v-col cols="1" class="p-0 m-0 pt-4">
                          <strong>{{ props.index + 1 }}</strong>
                        </v-col>
                        <v-col cols="9">
                          <v-img
                            v-if="props.item.images == null || props.item.images.length == 0"
                            src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"
                            max-width="200"
                            max-height="200"
                            contain
                            class="m-1 my-5"
                          />
                          <v-img
                            v-else
                            contain
                            :src="props.item.images[0].path"
                            max-width="200"
                            class="text-center align-center my-5"
                          />
                        </v-col>
                      </v-row>
                    </td>
                    <td class="style-table-td">
                      {{ props.item.model }}
                      <br />
                      <v-btn small class="mt-2 mx-2" @click="prueba(props.item, 'range')">
                        Ver Mas
                      </v-btn>
                    </td>
                    <!-- <td class="style-table-td">
                      {{ props.item.brand }}
                    </td> -->
                    <td class="style-table-td">
                      <div v-for="(range, index) in props.item.ranges" :key="index">
                        De {{ range.min }} a
                        {{ props.item.ranges.length - 1 != index ? range.max : 'mas' }} :
                        {{ (catalogue.coin == 'soles' ? 'S/.' : '$') + ' ' }} {{ range.price }}
                      </div>
                    </td>
                    <td class="style-table-td pr-5">
                      <div class="form-inline justify-content-center">
                        <v-icon
                          class="back"
                          dark
                          small
                          @click="minusFunctionR(props.item, props.index)"
                          >mdi-minus</v-icon
                        >

                        <input type="text" class="w text-center" v-model="props.item.quantity" />

                        <v-icon
                          class="back"
                          dark
                          small
                          @click="plusFunctionR(props.index, props.item.meta, props.item.quantity)"
                          >mdi-plus</v-icon
                        >
                      </div>
                    </td>
                    <td class="style-table-td">
                      <div v-if="props.item.meta">
                        <div
                          v-for="(c, index) in props.item.meta"
                          :key="index"
                          class="d-flex justify-center align-center my-1 "
                        >
                          <v-avatar :color="c.color" size="15" />
                          <input
                            type="text"
                            class="w mx-2 text-center b-input"
                            v-model="c.quantity"
                            @change="
                              changeQuantity(
                                props.item.meta,
                                props.item.quantity,
                                props.index,
                                index
                              )
                            "
                            :disabled="props.item.cont"
                          />
                        </div>
                      </div>
                    </td>
                    <td class="style-table-td">
                      {{ (catalogue.coin == 'soles' ? 'S/.' : '$') + ' ' }}
                      {{ props.item.total | currency }}
                    </td>
                  </tr>
                </template>
              </v-data-table>
              <v-data-table
                v-model="selectedRange"
                :single-select="singleSelectRange"
                show-select
                :headers="headersItem"
                :items="catalogue.productRanges"
                hide-default-footer
                hide-default-header
                disable-pagination
                class="elevation-1 mt-3 hidden-sm-and-up"
                v-if="catalogue.productRanges.length != 0"
              >
                <template v-slot:item="props">
                  <tr class="mt-5 bb">
                    <td class="px-0">
                      <v-row class="px-2">
                        <div>
                          <v-checkbox
                            :input-value="props.isSelected"
                            @change="props.select($event)"
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
                      <strong>Precios:</strong>
                      <div v-for="range in props.item.ranges" :key="range.id">
                        De {{ range.min }} a {{ range.max }} :
                        {{ (catalogue.coin == 'soles' ? 'S/.' : '$') + ' ' }} {{ range.price }}
                      </div>
                    </td>
                    <td class="px-0 py-5">
                      <v-btn small class="my-5" @click="prueba(props.item, 'range')">Ver Mas</v-btn>
                      <br />
                      <div class="form-inline justify-content-center">
                        <v-btn
                          @click="minusFunctionR(props.item, props.index)"
                          color="#000"
                          icon
                          x-small
                          elevation="1"
                        >
                          <v-icon>mdi-minus</v-icon>
                        </v-btn>
                        <input type="text" class="w" v-model="props.item.quantity" />
                        <v-btn
                          @click="plusFunctionR(props.index)"
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
          </v-tabs-items>
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
                  <v-btn v-if="isLoggedIn" color="green darken-1" text @click="generateOrderAction">
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
          <v-card class="float mx-0 d-flex flex-column" elevation="12" style="flex: 1">
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
                <v-card-text v-if="isLoggedIn" class="">
                  <div class="font-weight-medium black--text">
                    <strong>PASO 1:</strong>
                  </div>
                  <div class="pl-2">
                    Para realizar su separación de pedido debe pagar
                    <strong>${{ catalogue.quota_price }}</strong> o S/.300.00, el monto a depositar
                    debe ser en la misma moneda del banco receptor.
                    <br />
                    <br />
                    <div class="font-weight-medium black--text">
                      CUENTAS:
                    </div>
                    <div class="font-weight-medium black--text">
                      BCP A NOMBRE DE BIZZPERU SA:
                    </div>
                    <ul>
                      <li>
                        CUENTA SOLES: 215-31690893-0-98
                      </li>
                      <li>
                        CÓDIGO DE CUENTA INTERBANCARIA: 00221513169089309824
                      </li>
                      <br />
                      <li>
                        CUENTA DÓLARES: 215-91784070-1-76
                      </li>
                      <li>
                        CÓDIGO DE CUENTA INTERBANCARIA: 00221519178407017621
                      </li>
                    </ul>
                    <div class="font-weight-medium black--text">
                      BBVA A NOMBRE DE BIZZPERU COMPANY EIRL:
                    </div>
                    <ul>
                      <li>
                        CUENTA SOLES:0011-0220-0201770773
                      </li>
                      <li>
                        CÓDIGO DE CUENTA INTERBANCARIA: 01122000020177077314
                      </li>
                      <br />
                      <li>
                        CUENTA DÓLARES: 0011-0220-0201770803
                      </li>
                      <li>
                        CÓDIGO DE CUENTA INTERBANCARIA: 01122000020177080319
                      </li>
                    </ul>
                    <div class="font-weight-medium black--text">
                      YAPE A NOMBRE DE BIZZPERU SA: 958073710
                    </div>
                  </div>
                  <br />
                  <div class="font-weight-medium black--text">
                    <strong>PASO 2:</strong>
                  </div>
                  <div class="pl-2 ">
                    Y enviar su constancia al siguiente número de Whatsapp:
                    <strong>927750048</strong>
                  </div>
                  <br />
                  <div class="font-weight-medium black--text">
                    <strong>PASO 3:</strong>
                  </div>
                  <div class="pl-2">Será agregado a un grupo privado.</div>
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
      <Product
        v-model="showScheduleForm"
        :product="itemSelected"
        v-if="showScheduleForm"
        :catalogue="catalogue"
        :type="elementType"
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
import '@toast-ui/editor/dist/toastui-editor-viewer.css';
import { Editor, Viewer } from '@toast-ui/vue-editor';

export default {
  comments: {
    Product,
    editor: Editor,
    viewer: Viewer,
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
      // {
      //   text: 'Marca',
      //   value: 'brand',
      //   align: 'center',
      //   sortable: false,
      // },
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
      {
        text: 'Colores',
        value: 'colors',
        align: 'center',
        sortable: false,
      },
      {
        text: 'Precio del Pedido',
        value: 'total',
        align: 'center',
        sortable: false,
      },
    ],
    catalogueGet: null,
    alert: true,
    proCa: [],
    adviser: [],
    bank: [],
    elementType: '',
  }),
  components: {
    Product,
    editor: Editor,
    viewer: Viewer,
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
      let tot = 0;
      this.selectedRange.forEach(element => {
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
    selectedRange: {
      get() {
        let pro = [];
        this.cart.forEach(catalo => {
          if (catalo.id === this.catalogue.id) {
            pro = catalo.product_ranges;
          }
        });
        return pro;
      },
      set(v) {
        let cat = this.catalogue;
        // cat.products = v;
        this.addCart({ cat, product_ranges: v });
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
          `Lo sentimos, la candidad minima de compra de este producto es ${item.quantity_group}`
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
        alert(`Lo sentimos, la candidad minima de compra de este producto es ${item.min}`);
      } else {
        this.catalogue.productRanges[index].quantity--;
        let t = 0;
        let p = 0;
        if (this.catalogue.productRanges[index].ranges.length != 0) {
          this.catalogue.productRanges[index].ranges.forEach(range => {
            if (
              this.catalogue.productRanges[index].quantity >= range.min &&
              this.catalogue.productRanges[index].quantity <= range.max
            ) {
              t = range.price * this.catalogue.productRanges[index].quantity;
            }
            p = range.price;
            console.log(range.price);
          });
        }

        this.catalogue.productRanges[index].total = t;

        if (this.catalogue.productRanges[index].total == 0) {
          this.catalogue.productRanges[index].total =
            p * this.catalogue.productRanges[index].quantity;
        }
      }
      this.changeQuantityMOP(
        this.catalogue.productRanges[index].meta,
        this.catalogue.productRanges[index].quantity,
        index
      );
    },

    plusFunctionR(index) {
      console.log(this.catalogue.productRanges[index]);
      this.catalogue.productRanges[index].quantity++;
      let t = 0;
      let p = 0;
      if (this.catalogue.productRanges[index].ranges.length != 0) {
        this.catalogue.productRanges[index].ranges.forEach(range => {
          if (
            this.catalogue.productRanges[index].quantity >= range.min &&
            this.catalogue.productRanges[index].quantity <= range.max
          ) {
            t = range.price * this.catalogue.productRanges[index].quantity;
          }
          p = range.price;
          console.log(range.price);
        });
      }

      this.catalogue.productRanges[index].total = t;

      if (this.catalogue.productRanges[index].total == 0) {
        this.catalogue.productRanges[index].total =
          p * this.catalogue.productRanges[index].quantity;
      }

      this.changeQuantityMOP(
        this.catalogue.productRanges[index].meta,
        this.catalogue.productRanges[index].quantity,
        index
      );
    },

    reserve() {
      this.loading = true;
      setTimeout(() => (this.loading = false), 2000);
    },
    prueba(value, type) {
      this.itemSelected = value;
      this.elementType = type;
      this.showScheduleForm = true;
      console.log(this.itemSelected);
    },
    mas() {
      this.catalogue.productRanges[1].quantity++;
      console.log(this.catalogue.productRanges[1].quantity);
    },
    getAdvisers() {
      axios
        .get('/api/v1/advisers')
        .then(response => {
          this.adviser = response.data.data;
        })
        .catch(error => {});
    },
    getBanks() {
      axios
        .get('/api/v1/banks')
        .then(response => {
          this.bank = response.data;
        })
        .catch(error => {});
    },
    goToLink(link) {
      window.open(link);
    },
    changeQuantityMOP(meta, quantity, index) {
      console.log('aqui');
      let suma = 0;
      meta.forEach(element => {
        suma = suma + parseInt(element.quantity);
      });
      if (suma == quantity) {
        this.catalogue.productRanges[index].cont = true;
      } else if (suma > quantity) {
        alert('Vuelva a insertar la cantidad de colores que desea');
        this.catalogue.productRanges[index].meta.forEach(element => {
          element.quantity = 0;
        });
        this.catalogue.productRanges[index].cont = true;
      } else {
        this.catalogue.productRanges[index].cont = false;
      }
      console.log(suma);
    },
    changeQuantity(meta, quantity, index, indexMeta) {
      console.log('aqui');
      let suma = 0;
      meta.forEach(element => {
        suma = suma + parseInt(element.quantity);
      });
      if (suma == quantity) {
        this.catalogue.productRanges[index].cont = true;
      } else if (suma > quantity) {
        alert('Lo sentimos, aumente mas cantidad.');
        this.catalogue.productRanges[index].meta[indexMeta].quantity = 0;
      } else {
        this.catalogue.productRanges[index].cont = false;
      }
      console.log(suma);
    },
  },
  mounted() {
    this.getCatalogue(this.$route.params.id);
    console.log(this.catalogue);
    this.getBanks();
    this.getAdvisers();
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
.back {
  background-color: black;
  border-radius: 100%;
  padding: 2px;
}
.style-table-th {
  border-bottom: 2px solid !important;
}
.style-table-th:hover {
  background-color: #ffcdd2 !important;
}
.style-table-td {
  text-align: center !important;
  padding-left: 2px !important;
  padding-right: 2px !important;
}
.font-text {
  font-family: 'Poppins', sans-serif;
  font-size: 1.2rem;
  font-weight: 500;
  color: #444;
  font-weight: bold;
}
.b-input {
  border: 1px solid black;
  border-radius: 10%;
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
  max-width: 30px;
  text-align: center;
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
  margin-right: 5%;
  margin-left: 5%;
}
.p-page {
  padding-right: 5%;
  padding-left: 5%;
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
