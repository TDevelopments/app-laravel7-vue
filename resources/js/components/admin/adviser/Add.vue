<template>
  <v-col>
    <h3>Nuevo Asesor</h3>
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
    <v-btn color="success" class="mr-4 mt-3" @click="addAdviser">
      Guardar
    </v-btn>
  </v-col>
</template>

<script>
export default {
  data: () => ({
    valid: true,
    adviser: {},
  }),
  methods: {
    validate() {},
    addAdviser() {
      axios
        .post('/api/v1/advisers', this.adviser)
        .then(response => {
          this.$router.replace({ name: 'listAdviser' });
        })
        .catch(error => {
          console.log(error);
        });
    },
  },
};
</script>
