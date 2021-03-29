<template>
  <v-col>
    <h3>Editar Concepto de Pago</h3>
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
                  v-on:keyup.enter="updateConcept"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-window-item>
    </v-window>
    <v-btn color="success" class="mr-4 mt-3" @click="updateConcept">
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
    getConcept() {
      axios
        .get(`/api/v1/payment-concepts/${this.$route.params.id}`)
        .then(response => {
          this.concept = response.data;
          console.log(response);
        })
        .catch(error => {});
    },
    updateConcept() {
      axios
        .put('/api/v1/payment-concepts', this.concept)
        .then(response => {
          this.$router.replace({ name: 'listConcept' });
        })
        .catch(error => {
          console.log(error);
        });
    },
  },
  mounted() {
    this.getConcept();
  },
};
</script>
