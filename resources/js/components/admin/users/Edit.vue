<template>
  <v-col>
    <v-card flat>
      <v-card-text>
        <h3>Añadir Nuevo Usuario</h3>
        <p>(*) Campos Obligatorios</p>
        <v-divider></v-divider>
        <v-form ref="form" v-model="valid" lazy-validation>
          <v-row>
            <v-col cols="12" sm="8" md="8">
              <v-row>
                <v-col cols="12" sm="6" md="6">
                  Nombre (*)
                  <v-text-field
                    v-model="user.name"
                    solo
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                  Apellidos (*)
                  <v-text-field
                    v-model="user.lastname"
                    solo
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                  Email (*)
                  <v-text-field v-model="user.email" solo></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                  Rol de Usuario
                  <v-select
                    v-model="user.roles"
                    :items="rol_user"
                    item-text="name"
                    item-value="id"
                    menu-props="auto"
                    solo-details
                    solo
                    prepend-inner-icon="mdi-shield-account"
                  ></v-select>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                  Contraseña (*)
                  <v-text-field v-model="user.password" solo></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                  Confirmar Contraseña (*)
                  <v-text-field
                    v-model="user.password_confirmation"
                    solo
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                  Dirección (*)
                  <v-text-field v-model="user.address" solo></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                  Teléfono (*)
                  <v-text-field
                    v-model="user.phone"
                    solo
                    type="number"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                  DNI (*)
                  <v-text-field
                    v-model="user.dni"
                    solo
                    type="number"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                  RUC
                  <v-text-field
                    v-model="user.ruc"
                    type="number"
                    solo
                    required
                  ></v-text-field>
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
                  <v-select
                    v-model="user.city"
                    :items="cities"
                    menu-props="auto"
                    solo-details
                    solo
                    prepend-inner-icon="mdi-home-city"
                  ></v-select>
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
        <v-btn
          :disabled="!valid"
          color="#0D52D6"
          class="mr-3"
          @click="validate"
          dark
        >
          <v-icon class="mr-2">mdi-content-save</v-icon> Guardar
        </v-btn>
      </div>
    </v-row>
  </v-col>
</template>
<script>
import axios from "axios";
export default {
  data: () => ({
    gender: [
      {
        name: "Masculino",
        send: "masculine",
      },
      {
        name: "Femenino",
        send: "female",
      },
    ],
    rol_user: [
      {
        name: "Administrador",
        id: 1,
      },
      {
        name: "Cliente",
        id: 2,
      },
    ],
    valid: true,
    user: {},
    cities: [
      "Amazonas",
      "Ancash",
      "Apurímac",
      "Arequipa",
      "Ayacucho",
      "Cajamarca",
      "Cusco",
      "Huancavelica",
      "Huánuco",
      "Ica",
      "Junín",
      "La Libertad",
      "Lambayeque",
      "Lima",
      "Loreto",
      "Madre de Dios",
      "Moquegua",
      "Pasco",
      "Piura",
      "Puno",
      "San Martín",
      "Tacna",
      "Tumbes",
      "Ucayali",
    ],
  }),
  mounted() {},
  methods: {
    validate() {
      this.addUser();
    },
    addUser() {
      axios
        .post("/api/v1/users", this.user, {
          headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
          },
        })
        .then((response) => {
          this.$router.replace({name: "listUser"})
        })
        .catch((error) => {
          console.log(error);
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
