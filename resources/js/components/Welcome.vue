<template>
  <div>
    <v-container>
      <v-row class="mt-5">
        <v-col cols="12" sm="12" md="6" lg="6">
          <v-card class="mx-auto" max-width="500">
            <v-card-title>
              <div class="mx-auto">
                <v-icon class="my-5" left> mdi-twitter </v-icon>
                <span>Importaciones Grupales</span>
              </div>
            </v-card-title>

            <v-card-text class="font-weight-bold px-5 py-5">
              "Turns out semicolon-less style is easier and safer in TS because
              most gotcha edge cases are type invalid as well."
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions class="pl-2">
              <v-btn color="orange" text @click="showCatalogues">
                Ver Catalogos
              </v-btn>

              <v-spacer></v-spacer>

              <v-btn icon @click="show1 = !show1">
                <v-icon>{{
                  show1 ? "mdi-chevron-up" : "mdi-chevron-down"
                }}</v-icon>
              </v-btn>
            </v-card-actions>

            <v-expand-transition>
              <div v-show="show1">
                <v-divider></v-divider>

                <v-card-text class="px-5 py-5">
                  I'm a thing. But, like most politicians, he promised more than
                  he could deliver. You won't have time for sleeping, soldier,
                  not with all the bed making you'll be doing. Then we'll go
                  with that data file! Hey, you add a one and two zeros to that
                  or we walk! You're going to do his laundry? I've got to find a
                  way to escape.
                </v-card-text>
              </div>
            </v-expand-transition>
          </v-card>
        </v-col>
        <v-col cols="12" sm="12" md="6" lg="6">
          <v-card class="mx-auto" max-width="500">
            <v-card-title>
              <div class="mx-auto">
                <v-icon class="my-5" left> mdi-twitter </v-icon>
                <span>Venta de Prodcutos</span>
              </div>
            </v-card-title>

            <v-card-text class="font-weight-bold px-5 py-5">
              "Turns out semicolon-less style is easier and safer in TS because
              most gotcha edge cases are type invalid as well."
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions class="pl-2">
              <v-btn color="orange" text> Ver </v-btn>

              <v-spacer></v-spacer>

              <v-btn icon @click="show2 = !show2">
                <v-icon>{{
                  show2 ? "mdi-chevron-up" : "mdi-chevron-down"
                }}</v-icon>
              </v-btn>
            </v-card-actions>

            <v-expand-transition>
              <div v-show="show2">
                <v-divider></v-divider>

                <v-card-text class="px-5 py-5">
                  I'm a thing. But, like most politicians, he promised more than
                  he could deliver. You won't have time for sleeping, soldier,
                  not with all the bed making you'll be doing. Then we'll go
                  with that data file! Hey, you add a one and two zeros to that
                  or we walk! You're going to do his laundry? I've got to find a
                  way to escape.
                </v-card-text>
              </div>
            </v-expand-transition>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
export default {
  data: () => ({
    show1: false,
    show2: false,
  }),
  methods: {
    showCatalogues() {
      this.$router.push({ name: "group-import" });
    },
  },
};
</script>
