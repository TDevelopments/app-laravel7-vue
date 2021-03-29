<template>
  <v-col>
    <h3>Editar Bank</h3>
    <v-window class="elevation-1" vertical>
      <v-window-item>
        <v-card flat>
          <v-card-text>
            <v-row>
              <v-col cols="12" sm="6" md="6">
                Nombre de Bank
                <v-text-field
                  v-model="bank.name"
                  solo
                  required
                  placeholder="Example"
                  v-on:keyup.enter="updateBank"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                Nombre Corto
                <v-text-field
                  v-model="bank.short_name"
                  solo
                  required
                  placeholder="Example"
                  v-on:keyup.enter="addBank"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-window-item>
    </v-window>
    <v-btn color="success" class="mr-4 mt-3" @click="updateBank">
      Guardar
    </v-btn>
  </v-col>
</template>
<script>
export default {
  data: () => ({
    valid: true,
    bank: {
      name: '',
    },
  }),

  methods: {
    validate() {},
    getBank() {
      axios
        .get(`/api/v1/banks/${this.$route.params.id}`)
        .then(response => {
          this.bank = response.data;
          console.log(response);
        })
        .catch(error => {});
    },
    updateBank() {
      axios
        .put(`/api/v1/banks/${this.$route.params.id}`, this.bank)
        .then(response => {
          this.$router.replace({ name: 'listBank' });
        })
        .catch(error => {
          console.log(error);
        });
    },
  },
  mounted() {
    this.getBank();
  },
};
</script>
