<template>
  <div>
    <v-container class="mx-auto">
      <v-row class="mt-5">
        <v-col v-for="(item, index) in catalogues" :key="index" cols="12" sm="12" md="6" lg="6">
          <v-card class="mx-auto" max-width="500">
            <v-img
              src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
              height="200px"
            ></v-img>

            <v-card-title>
              <v-row>
                <v-col cols="12">
                  Catálogo &nbsp;<strong>{{ item.name }} </strong>
                  <v-spacer></v-spacer>
                </v-col>
                <v-col cols="12">
                  Moneda &nbsp;
                  <v-avatar size="40" color="#0D52D6" class="text-white">{{
                    item.coin == "soles" ? "S./" : "$"
                  }}</v-avatar>
                </v-col>
              </v-row>
            </v-card-title>
            <v-card-text class="font-weight-medium pb-0 pt-1">
              <v-row>
                <v-col cols="12" sm="8">
                  <v-icon color="black" x-small>mdi-circle</v-icon>
                  Monto de separación de cupo:
                </v-col>
                <v-col cols="12" sm="4" class="text-right">
                  <v-chip class="mr-2">
                    <v-icon left> mdi-cash </v-icon>
                    {{ item.quota_price | currency }}
                  </v-chip>
                </v-col>
              </v-row>
            </v-card-text>
            <v-card-text class="font-weight-medium pb-0 pt-1">
              <v-row>
                <v-col cols="12" sm="8">
                  <v-icon color="black" x-small>mdi-circle</v-icon>
                  Ultimo día para la separación de cupo:
                </v-col>
                <v-col cols="12" sm="4" class="text-right">
                  <v-chip class="mr-2">
                    <v-icon left> mdi-calendar-month </v-icon>
                    {{ item.quota_date | date }}
                  </v-chip>
                </v-col>
              </v-row>
            </v-card-text>
            <v-card-text class="font-weight-medium pb-0 pt-1">
              <v-row>
                <v-col cols="12" sm="8">
                  <v-icon color="black" x-small>mdi-circle</v-icon>
                  Inversión minima:
                </v-col>
                <v-col cols="12" sm="4" class="text-right">
                  <v-chip class="mr-2">
                    <v-icon left> mdi-cash </v-icon>
                    {{ item.minimum_investment | currency }}
                  </v-chip>
                </v-col>
              </v-row>
            </v-card-text>
            <v-card-text class="font-weight-medium pb-0 pt-1">
              <v-row>
                <v-col cols="12" sm="8">
                  <v-icon color="black" x-small>mdi-circle</v-icon> % de
                  Primera cuota:
                </v-col>
                <v-col cols="12" sm="4" class="text-right">
                  <v-chip class="mr-2">
                    <v-icon left> mdi-percent </v-icon>
                    {{ item.first_payment }}
                  </v-chip>
                </v-col>
              </v-row>
            </v-card-text>
            <v-card-text class="font-weight-medium pb-0 pt-1">
              <v-row>
                <v-col cols="12" sm="8">
                  <v-icon color="black" x-small>mdi-circle</v-icon> % de
                  Segunda cuota:
                </v-col>
                <v-col cols="12" sm="4" class="text-right">
                  <v-chip class="mr-2">
                    <v-icon left> mdi-percent </v-icon>
                    {{ item.second_payment }}
                  </v-chip>
                </v-col>
              </v-row>
            </v-card-text>
            <v-card-text class="font-weight-medium pb-0 pt-1">
              <v-row>
                <v-col cols="12" sm="8">
                  <v-icon color="black" x-small>mdi-circle</v-icon>
                  Fecha limite para el pago de la primera cuota:
                </v-col>
                <v-col cols="12" sm="4" class="text-right">
                  <v-chip class="mr-2">
                    <v-icon left> mdi-calendar-month </v-icon>
                    {{ item.date_first_payment | date }}
                  </v-chip>
                </v-col>
              </v-row>
            </v-card-text>
            <v-card-text class="font-weight-medium pb-0 pt-1">
              <v-row>
                <v-col cols="12" sm="8">
                  <v-icon color="black" x-small>mdi-circle</v-icon>
                  Fecha Limite Segunda Cuota:
                </v-col>
                <v-col cols="12" sm="4" class="text-right">
                  <v-chip class="mr-2">
                    <v-icon left> mdi-calendar-month </v-icon>
                    {{ item.date_second_payment | date }}
                  </v-chip>
                </v-col>
              </v-row>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="#0D52D6" text @click="showProduct(item)">
                Ver Productos
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import moment from "moment";

export default {
  data: () => ({}),
  computed: {
    ...mapGetters("groupImport", ["catalogues", "cart"]),
  },
  methods: {
    ...mapActions("groupImport", ["getCatalogues"]),
    showProduct(item) {
      this.$router.push({
        name: "listProductforCatalogue",
        params: {
          id: item.id,
        },
      });
    },
  },
  mounted() {
    this.getCatalogues();
  },
  filters: {
    currency: function (value) {
      return parseFloat(value).toFixed(2);
      moment(element.arrival_date).format("YYYY-MM-DD");
    },
    date: function (value) {
      return moment(value).format("YYYY-MM-DD");
    },
    porcent: function (value) {
      return parseFloat(value) * 100 + " %";
    },
  },
};
</script>
<style scoped>
* {
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}
</style>
