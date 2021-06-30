<template>
  <div>
    <div class="header-title">
      <h3 class="m-0">PRODUCTOS EN VENTA</h3>
    </div>
    <div class="content-product">
      <!-- <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="product-options pull-right text-right pull-none-xs">
          <i class="fa fa-angle-down"></i>
          <select>
            <option selected="" value="Default">Default Sorting</option>
            <option value="Larger">Newest Items</option>
            <option value="Larger">oldest Items</option>
            <option value="Larger">Hot Items</option>
            <option value="Small">Highest Price</option>
            <option value="Medium">Lowest Price</option>
          </select>
        </div>
      </div> -->
      <!-- .col-md-12 end -->
      <v-row class="row">
        <!-- Product #1 -->
        <v-col sm="6" md="3" cols="12" v-for="(p, pindex) in prodc" :key="pindex">
          <v-hover v-slot="{ hover }">
            <v-img
              :src="p.Picture[0].PicturePath"
              alt="Product"
              class="d-flex align-end"
              max-height="400 "
              contain
              v-if="p.Picture.length != 0 && p.Picture != null"
            >
              <div v-if="hover" class="d-flex mb-5 justify-center">
                <v-btn class="text-capitalize mx-1" color="#D22E2E" dark small elevation="0">
                  Add to Cart
                </v-btn>
                <v-btn class="text-capitalize mx-1" color="#D22E2E" dark small elevation="0">
                  Item Details
                </v-btn>
              </div>
            </v-img>

            <v-img
              src="https://i.pinimg.com/564x/61/f1/d9/61f1d99c883a79eccce91874c166ae06.jpg"
              alt="Product"
              class="d-flex align-end"
              max-height="400 "
              contain
              v-else
            >
              <div v-if="hover" class="d-flex mb-5 justify-center">
                <v-btn class="text-capitalize mx-1" color="#D22E2E" dark small elevation="0">
                  Add to Cart
                </v-btn>
                <v-btn
                  class="text-capitalize mx-1"
                  color="#D22E2E"
                  dark
                  small
                  elevation="0"
                  @click="toDetail(p.id)"
                >
                  Item Details
                </v-btn>
              </div>
            </v-img>
          </v-hover>
          <div class="text-center">
            <div class="mb-2 mt-5">
              Categoria
            </div>
            <div class="prodcut-title">
              <h3 class="my-2 text-uppercase">
                {{ p.Model }}
              </h3>
            </div>
            <div class="my-2 coin">S/. {{ p.SellingPrice | currency }}</div>
          </div>
          <!-- .product-bio end -->
        </v-col>
        <!-- .product end -->
      </v-row>
    </div>
  </div>
</template>
<script>
export default {
  data: () => ({
    icons: ['mdi-rewind', 'mdi-play', 'mdi-fast-forward'],
    transparent: 'rgba(255, 255, 255, 0)',
    prodc: [],
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
          console.log(response);
        })
        .catch(error => {});
    },
    toDetail(id) {
      this.$router.push({
        name: 'sellDetail',
        params: {
          id: id,
        },
      });
      this.dialog = false;
    },
  },
  mounted() {
    this.getList();
  },
  filters: {
    currency: function(value) {
      let n = value;
      if (value == null) {
        n = 0;
      }
      return parseFloat(n).toFixed(2);
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
<style scope>
@import url('https://fonts.googleapis.com/css2?family=Gothic+A1:wght@500&display=swap');

.header-title {
  padding: 3% 10%;
  background-color: #f5f5f5;
  letter-spacing: 2px;
}

.header-title h3 {
  letter-spacing: 2px;
}
.content-product {
  padding: 2% 10%;
}
.coin {
  font-weight: bold;
  color: #d22e2e;
  font-size: 18px;
}

.show-btns {
  color: rgba(255, 255, 255, 1) !important;
  background-color: #d22e2e;
}
@media (max-width: 960px) {
  .p-page-new {
    padding-right: 0;
    padding-left: 0;
  }
}
@media (max-width: 600px) {
  .p-page-new {
    padding-right: 0;
    padding-left: 0;
  }
}
@media (max-width: 360px) {
  .p-page-new {
    padding-right: 0;
    padding-left: 0;
  }
}
</style>
