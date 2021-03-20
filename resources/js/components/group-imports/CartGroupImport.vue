<template>
  <div class="mx-4">
    <v-row class="mt-3">
      <v-col cols="12" sm="12" md="9" lg="9">
        <v-card>
          <v-card-title>
            <v-row>
              <v-col>
                <p class="my-3 mx-3 title-car">Mi Carrito</p>
              </v-col>
              <v-col class="text-right my-auto">
                <v-btn class="text-capitalize mx-3" @click="emptyCart">
                  <v-icon class="mr-2">mdi-cart-off</v-icon> Vaciar</v-btn
                >
                <v-btn class="text-capitalize mx-3" @click="updateCart">
                  <v-icon class="mr-2">mdi-cart-off</v-icon> Actualizar</v-btn
                >
              </v-col>
            </v-row>
          </v-card-title>
          <v-card-text class="mx-3">
            <p>{{ cart.length }} Producto</p>
          </v-card-text>
          <div v-for="(catalogue, index) in cart" :key="index">
            <h3>{{ catalogue.name }}</h3>
            <div v-for="(product, index) in catalogue.products" :key="index">
              <Cart :product="product" :cart="cart"></Cart>
            </div>
          </div>
        </v-card>
      </v-col>
      <v-col cols="12" sm="12" md="3" lg="3">
        <v-card>
          <p class="py-3 px-3">Resumen de mi pedido</p>
          <div v-for="catalogue in cart" :key="catalogue.id">
            <p class="py-3 px-3">{{ catalogue.name }}</p>
            <p class="py-3 px-3">
              Total:
              {{
                catalogue.products.reduce(function(total, currentValue) {
                  let count = total + currentValue.total;
                  return count;
                }, 0)
              }}
            </p>
            <v-btn @click="generateOrderAction(catalogue)">
              Generar Orden
            </v-btn>
          </div>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>
<script>
import { mapActions, mapGetters, mapMutations } from "vuex";
import Cart from "./cart";

export default {
  components: {
    Cart
  },
  data: () => ({}),
  computed: {
    ...mapGetters("groupImport", ["cart"])
  },
  mounted() {},
  methods: {
    ...mapActions("groupImport", ["generateOrder"]),
    ...mapMutations("groupImport", ["setCart"]),
    updateCart() {
      this.setCart(this.cart);
    },
    emptyCart() {
      this.setCart([]);
    },
    generateOrderAction(catalogue) {
      let minimo = catalogue.minimum_investment;
      let total = catalogue.products.reduce(function(total, currentValue) {
        let count = total + currentValue.total;
        return count;
      }, 0);
      if (total < minimo) {
        return console.log("error");
      } else {
        this.generateOrder(catalogue);
      }
    }
  }
};
</script>
<style scoped>
.title-car {
  font-size: 35px;
}
.w {
  width: 15%;
}
</style>
