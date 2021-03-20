<template>
  <div>
    <v-col cols="auto">
      <v-dialog transition="dialog-bottom-transition" max-width="600" v-model="show">
        <v-card>
          <v-toolbar color="primary" dark
            >Opening from the bottom {{ product.model }}</v-toolbar
          >
          <v-card-text>
            
          </v-card-text>
        </v-card>
      </v-dialog>
    </v-col>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";

export default {
  props: [
    "product",
    "catalogue",
    "value"
  ],
  data: () => ({
    quantity: 1,
    loading: false,
    selection: 1,
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
  },
  mounted(){
    console.log("Component",this.product);
  }
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
