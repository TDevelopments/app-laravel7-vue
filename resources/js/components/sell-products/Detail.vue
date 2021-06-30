<template>
  <div>
    <div class="header-title">
      <h3 class="m-0">DETALLES DE PRODUCTO</h3>
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
        <v-col cols="12" sm="6" md="4">
          <v-img
            :src="prodc.Picture[0].PicturePath"
            alt="Product"
            width="500"
            max-height="500"
            contain
            v-if="prodc.Picture.length != 0 && prodc.Picture != null"
          >
          </v-img>

          <v-img
            src="https://i.pinimg.com/564x/61/f1/d9/61f1d99c883a79eccce91874c166ae06.jpg"
            alt="Product"
            width="500"
            max-height="500"
            contain
            v-else
          >
          </v-img>
        </v-col>
        <v-col class="p-0 letter-space">
          <div class="prodcut-title">
            <h3 class="my-2 text-uppercase">
              {{ prodc.Model }}
            </h3>
          </div>
          <div class="my-2 coin">S/. {{ prodc.SellingPrice | currency }}</div>
          <p class="mt-5 description">{{ prodc.ProductDescription }}</p>
          <div class="mb-2 mt-5">
            <h4><strong>OTROS DETALLES</strong></h4>
          </div>
          <div class="d-flex">
            <div class="title-more">Nombre:</div>
            <div class="ml-3">{{ prodc.ProductName }}</div>
          </div>
          <div class="d-flex">
            <div class="title-more">
              Codigo:
            </div>
            <div class="ml-3">#{{ prodc.Sku }}</div>
          </div>
          <div class="d-flex">
            <div class="title-more">Disponible:</div>
            <div class="ml-3">{{ prodc.ProductAvailable == true ? 'Si' : 'No' }}</div>
          </div>
          <div class="d-flex">
            <div class="title-more">Marca:</div>
            <div class="ml-3">{{ prodc.Brand.BrandName }}</div>
          </div>
          <div class="d-flex">
            <div class="title-more">Stock:</div>
            <div class="ml-3">{{ prodc.AvailableStock | stock }}</div>
          </div>
          <div class="d-flex other">
            <div class="title-more">Colores:</div>
            <v-row class="ml-3">
              <v-col v-for="(color, cindex) in prodc.Color" :key="cindex" class="1" cols="1">
                <v-avatar
                  class="border-avatar"
                  :color="color"
                  size="15"
                  @click="setColor(color)"
                ></v-avatar>
              </v-col>
            </v-row>
          </div>
          <div class="d-flex quantity">
            <div>Cantidad : {{ '  ' }}</div>
            <v-icon size="15" class="icon-border mr-1 ml-4" @click="minus">mdi-minus</v-icon>
            <input class="input-border mx-1" v-model="quantity" readonly />
            <v-icon size="15" class="icon-border mx-1" @click="plus">mdi-plus</v-icon>
            <v-btn
              class="button-quantity"
              color="#D22E2E"
              dark
              elevation="0"
              small
              @click="addToCart"
              >Add to Cart</v-btn
            >
          </div>
        </v-col>
      </v-row>
    </div>
  </div>
</template>
<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  data: () => ({
    icons: ['mdi-rewind', 'mdi-play', 'mdi-fast-forward'],
    transparent: 'rgba(255, 255, 255, 0)',
    prodc: {},
    quantity: 1,
    productColor: '',
    productSize: '',
  }),
  methods: {
    ...mapActions('groupSales', ['addCart']),
    getList() {
      axios
        .get(`/api/v1/sale-products/${this.$route.params.id}`)
        .then(response => {
          this.prodc = response.data.data;
          console.log(this.prodc);
        })
        .catch(error => {});
    },
    plus() {
      this.quantity++;
    },
    minus() {
      this.quantity--;
    },
    addToCart() {
      if (this.prodc.Color.length == 1) {
        this.productColor = this.prodc.Color[0];
      }
      if (this.productColor == '' || this.productColor == null) {
        alert('Tiene que seleccionar un color.');
      } else {
        let product = {};
        product.ProductId = this.prodc.id;
        product.Quantity = this.quantity;
        if (this.productColor != '' && this.productColor != null) {
          product.Color = this.productColor;
        }
        console.log('aqui');
        //   if (this.productSize != '' && this.productSize != null) {
        //     product.Size = this.productSize;
        //   }
        this.addCart(product);
      }
    },
    setColor(color) {
      this.productColor = color;
    },
    setSize(size) {
      this.productColor = size;
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
    stock: function(value) {
      if (value == null) {
        return '?';
      } else {
        for (const property in value) {
          console.log(property);
          if (property == 3) {
            return value[property];
          }
        }
      }
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
.description {
  border-bottom: 1px solid #eeeeee;
  padding-bottom: 30px;
}
.title-more {
  color: #d22e2e;
  font-weight: 900;
}
.letter-space {
  letter-spacing: 1px;
}
.border-avatar {
  border: 1px solid black !important;
}
.other {
  border-bottom: 1px solid #eeeeee;
  padding-bottom: 20px;
}
.icon-border {
  border: 2px solid black;
  width: 25px;
}
.input-border {
  border: 2px solid black;
  width: 28px;
  text-align: center;
}
.quantity {
  margin: 30px 0;
  padding-bottom: 30px;
  border-bottom: 1px solid #eeeeee;
}
.button-quantity {
  margin-left: 50px;
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
  .button-quantity {
    margin-left: 5px;
  }
}
</style>
