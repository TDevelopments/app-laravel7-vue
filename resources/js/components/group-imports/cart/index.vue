<template>
  <v-card-text class="mx-3">
    <v-row>
      <v-col cols="12" sm="12" md="3">
        <v-img
          v-if="product.images == null || product.images.length == 0"
          max-height="150"
          max-width="250"
          contain
          src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"
        ></v-img>
        <v-img
          v-else
          max-height="250"
          max-width="150"
          contain
          :src="product.images[0].path"
        ></v-img>
      </v-col>
      <v-col cols="12" sm="12" md="6">
        <h5>Cateras : {{ product.sku }}</h5>
        <p class="mb-0">Precio Grupal: S/. {{ product.price_group }}</p>
        <p>Precio unitrario: S/. {{ product.price_unit }}</p>
        <p>Cantidad Mínima: {{ product.quantity_group }}</p>
        <!-- <p>Total: {{ (product.price_unit * product.quantity).toFixed(2) }}</p> -->
        <p>Total: {{ product.total.toFixed(2) }}</p>
        <v-text-field
          class="w"
          solo
          dense
          append-outer-icon="mdi-plus"
          prepend-icon="mdi-minus"
          v-model="quantity"
          type="number"
          readonly
          @click:append-outer="plusFunctionO"
          @click:prepend="minusFunction"
        ></v-text-field>
      </v-col>
      <v-col cols="12" sm="12" md="3">
        <v-btn @click="productDetail">Ver Producto</v-btn>
        <v-btn
          @click="
            removeCart({ product: product.id, catalogue: product.catalogue_id })
          "
          >Remover</v-btn
        >
      </v-col>
    </v-row>
  </v-card-text>
</template>

<script>
import { mapActions, mapMutations } from "vuex";
export default {
  props: ["product", "cart"],
  data: () => ({}),
  computed: {
    quantity() {
      let min = this.product.quantity_group;
      let value = this.product.quantity;
      if (this.product.quantity < min) {
        value = min;
        this.product.quantity = min;
      }
      this.product.total = value * this.product.price_unit;
      this.setCart(this.cart);
      return value;
    }
  },
  methods: {
    ...mapActions("groupImport", ["removeCart"]),
    ...mapMutations("groupImport", ["setCart"]),
    minusFunction() {
      this.product.quantity--;
    },
    plusFunctionO() {
      this.product.quantity++;
    },
    productDetail() {
      this.$router.push({
        name: "ProductDetail",
        params: {
          id: this.product.catalogue_id,
          type: "product",
          sku: this.product.sku
        }
      });
    }
  }
};
</script>

<style scoped>
.title-car {
  font-size: 35px;
}
.w {
  width: 25%;
}
</style>
