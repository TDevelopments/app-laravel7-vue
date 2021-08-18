<template>
  <div>
    <div class="header-title">
      <h3 class="m-0">CATÁLOGOS DISPONIBLES</h3>
    </div>
    <div class="content-product">
      <v-row class="mt-5">
        <v-col
          v-for="(item, index) in catalogues"
          :key="index"
          cols="12"
          sm="12"
          md="6"
          lg="6"
          class="mx-auto"
        >
          <v-card class="mx-auto" max-width="650">
            <v-img
              v-if="item.image == null || item.image.length == 0"
              src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
              height="200px"
              contain
              class="m-1"
            />
            <v-img v-else contain :src="item.image.path" height="400px" />
            <v-card-title class="justify-center py-3">
              <v-btn color="#0D52D6" @click="showProduct(item)" rounded dark>
                Ver Productos
              </v-btn>
            </v-card-title>
            <v-card-title class="pt-0">
              <v-row>
                <v-col cols="12" class="pb-0">
                  <strong>{{ item.name }} </strong>
                  <v-spacer></v-spacer>
                </v-col>
              </v-row>
            </v-card-title>
            <v-card-text class="font-weight-medium pb-0 pt-1">
              <v-row>
                <v-col sm="6" md="8">
                  <v-icon color="black" x-small>mdi-circle</v-icon>
                  Monto de separación de cupo:
                </v-col>
                <v-col sm="6" md="4" class="text-right">
                  <v-chip class="mr-2">
                    {{ item.coin == 'soles' ? 'S./' : '$' }}
                    {{ item.quota_price | currency }}
                  </v-chip>
                </v-col>
              </v-row>
            </v-card-text>
            <v-card-text class="font-weight-medium pb-0 pt-1">
              <v-row>
                <v-col sm="6" md="8">
                  <v-icon color="black" x-small>mdi-circle</v-icon>
                  Inversión minima:
                </v-col>
                <v-col sm="6" md="4" class="text-right">
                  <v-chip class="mr-2">
                    {{ item.coin == 'soles' ? 'S./' : '$' }}
                    {{ item.minimum_investment | currency }}
                  </v-chip>
                </v-col>
              </v-row>
            </v-card-text>
            <v-card-text class="font-weight-medium pb-0 pt-1">
              <v-row>
                <v-col sm="6" md="8">
                  <v-icon color="black" x-small>mdi-circle</v-icon> % de Primera cuota:
                </v-col>
                <v-col sm="6" md="4" class="text-right">
                  <v-chip class="mr-2">
                    <v-icon left> mdi-percent </v-icon>
                    {{ item.first_payment }}
                  </v-chip>
                </v-col>
              </v-row>
            </v-card-text>
            <v-card-text class="font-weight-medium pb-0 pt-1">
              <v-row>
                <v-col sm="6" md="8">
                  <v-icon color="black" x-small>mdi-circle</v-icon> % de Segunda cuota:
                </v-col>
                <v-col sm="6" md="4" class="text-right">
                  <v-chip class="mr-2">
                    <v-icon left> mdi-percent </v-icon>
                    {{ item.second_payment }}
                  </v-chip>
                </v-col>
              </v-row>
            </v-card-text>
            <v-card-title>
              <v-row>
                <v-col cols="12" class="pt-0"> Fechas </v-col>
              </v-row>
            </v-card-title>
            <v-card-text class="font-weight-medium pb-0 pt-1">
              <v-row>
                <v-col sm="6" md="8">
                  <v-icon color="black" x-small>mdi-circle</v-icon>
                  Ultimo día para la separación de cupo:
                </v-col>
                <v-col sm="6" md="4" class="text-right">
                  <v-chip class="mr-2">
                    <v-icon left> mdi-calendar-month </v-icon>
                    {{ item.quota_date | date }}
                  </v-chip>
                </v-col>
              </v-row>
            </v-card-text>
            <v-card-text class="font-weight-medium pb-0 pt-1">
              <v-row>
                <v-col sm="6" md="8">
                  <v-icon color="black" x-small>mdi-circle</v-icon>
                  Fecha limite para el pago de la primera cuota:
                </v-col>
                <v-col sm="6" md="4" class="text-right">
                  <v-chip class="mr-2">
                    <v-icon left> mdi-calendar-month </v-icon>
                    {{ item.date_first_payment | date }}
                  </v-chip>
                </v-col>
              </v-row>
            </v-card-text>
            <v-card-text class="font-weight-medium pb-0 pt-1">
              <v-row>
                <v-col sm="6" md="8">
                  <v-icon color="black" x-small>mdi-circle</v-icon>
                  Fecha limite para el pago de la segunda cuota:
                </v-col>
                <v-col sm="6" md="4" class="text-right">
                  <v-chip class="mr-2">
                    <v-icon left> mdi-calendar-month </v-icon>
                    {{ item.date_second_payment | date }}
                  </v-chip>
                </v-col>
              </v-row>
            </v-card-text>
            <v-card-text
              class="font-weight-medium pb-0 pt-1"
              v-for="(arrival, index) in item.arrivals"
              :key="index"
            >
              <v-row>
                <v-col sm="6" md="8">
                  <v-icon color="black" x-small>mdi-circle</v-icon>
                  Fecha estimada para recojos y envios desde {{ arrival.city }}
                </v-col>
                <v-col sm="6" md="4" class="text-right">
                  <v-chip class="mr-2">
                    <v-icon left> mdi-calendar-month </v-icon>
                    {{ arrival.arrival_date | date }}
                  </v-chip>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </div>
  </div>
</template>
<script>
import { mapGetters, mapActions } from 'vuex';
import moment from 'moment';

export default {
  data: () => ({}),
  computed: {
    ...mapGetters('groupImport', ['catalogues', 'cart']),
  },
  methods: {
    ...mapActions('groupImport', ['getCatalogues']),
    showProduct(item) {
      this.$router.push({
        name: 'listProductforCatalogue',
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
    currency: function(value) {
      return parseFloat(value).toFixed(2);
      moment(element.arrival_date).format('YYYY-MM-DD');
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
