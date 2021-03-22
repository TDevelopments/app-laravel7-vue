<template>
  <v-dialog
    transition="dialog-bottom-transition"
    max-width="900"
    v-model="show"
  >
    <v-toolbar color="primary" dark class="text-h6 mb-2">Detalles del producto</v-toolbar>
    <v-card>
      <v-card-text>
        <v-row>
          <v-col cols="12" sm="12" md="6" lg="6">
            <v-img
              src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"
              contain
              v-if="product.images == null || product.images.length == 0"
            />
            <v-img
              :src="product.images[model].path"
              height="250"
              contain
              v-else
            />
            <v-sheet class="mx-auto" max-width="800">
              <v-slide-group v-model="model" class="pa-4" show-arrows>
                <v-slide-item
                  v-if="product.images == null || product.images.length == 0"
                  v-slot="{ active, toggle }"
                >
                  <v-img
                    src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"
                    max-width="70"
                    height="60"
                    contain
                    class="m-1"
                    @click="toggle"
                  />
                </v-slide-item>
                <v-slide-item
                  v-else
                  v-slot="{ active, toggle }"
                  v-for="(item, index) in product.images"
                  :key="index"
                >
                  <v-img
                    :src="item.path"
                    max-width="70"
                    height="60"
                    contain
                    class="m-1"
                    @click="toggle"
                  />
                </v-slide-item>
              </v-slide-group>
            </v-sheet>
          </v-col>
          <v-col cols="12" sm="12" md="6" lg="6">
            <v-card-text>
              <div class="my-4 text-h4">
                {{ product.model }}
              </div>
              <div>
                <p v-for="(item, index) in product.description" :key="index">
                  <v-icon color="black">mdi-unfold-more-vertical</v-icon>
                  {{ item }}
                </p>
              </div>
              <v-row>
                <v-col class="mt-3 pb-0 text-subtitle-1">
                  <strong>PRECIO POR {{ product.quantity_group }} {{ type_group.toUpperCase() }}</strong>
                  <div class="form-inline">
                    <v-avatar
                      color="#0D52D6"
                      size="35"
                      class="text-white mr-1 t-0"
                    >
                      {{ catalogue.coin == "soles" ? "S./" : "$" }}
                    </v-avatar>
                    <p class="mt-4 ml-2 font-weight-bold">
                      {{ product.price_group | currency }}
                    </p>
                  </div>
                </v-col>
                <v-col class="mt-5 pb-0">
                  <strong>PRECIO UNITARIO</strong>
                  <div class="form-inline">
                    <v-avatar
                      color="#0D52D6"
                      size="30"
                      class="text-white mr-1 my-2"
                    >
                      {{ catalogue.coin == "soles" ? "S./" : "$" }}
                    </v-avatar>
                    <p class="mt-3 ml-2">{{ product.price_unit | currency }}</p>
                  </div>
                </v-col>
              </v-row>
            </v-card-text>
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>
    </v-dialog>
  </v-col>
</template>
<script>
import { mapActions, mapGetters } from "vuex";

export default {
  props: ["product", "catalogue", "value"],
  data: () => ({
    quantity: 1,
    loading: false,
    selection: 1,
    model: 0,
  }),
  methods: {
    ...mapActions("groupImport", ["addCart"]),
    showProduct(product) {
      this.$router.push({
        name: "ProductDetail",
        params: {
          type: "product",
          sku: this.product.sku,
        },
      });
    },
    cartRoute() {
      this.$router.push({ name: "cartGroupImport" });
    },
    cartView() {
      this.$router.push({
        name: "cartGroupImport",
      });
    },
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
  computed: {
    show: {
      get() {
        return this.value;
      },
      set(value) {
        this.$emit("input", value);
      },
    },
    type_group(){
      let valor = '';
      if ( this.product.quantity_group > 1 ){
        valor = this.product.type_group;
      }else{
        switch (this.product.type_group) {
          case 'unidades':
            valor = 'unidades'
            break;
          case 'sets':
            valor = 'set'
            break;
          case 'cajas':
            valor = 'caja'
            break;
          default:
            break;
        } 
      }
      return valor;
    }
  },
  mounted() {
    // console.log("Component", this.product);
  },
};
</script>
<style scoped>
.v-img--offset {
  top: -24px;
  position: relative;
}
.w {
  width: 100%;
}
</style>
// <div class="mb-3 subtitle-1">
//           {{ catalogue.coin }} {{ product.price_group }}
//         </div>
