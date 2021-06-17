<template>
  <div class="book">
    <div class="page">
      <v-row>
        <v-col cols="2">
          <v-img src="/images/LogoPNG.png"></v-img>
        </v-col>
        <v-col cols="8">
          <div class="logo-text">
            AGENCIA DE IMPORTACIONES
          </div>
        </v-col>
      </v-row>
      <v-row class="text-center">
        <div class="m-auto">
          <div class="text-import">
            IMPORTACIÓN
          </div>
          <div class="text-group">
            GRUPAL
          </div>
          <div class="text-name">
            {{ catalogue.name }}
          </div>
          <div class="text-year">
            {{ new Date().getFullYear() }}
          </div>
        </div>
      </v-row>
      <v-footer padless>
        <div class="text-contact">
          <v-icon>mdi-facebook</v-icon>Bizzperu - Agencia de IMPORTACIONES
        </div>
        <br />
        <div class="text-contact"><v-avatar>RUC</v-avatar>20559212378</div></v-footer
      >
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
        <div v-if="pro.images == null || pro.images.length == 0" class="mb-3">
          <v-img max-height="300" max-width="400" src="https://picsum.photos/id/11/500/300"></v-img>
        </div>
        <div v-else class="mb-3">
          <v-img max-height="300" max-width="400" :src="pro.images[0].path"></v-img>
        </div>
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
  </div>
</template>
<script>
export default {
  data: () => ({
    catalogue: {},
    product: null,
    productRange: null,
    arrayProduct: null,
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
          this.products = response.data.data.products;
          this.productForRange = response.data.data.productRanges;
          let cont = 0;
          let arr = [];
          this.product.forEach((e, i) => {
            arr[cont] = [];
            if (i % 2 != 1) {
              cont++;
            }
          });
          let cont2 = 0;
          this.product.forEach((e, i) => {
            arr[cont2].push(e);
            console.log(cont2);
            if (i % 2 == 1) {
              cont2++;
            }
          });
          console.log('array', arr);
          this.arrayProduct = arr;
        })
        .catch(error => {});
    },
  },
  mounted() {
    this.getCatalogue();
  },
  filters: {
    currency: function(value) {
      return parseFloat(value).toFixed(2);
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

.logo-text {
  font-size: 30px;
}
.header {
  font-size: 25px;
  font-weight: 900;
  color: #6737ec;
}
.text-import {
  color: red;
  font-size: 50px;
}
.text-group {
  color: black;
  font-size: 60px;
}
.text-name {
  color: black;
  font-size: 30px;
}
.text-year {
  color: black;
  font-size: 40px;
}
.text-contact {
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
.subpage {
  padding: 1cm;
  height: 165.6mm;
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
