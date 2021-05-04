<template>
  <v-col>
    <h3>Nuevo Banco</h3>
    <v-window class="elevation-1" vertical>
      <v-window-item>
        <v-card flat>
          <v-card-text>
            <v-row>
              <v-col cols="12" sm="6" md="6">
                Nombre de Banco
                <v-text-field
                  v-model="bank.name"
                  solo
                  required
                  placeholder="Example"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                Nombre Corto
                <v-text-field
                  v-model="bank.short_name"
                  solo
                  required
                  placeholder="Example"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                Nombre de la Cuenta Soles
                <v-text-field
                  v-model="bank.account_name"
                  solo
                  required
                  placeholder="Example"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                Cuenta en Soles
                <v-text-field
                  v-model="bank.account_soles"
                  solo
                  required
                  placeholder="Example"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                Cuenta Interbancaria en Soles
                <v-text-field
                  v-model="bank.account_interbank_soles"
                  solo
                  required
                  placeholder="Example"
                ></v-text-field>
              </v-col>

              <v-col cols="12" sm="6" md="6">
                Cuenta en Dolares
                <v-text-field
                  v-model="bank.account_dollar"
                  solo
                  required
                  placeholder="Example"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                Cuenta Interbancaria en Dolares
                <v-text-field
                  v-model="bank.account_interbank_dollar"
                  solo
                  required
                  placeholder="Example"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-window-item>
    </v-window>
    <v-btn color="success" class="mr-4 mt-3" @click="addBank">
      Guardar
    </v-btn>
  </v-col>
</template>

<script>
export default {
  data: () => ({
    valid: true,
    bank: {},
  }),
  methods: {
    validate() {},
    addBank() {
      axios
        .post('/api/v1/banks', this.bank)
        .then(response => {
          this.$router.replace({ name: 'listBank' });
        })
        .catch(error => {
          console.log(error);
        });
    },
  },
};
</script>
