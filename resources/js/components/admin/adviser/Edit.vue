<template>
  <v-col>
    <h3>Editar Asesor</h3>
    <v-window class="elevation-1" vertical>
      <v-window-item>
        <v-card flat>
          <v-card-text>
            <v-row>
              <v-col cols="12" sm="6" md="6">
                Nombre
                <v-text-field
                  v-model="adviser.name"
                  solo
                  required
                  placeholder="Makoto"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                Telefono
                <v-text-field
                  v-model="adviser.phone"
                  solo
                  required
                  type="number"
                  placeholder="985632412"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                Link
                <v-text-field
                  v-model="adviser.link"
                  solo
                  required
                  placeholder="http://ejemplo.ejemplo"
                  v-on:keyup.enter="addAdviser"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-window-item>
    </v-window>
    <v-btn color="success" class="mr-4 mt-3" @click="updateAdviser">
      Guardar
    </v-btn>
  </v-col>
</template>
<script>
export default {
  data: () => ({
    valid: true,
    adviser: {
      name: '',
    },
  }),

  methods: {
    validate() {},
    getAdviser() {
      axios
        .get(`/api/v1/adviser/${this.$route.params.id}`)
        .then(response => {
          this.adviser = response.data.data;
          console.log(response);
        })
        .catch(error => {});
    },
    updateAdviser() {
      axios
        .put(`/api/v1/advisers/${this.$route.params.id}`, this.adviser)
        .then(response => {
          this.$router.replace({ name: 'listAdviser' });
        })
        .catch(error => {
          console.log(error);
        });
    },
  },
  mounted() {
    this.getAdviser();
  },
};
</script>
