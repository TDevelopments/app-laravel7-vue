<template>
  <div>
    <v-container class="mx-auto">
      <v-row class="mt-12">
        <v-col v-for="(item, index) in catalogues" :key="index">
          <v-card class="mx-auto" max-width="500">
            <v-img
              src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
              height="200px"
            ></v-img>

            <v-card-title>
              Catálogo &nbsp;<strong>{{ item.name }} </strong>
              <v-spacer></v-spacer>
              Moneda &nbsp;
              <v-avatar size="40" color="#0D52D6" class="text-white">{{
                item.coin == "soles" ? "S./" : "$"
              }}</v-avatar>
            </v-card-title>
            <v-card-text class="font-weight-medium pb-0 pt-1">
              <v-icon color="black">mdi-unfold-more-vertical</v-icon> Monto de
              Separación:
              <v-chip class="mr-2">
                <v-icon left> mdi-cash </v-icon>
                {{ item.quota_price | currency }}
              </v-chip>
            </v-card-text>
            <v-card-text class="font-weight-medium pb-0 pt-1">
              <v-icon color="black">mdi-unfold-more-vertical</v-icon> Fecha de
              Monto de Separación:
              <v-chip class="mr-2">
                <v-icon left> mdi-calendar-month </v-icon>

                {{ item.quota_date | date }}
              </v-chip>
            </v-card-text>
            <v-card-text class="font-weight-medium pb-0 pt-1">
              <v-icon color="black">mdi-unfold-more-vertical</v-icon> Minimo de
              Inversion:
              <v-chip class="mr-2">
                <v-icon left> mdi-cash </v-icon>
                {{ item.minimum_investment | currency }}
              </v-chip>
            </v-card-text>
            <v-card-text class="font-weight-medium pb-0 pt-1">
              <v-icon color="black">mdi-unfold-more-vertical</v-icon> % de
              Primera Cuota: {{ item.first_payment }}
              <v-chip class="mr-2">
                <v-icon left> mdi-percent </v-icon>
                {{ item.first_payment * 100 }}
              </v-chip>
            </v-card-text>
            <v-card-text class="font-weight-medium pb-0 pt-1">
              <v-icon color="black">mdi-unfold-more-vertical</v-icon> % de
              Segunda Cuota:
              <v-chip class="mr-2">
                <v-icon left> mdi-percent </v-icon>
                {{ item.second_payment * 100 }}
              </v-chip>
            </v-card-text>
            <v-card-text class="font-weight-medium pb-0 pt-1">
              <v-icon color="black">mdi-unfold-more-vertical</v-icon>
              Fecha Limite Primera Cuota:
              <v-chip class="mr-2">
                <v-icon left> mdi-calendar-month </v-icon>
                {{ item.date_first_payment | date }}
              </v-chip>
            </v-card-text>
            <v-card-text class="font-weight-medium pb-0 pt-1">
              <v-icon color="black">mdi-unfold-more-vertical</v-icon>
              Fecha Limite Segunda Cuota:
              <v-chip class="mr-2">
                <v-icon left> mdi-calendar-month </v-icon>
                {{ item.date_second_payment | date }}
              </v-chip>
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
