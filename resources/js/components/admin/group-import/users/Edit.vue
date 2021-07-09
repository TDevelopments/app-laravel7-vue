<template>
  <div v-if="spinnerLoading">
    <Spinner />
  </div>
  <v-col v-else>
    <v-card flat>
      <v-card-text>
        <h3>Editar Nuevo Usuario</h3>
        <p>(*) Campos Obligatorios</p>
        <v-divider></v-divider>
        <v-form ref="form" v-model="valid" lazy-validation>
          <v-row>
            <v-col cols="12" sm="8" md="8">
              <v-row>
                <v-col cols="12" sm="6" md="6">
                  Nombre (*)
                  <v-text-field v-model="user.name" solo required></v-text-field>
                </v-col>
                <!-- <v-col cols="12" sm="6" md="6">
                  Apellidos (*)
                  <v-text-field v-model="user.lastname" solo required></v-text-field>
                </v-col> -->
                <v-col cols="12" sm="6" md="6">
                  Email (*)
                  <v-text-field v-model="user.email" solo></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                  Rol de Usuario
                  <v-select
                    v-model="roles"
                    :items="rol_user"
                    item-text="name"
                    item-value="name"
                    label="Select"
                    multiple
                    chips
                    solo
                    persistent-hint
                  >
                  </v-select>
                </v-col>
                <!-- <v-col cols="12" sm="6" md="6">
                  Contraseña (*)
                  <v-text-field v-model="user.password" solo></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                  Confirmar Contraseña (*)
                  <v-text-field
                    v-model="user.password_confirmation"
                    solo
                  ></v-text-field>
                </v-col> -->
                <v-col cols="12" sm="6" md="6">
                  Dirección
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
                  Cuidad (*)
                  <v-text-field v-model="user.city" solo required></v-text-field>
                </v-col>
              </v-row>
            </v-col>
          </v-row>
        </v-form>
      </v-card-text>
    </v-card>
    <v-row class="mt-3">
      <v-spacer></v-spacer>
      <div>
        <v-btn :disabled="!valid" color="#0D52D6" class="mr-3" @click="validate" dark>
          <v-icon class="mr-2">mdi-content-save</v-icon> Guardar
        </v-btn>
      </div>
    </v-row>
    <ModalSave v-model="dialogSave" v-if="dialogSave" />
    <ModalError v-model="dialogError" v-if="dialogError" :body="message" />
  </v-col>
</template>
<script>
import axios from 'axios';
import ModalSave from '../component/ModalSave';
import ModalError from '../component/ModalError';
import Spinner from '../component/SpinnerLoading';
import { citiesPeru } from './constanst';

export default {
  components: {
    ModalSave,
    ModalError,
    Spinner,
  },
  data: () => ({
    roles: [],
    rol_user: [],
    valid: true,
    user: {},
    cities: citiesPeru,
    dialogSave: false,
    dialogError: false,
    spinnerLoading: true,
    message: '',
  }),
  mounted() {
    this.getUser();
    this.getRoles();
  },
  methods: {
    validate() {
      this.dialogSave = true;
      this.updateUser();
    },
    getRoles() {
      axios
        .get('/api/v1/roles')
        .then(response => {
          this.rol_user = response.data.data;
        })
        .catch(error => {});
    },
    getUser() {
      axios
        .get(`/api/v1/users/${this.$route.params.id}`)
        .then(response => {
          this.user = response.data.data;
          response.data.data.roles.forEach((element, index) => {
            this.roles.push(element.name);
          });
          this.spinnerLoading = false;
        })
        .catch(error => {
          this.dialogSave = false;
          this.message = 'Ocurrio un error al obtener los datos.';
          this.dialogError = true;
        });
    },
    updateUser() {
      let data = {};
      for (const property in this.user) {
        if (this.user[property] != null && this.user[property] != '' ) {
          data.[property] = this.user[property];
        }
      }
      data.roles = this.roles;

      axios
        .put(`/api/v1/users/${this.$route.params.id}`, data)
        .then(response => {
          this.dialogSave = false;
          this.$router.replace({ name: 'listUser' });
        })
        .catch(error => {
          this.dialogSave = false;
          this.message =
            'Ocurrio un error al guardar los datos generales, verifique que todos los datos necesarioes esten completos y vuelva a intentarlo';
          this.dialogError = true;
        });
    },
    reset() {
      this.$refs.form.reset();
    },
    resetValidation() {
      this.$refs.form.resetValidation();
    },
  },
};
</script>
