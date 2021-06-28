<template>
  <div class="book">
    <div class="page">
      <v-col class="text-right btn-invisible">
        <v-btn small @click="printWindow">
          <v-icon class="mr-3">mdi-printer</v-icon>
          Imprimir
        </v-btn>
      </v-col>
      <v-col class="my-auto">
        <v-row class="d-flex">
          <v-col cols="2">
            <v-img src="/images/LogoPNG.png"></v-img>
          </v-col>
          <v-col cols="8">
            <div class="logo-text">
              AGENCIA DE IMPORTACIONES
            </div>
          </v-col>
        </v-row>
      </v-col>
      <v-col class="mt-5">
        <v-row class="text-center">
          <div class="m-auto content-page-initial">
            <div class="text-import">
              IMPORTACIÓN
            </div>
            <div class="text-group">
              GRUPAL
            </div>
            <div class="text-name trapecio">
              {{ catalogue.name }}
            </div>
            <div class="text-year">
              {{ new Date().getFullYear() }}
            </div>
          </div>
        </v-row>
      </v-col>
      <v-col>
        <div class="footer">
          <div class="text-contact">
            <v-icon color="#3758ec">mdi-facebook</v-icon> Bizzperu - Agencia de IMPORTACIONES
          </div>
          <div class="text-contact"><strong>RUC</strong> 20559212378</div>
        </div>
      </v-col>
    </div>
    <div class="page">
      <div class="information">
        INFORMACIÓN
      </div>
      <ul>
        <li>FECHA LIMITE PARA SEPARAR TU CUPO : {{ catalogue.quota_date | date }}</li>
        <li>
          INVERSIÓN MINIMA APROXIMADA : {{ catalogue.coin == 'dolares' ? '$' : 'S/.' }}
          {{ catalogue.minimum_investment | currency }}
          {{ catalogue.coin == 'dolares' ? '(Dolares)' : '(Soles)' }}
        </li>
        <li>EL PRECIO INCLUYE TODOS LOS GASTOS DE IMPORTACIONES HASTA EL ALMACÉN</li>
        <li>ENVIOS A OTRAS CUIDADES DESDE AREQUIPA</li>
        <li>PUNTOS DE ENTREGA</li>
      </ul>
      <br />
      <div class="information">
        CRONOGRAMA
      </div>
      <table class="table table-bordered">
        <tbody>
          <tr>
            <th scope="row">Ultimo dia para separación de cupo</th>
            <td>{{ catalogue.quota_date | date }}</td>
          </tr>
          <tr>
            <th scope="row">Fecha limite de pago del % {{ catalogue.first_payment }}</th>
            <td>{{ catalogue.date_first_payment | date }}</td>
          </tr>
          <tr>
            <th scope="row">Fecha estimada del pago del {{ catalogue.second_payment }}</th>
            <td>{{ catalogue.date_second_payment | date }}</td>
          </tr>
          <tr v-for="(arr, iarr) in catalogue.arrivals" :key="iarr">
            <th scope="row">Fecha de llegada estimada a {{ arr.city }}</th>
            <td>{{ arr.arrival_date | date }}</td>
          </tr>
        </tbody>
      </table>
      <br />
      <div class="information">
        CONSULTAS
      </div>
      <div v-for="(ad, iad) in advisers" :key="iad">
        <strong>{{ ad.phone }} o</strong>
        <v-btn elevation="0" color="#3bcc67" class="text-white p-0 m-0" small>
          &nbsp;<v-icon color="#fff">mdi-whatsapp</v-icon> &nbsp; Hablar con Asesor
          {{ iad + 1 }} &nbsp;
        </v-btn>
      </div>
    </div>
    <div class="page" v-for="(pag, index) in arrayProduct" :key="index">
      <div class="subpage" v-for="(pro, ipro) in pag" :key="ipro">
        <div class="header mb-1">
          COMPRA MÍNIMA :
          {{ pro.quantity_group }} UNIDADES
          <small>X MODELO</small>
          <v-avatar color="#6737ec" size="30"
            ><v-icon color="#fff" small>mdi-archive</v-icon></v-avatar
          >
        </div>
        <!-- <div v-if="pro.images == null || pro.images.length == 0" class="mb-3 content-image">
            <v-img
              max-height="300"
              max-width="400"
              v-if="pro.images == null || pro.images.length == 0"
              src="https://picsum.photos/id/11/500/300"
            ></v-img>
          </div>
          <div v-else class="mb-3 content-image">
            <v-img max-height="300" max-width="400" :src="pro.images[0].path" v-else></v-img>
          </div> -->
        <v-img
          max-height="300"
          max-width="400"
          v-if="pro.images == null || pro.images.length == 0"
          src="https://picsum.photos/id/11/500/300"
          class="mx-auto mb-3"
        ></v-img>
        <v-img
          max-height="300"
          max-width="400"
          :src="pro.images[0].path"
          contain
          v-else
          class="mx-auto mb-3"
        ></v-img>

        <div class="content">
          <div class="content-header">
            <div class="content-header-title">MODELO: {{ pro.model }}</div>
          </div>
          <ul>
            <li v-for="(details, dindex) in pro.description" :key="dindex">
              {{ details }}
            </li>
            <li v-if="pro.colors != null">
              Colores:
              <v-avatar
                v-for="(color, cindex) in pro.colors"
                :key="cindex"
                size="13"
                :color="color"
                class="ml-1"
              >
              </v-avatar>
            </li>
          </ul>
          <div class="content-footer">
            <div class="cprice">
              <div class="price-title">PRECIO POR {{ pro.quantity_group }} U.</div>
              <div class="content-price">
                <v-avatar size="20" color="#6737ec" class="p-3 text-white simbol">
                  {{ catalogue.type_coin == 'soles' ? 'S./' : '$' }}
                </v-avatar>
                <div class="price">
                  <div class="price-text">
                    {{ pro.price_group | currency }}
                  </div>
                  <small class="price-subtext">(compra mínima)</small>
                </div>
              </div>
            </div>
            <div class="cprice-unit">
              <div class="price-unit-title">PRECIO UNITARIO</div>
              <div class="content-price-unit">
                <v-avatar size="22" color="#6737ec" class="p-2 text-white simbol-unit">
                  {{ catalogue.type_coin == 'soles' ? 'S./' : '$' }}
                </v-avatar>
                <div class="price-unit">
                  <div class="price-unit-text">
                    {{ pro.price_unit | currency }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="mt-1">
          * Imágenes referenciales
        </div>
      </div>
    </div>
    <div class="page" v-for="(pagr, pindex) in arrayProductR" :key="'a' + pindex">
      <div class="subpage" v-for="(pro, ipror) in pagr" :key="ipror">
        <div class="header mb-1">
          COMPRA MÍNIMA :
          {{ pro.min }} UNIDADES
          <small>X MODELO</small>
          <v-avatar color="#6737ec" size="30"
            ><v-icon color="#fff" small>mdi-archive</v-icon></v-avatar
          >
        </div>
        <!-- <div v-if="pro.images == null || pro.images.length == 0" class="mb-3">
            <v-img
              max-height="300"
              max-width="400"
              src="https://picsum.photos/id/11/500/300"
              v-if="pro.images == null || pro.images.length == 0"
            ></v-img>
          </div>
          <div v-else class="mb-3">
            <v-img max-height="300" max-width="400" :src="pro.images[0].path" v-else></v-img>
          </div> -->
        <v-img
          max-height="300"
          max-width="400"
          src="https://picsum.photos/id/11/500/300"
          v-if="pro.images == null || pro.images.length == 0"
          class="mx-auto mb-3"
        ></v-img>
        <v-img
          max-height="300"
          max-width="400"
          :src="pro.images[0].path"
          v-else
          class="mx-auto mb-3"
          contain
        ></v-img>

        <div class="content">
          <div class="content-header">
            <div class="content-header-title">MODELO: {{ pro.model }}</div>
          </div>
          <ul>
            <li v-for="(detailsr, drindex) in pro.description" :key="drindex">
              {{ detailsr }}
            </li>
            <li v-if="pro.colors != null">
              Colores:
              <v-avatar
                v-for="(rcolor, crindex) in pro.colors"
                :key="crindex"
                size="13"
                :color="rcolor"
                class="ml-1"
              >
              </v-avatar>
            </li>
          </ul>
          <strong class="ml-3">PRECIOS</strong>
          <ul>
            <li v-for="(ran, rindex) in pro.ranges" :key="rindex">
              De {{ ran.min }} a {{ ran.max }} : {{ catalogue.coin == 'dolares' ? '$' : 'S/. ' }}
              {{ ran.price | currency }}
            </li>
          </ul>
        </div>
        <div class="mt-1">
          * Imágenes referenciales
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import moment from 'moment';

export default {
  data: () => ({
    catalogue: {},
    product: null,
    productRange: null,
    arrayProduct: [],
    arrayProductR: [],
    advisers: [],
  }),
  methods: {
    getCatalogue() {
      axios
        .get(`/api/v1/catalogues/${this.$route.params.id}`)
        .then(response => {
          console.log('data', response.data.data);
          this.catalogue = response.data.data;
          this.product = response.data.data.products;
          this.productRange = response.data.data.productRanges;
          let cont = 0;
          let cont2 = 0;
          let arr = [];
          this.product.forEach((e, i) => {
            arr[cont] = [];
            if (i % 2 != 1) {
              cont++;
            }
          });
          this.product.forEach((e, i) => {
            arr[cont2].push(e);
            console.log(cont2);
            if (i % 2 == 1) {
              cont2++;
            }
          });

          let prcont = 0;
          let prcont2 = 0;
          let prarr = [];
          this.productRange.forEach((e, i) => {
            let minRange = 1;
            if (e.ranges.length != 0) {
              minRange = e.ranges[0].min;
              e.ranges.forEach((range, index) => {
                if (range.min < minRange) {
                  minRange = range.min;
                }
              });
            }
            e.min = minRange;
            prarr[prcont] = [];
            if (i % 2 != 1) {
              prcont++;
            }
          });
          this.productRange.forEach((e, i) => {
            prarr[prcont2].push(e);
            console.log(prcont2);
            if (i % 2 == 1) {
              prcont2++;
            }
          });
          this.arrayProduct = arr;
          this.arrayProductR = prarr;
          this.arrayProduct.forEach((e, i) => {
            if (e.length == 0) {
              this.arrayProduct.splice(i, 1);
            }
          });
          this.arrayProductR.forEach((e, i) => {
            if (e.length == 0) {
              this.arrayProductR.splice(i, 1);
            }
          });
          console.log(this.arrayProductR);
        })
        .catch(error => {});
    },
    getAdvisers() {
      axios
        .get(`/api/v1/advisers`)
        .then(response => {
          this.advisers = response.data.data;
        })
        .catch(error => {});
    },
    printWindow() {
      window.print();
    },
  },
  mounted() {
    this.getCatalogue();
    this.getAdvisers();
  },
  filters: {
    currency: function(value) {
      return parseFloat(value).toFixed(2);
    },
    date: function(value) {
      moment.locale('es');
      return moment(value).format('LL');
    },
    porcent: function(value) {
      return parseFloat(value) * 100 + ' %';
    },
  },
};
</script>
<style scoped>
ul {
  padding: 0.5em 1em 0.5em 2.3em;
  position: relative;
  margin: 0 0 0 0 !important;
}

ul li {
  padding: 0 0 0 0;
  list-style-type: none !important;
}

ul li:before {
  font-family: FontAwesome;
  content: '\f138';
  position: absolute;
  left: 1em;
  color: #6737ec;
}
body {
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0;
  background-color: #fafafa;
  font: 12pt 'Tahoma';
}
* {
  box-sizing: border-box;
  -moz-box-sizing: border-box;
}

.trapecio {
  background: red;
  -webkit-transform: skew(-20deg);
  -moz-transform: skew(-20deg);
  -ms-transform: skew(-20deg);
  -o-transform: skew(-20deg);
  transform: skew(-20deg);
}

.logo-text {
  font-size: 30px;
}
.header {
  font-size: 25px;
  font-weight: 900;
  color: #6737ec;
}
.content-page-initial {
}
.text-import {
  color: red;
  font-size: 70px;
  font-weight: 900;
}
.text-group {
  color: black;
  font-size: 110px;
  font-weight: 900;
}
.text-name {
  color: white;
  font-size: 70px;
}
.text-year {
  color: red;
  font-size: 70px;
  font-weight: 900;
}
.text-contact {
  font-size: 20px;
}
.content {
  border: solid 2px #6737ec;
  border-radius: 15px;
}
.content-header {
  border-top-left-radius: 9px;
  border-top-right-radius: 9px;
  background-color: #6737ec;
}
.content-header-title {
  color: white;
  margin-left: 15px;
  font-weight: 900;
}
.content-price {
  display: flex;
  align-self: center;
}
.content-price-unit {
  text-align: center;
  display: inline-flex;
  padding-bottom: 10%;
}
.content-footer {
  display: flex;
  align-self: center;
}
.cprice {
  margin-left: 5%;
  margin-bottom: 3%;
  text-align: center;
}
.cprice-unit {
  text-align: center;
  margin-left: 5%;
  align-items: center;
  align-content: center;
  align-self: center;
}
.price {
  padding-top: 5px;
  padding-left: 3px;
  line-height: 90%;
  text-align: center;
  display: inline-block;
}
.price-text {
  font-weight: 900;
  font-size: 20px;
}
.price-title {
  font-weight: 900;
  font-size: 12px;
}
.price-unit {
  padding-left: 3px;
  line-height: 90%;
  text-align: center;
  align-self: center;
  align-items: center;
  align-content: center;
}
.price-unit-text {
  font-weight: 900;
  font-size: 16px;
}
.price-unit-title {
  font-weight: 900;
  font-size: 10px;
}
.price-subtext {
  font-size: 10px !important;
}
.simbol-unit {
  font-weight: 500;
  font-size: 12px;
}
.simbol {
  font-weight: 500;
  font-size: 17px;
}
.page {
  width: 210mm;
  min-height: 297mm;
  padding: 20mm;
  margin: 10mm auto;
  border: 1px #d3d3d3 solid;
  border-radius: 5px;
  background: white;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}
.information {
  font-weight: 900;
  font-size: 30px;
}
.subpage {
  padding: 1cm;
  height: 165.6mm;
}
.footer {
  bottom: 0;
  text-align: center;
}
.content-image {
  text-align: center;
  display: flex;
  align-content: center;
  align-items: center;
  align-self: center;
}

@page {
  size: A4;
  margin: 0;
}
@media print {
  html,
  body {
    width: 210mm;
    height: 297mm;
  }
  .page {
    margin: 0;
    border: initial;
    border-radius: initial;
    width: initial;
    min-height: initial;
    box-shadow: initial;
    background: initial;
    page-break-after: always;
  }
}
</style>
