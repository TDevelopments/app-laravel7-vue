<template>
  <div class="m-page">
    <h1>Catalogo {{ catalogue.name }}</h1>
    <v-card class="mt-5" flat>
      <v-card-text>
        <v-row>
          <v-col
            cols="12"
            sm="12"
            md="3"
            ls="3"
            v-if="product.images == null || product.images.length == 0"
          >
            <v-img
              class="m-4"
              contain
              src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"
              elevation="12"
            />
          </v-col>
          <v-col v-else cols="12" sm="12" md="3" ls="3">
            <v-img
              class="m-4"
              contain
              :src="product.images[model].path"
              elevation="12"
              height="200"
            />
            <v-sheet class="mx-auto" elevation="8" max-width="800">
              <v-slide-group v-model="model" class="pa-4" show-arrows>
                <v-slide-item
                  v-for="(item, index) in product.images"
                  :key="index"
                  v-slot="{ active, toggle }"
                >
                  <v-img
                    class="m-2 ma-4"
                    contain
                    :src="item.path"
                    elevation="12"
                    height="50"
                    width="50"
                    @click="toggle"
                  />
                </v-slide-item>
              </v-slide-group>
            </v-sheet>
          </v-col>
          <v-col cols="12" sm="12" md="9" ls="9" class="p-0 bcard">
            <v-toolbar elevation="1" color="#1933AA" dark> Modelo {{ product.model }} </v-toolbar>
            <v-card-text class="mx-3">
              <ul v-for="(item, index) in product.description" :key="index">
                <li class="m-0 p-0">{{ item }}</li>
              </ul>
              <v-row>
                <p class="mt-1">Colores:</p>
                <div
                  cols="1"
                  class="ml-2 mt-1 p-0"
                  v-for="(item, index) in product.colors"
                  :key="index"
                >
                  <v-avatar size="15" :color="item"></v-avatar>
                </div>
              </v-row>
              <v-row>
                <v-col>
                  <strong>PRECIO POR {{ product.quantity_group }} U.</strong>
                  <div class="form-inline">
                    <v-avatar color="#1933AA" size="30" class="text-white mr-1 my-2">
                      {{ (catalogue.coin = 'soles' ? 'S./' : '$') }}
                    </v-avatar>
                    <p class="mt-3 ml-2 font-weight-bold">
                      {{ product.price_group | currency }}
                    </p>
                  </div>
                </v-col>
                <v-col>
                  <strong>PRECIO UNITARIO</strong>
                  <div class="form-inline">
                    <v-avatar color="#1933AA" size="30" class="text-white mr-1 my-2">
                      {{ (catalogue.coin = 'soles' ? 'S./' : '$') }}
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
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  data: () => ({
    model: 0,
  }),
  computed: {
    ...mapGetters('groupImport', ['product', 'catalogue']),
  },
  methods: {
    ...mapActions('groupImport', ['getProduct']),
  },
  mounted() {
    this.getProduct(this.$route.params);
  },
  filters: {
    currency: function(value) {
      return parseFloat(value).toFixed(2);
    },
  },
};
</script>

<style scope>
.bcard {
  border-style: solid;
  border-width: 1px;
  border-color: #1933aa;
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
}
@media (max-width: 500px) {
  .m-page {
    margin-right: auto;
    margin-left: auto;
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
</style>
