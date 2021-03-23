<template>
  <v-col>
    <h3>Nueva Unidad</h3>
    <v-window class="elevation-1" vertical>
      <v-window-item>
        <v-card flat>
          <v-card-text>
            <v-row>
              <v-col cols="12" sm="6" md="6">
                Nombre Unidad
                <v-text-field
                  v-model="measure.name"
                  solo
                  required
                  placeholder="Example"
                  v-on:keyup.enter="addMeasure"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-window-item>
    </v-window>
    <v-btn color="success" class="mr-4 mt-3" @click="addMeasure">
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
    addMeasure() {
      axios
        .post("/api/v1/measures", this.measure, {
          headers: {
            Accept: "application/json",
          },
        })
        .then((response) => {
          this.$router.replace({ name: "listMeasure" });
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>
