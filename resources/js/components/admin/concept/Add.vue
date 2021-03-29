<template>
  <v-col>
    <h3>Nuevo Concepto de Pago</h3>
    <v-window class="elevation-1" vertical>
      <v-window-item>
        <v-card flat>
          <v-card-text>
            <v-row>
              <v-col cols="12" sm="6" md="6">
                Nombre de Concepto de Pago
                <v-text-field
                  v-model="concept.name"
                  solo
                  required
                  placeholder="Example"
                  v-on:keyup.enter="addConcept"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-window-item>
    </v-window>
    <v-btn color="success" class="mr-4 mt-3" @click="addConcept">
      Guardar
    </v-btn>
  </v-col>
</template>

<script>
export default {
  data: () => ({
    valid: true,
    concept: {
      name: '',
    },
  }),
  methods: {
    validate() {},
    addConcept() {
      axios
        .post('/api/v1/payment-concepts', this.concept)
        .then(response => {
          this.$router.replace({ name: 'listConcept' });
        })
        .catch(error => {
          console.log(error);
        });
    },
  },
};
</script>
