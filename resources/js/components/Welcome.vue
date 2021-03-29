<template>
  <v-app>
    <v-container>
      <v-row class="mt-5 justify-space-around align-center">
        <v-col cols="12" sm="12" md="5" lg="5">
          <v-card class="mx-auto rounded-xl" max-width="450" elevation="12" @click="showCatalogues">
            <v-img src="/images/import.jpg"> </v-img>
            <v-card-title>
              <div class="mx-auto" style="text-align: justify">
                <span class="text-h5">Importaciones Grupales</span>
              </div>
            </v-card-title>

            <v-card-text class="font-weight-bold px-5 py-5">
              Participa de nuestras importaciones Grupales, al menor precio de mercado, impotaciones
              directas de fabrica.
            </v-card-text>
            <v-card-actions>
              <v-btn color="blue" @click="showCatalogues" class="mx-auto" dark rounded>
                Ingresar
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
        <v-col cols="12" sm="12" md="5" lg="5">
          <v-card class="mx-auto rounded-xl" max-width="450" elevation="12">
            <v-img src="/images/sell.jpg"> </v-img>
            <v-card-title>
              <div class="mx-auto">
                <span class="text-h5">Productos en Stock</span>
              </div>
            </v-card-title>

            <v-card-text class="font-weight-bold px-5 py-5">
              "Productos a la venta por mayor. Listos para recojer o enviar."
              <br />
              <br />
            </v-card-text>
            <v-card-actions>
              <v-btn color="blue" class="mx-auto" dark rounded> Ingresar </v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-app>
</template>

<script>
export default {
  data: () => ({
    show1: false,
    show2: false,
  }),
  methods: {
    showCatalogues() {
      this.$router.push({ name: 'group-import' });
    },
  },
};
</script>
