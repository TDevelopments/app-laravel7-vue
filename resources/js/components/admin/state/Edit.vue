<template>
  <v-col>
    <h3>Editar Estado de Orden</h3>
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
                  v-on:keyup.enter="updateState"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-window-item>
    </v-window>
    <v-btn color="success" class="mr-4 mt-3" @click="updateState">
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
    getState() {
      axios
        .get(`/api/v1/state-orders/${this.$route.params.id}`)
        .then(response => {
          this.state = response.data;
          console.log(response);
        })
        .catch(error => {});
    },
    updateState() {
      axios
        .put('/api/v1/state-orders', this.state)
        .then(response => {
          this.$router.replace({ name: 'listState' });
        })
        .catch(error => {
          console.log(error);
        });
    },
  },
  mounted() {
    this.getState();
  },
};
</script>
