<template>
  <v-col>
    <v-window class="elevation-1" vertical>
      <v-window-item>
        <v-card flat>
          <v-card-text>
            <h3>Editar Unidad</h3>
            <v-divider></v-divider>
            <v-row>
              <v-col cols="12" sm="6" md="6">
                Nombre de Unidad
                <v-text-field
                  v-model="measure.name"
                  solo
                  required
                  v-on:keyup.enter="udpdateMeasure"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-window-item>
    </v-window>
    <v-btn color="success" class="mr-4" @click="udpdateMeasure">
      Guardar
    </v-btn>
  </v-col>
</template>

<script>
export default {
  data: () => ({
    valid: true,
    measure: {
      name: "",
    },
  }),

  methods: {
    validate() {
      console.log(this.arrivalsDates);
    },
    getmeasure() {
      axios
        .get(`/api/v1/measures/${this.$route.params.id}`)
        .then((response) => {
          this.measure = response.data;
        })
        .catch((error) => {});
    },
    udpdateMeasure() {
      axios
        .put(`/api/v1/measures/${this.$route.params.id}`, this.measure, {
          headers: {
            Accept: "application/json",
          },
        })
        .then((response) => {
          this.$router.replace({ name: "listMeasure" });
        })
        .catch((error) => {});
    },
  },
  mounted() {
    this.getmeasure();
  },
};
</script>
