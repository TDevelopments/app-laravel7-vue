<template>
  <div class="m-page">
    <v-card flat>
      <v-card-text>
        <h3>Administrar Mi Perfil</h3>
        <p>(*) Campos Obligatorios</p>
        <v-divider></v-divider>
        <v-form ref="form" v-model="valid" lazy-validation>
          <v-row>
            <v-col cols="12" sm="8" md="8">
              <v-row>
                <v-col cols="12" sm="6" md="6">
                  Nombre Completo (*)
                  <v-text-field v-model="user.name" solo required></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                  Email (*)
                  <v-text-field v-model="user.email" solo></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                  Dirección (*)
                  <v-text-field v-model="user.address" solo></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                  Teléfono (*)
                  <v-text-field v-model="user.phone" solo type="number"></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                  DNI (*)
                  <v-text-field v-model="user.dni" solo type="number"></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                  RUC
                  <v-text-field v-model="user.ruc" type="number" solo required></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                  Género
                  <v-select
                    v-model="user.gender"
                    :items="gender"
                    item-text="name"
                    item-value="send"
                    menu-props="auto"
                    solo-details
                    solo
                    prepend-inner-icon="mdi-gender-male-female"
                  ></v-select>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                  Cuidad (*)
                  <v-text-field
                    v-model="user.city"
                    solo
                    required
                    class="text-capitlalize"
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-col>
          </v-row>
        </v-form>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
export default {
  data: () => ({
    states: ['masculine', 'female'],
    cities: ['Arequipa', 'Lima'],
    userDetail: {},
    valid: '',
    gender: [
      {
        name: 'Masculino',
        send: 'masculine',
      },
      {
        name: 'Femenino',
        send: 'female',
      },
    ],
  }),
  computed: {
    ...mapGetters('account', ['user']),
    setDataUser() {
      return (this.userDetail = this.user);
    },
  },
  methods: {
    ...mapActions('account', ['updateUser', 'getUser']),
    onSubmit() {
      this.updateUser(this.userDetail);
    },
  },
  created() {},
  mounted() {},
};
</script>

<style>
.m-page {
  margin-right: 10%;
  margin-left: 10%;
}
.p-page {
  padding-right: 10%;
  padding-left: 10%;
}
</style>
