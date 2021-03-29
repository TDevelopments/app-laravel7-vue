<template>
  <v-col>
    <h3>Nuevo Estado de Orden</h3>
    <v-window class="elevation-1" vertical>
      <v-window-item>
        <v-card flat>
          <v-card-text>
            <v-row>
              <v-col cols="12" sm="6" md="6">
                Nombre de Estado de Orden
                <v-text-field
                  v-model="state.name"
                  solo
                  required
                  placeholder="Example"
                  v-on:keyup.enter="addState"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-window-item>
    </v-window>
    <v-btn color="success" class="mr-4 mt-3" @click="addState">
      Guardar
    </v-btn>
  </v-col>
</template>

<script>
export default {
  data: () => ({
    valid: true,
    state: {
      name: '',
    },
  }),
  methods: {
    validate() {},
    addState() {
      axios
        .post('/api/v1/state-orders', this.state)
        .then(response => {
          this.$router.replace({ name: 'listState' });
        })
        .catch(error => {
          console.log(error);
        });
    },
  },
};
</script>
