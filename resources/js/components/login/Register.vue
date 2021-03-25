<template>
  <v-app>
    <div class="container">
      <div class="register-content">
        <h1 class="h1">Registro de Usuario</h1>
        <v-stepper v-model="e6" vertical>
          <v-stepper-step :complete="e6 > 1" step="1" @click="e6 = 1">
            Ingresa tus datos
          </v-stepper-step>

          <v-stepper-content step="1">
            Nombre
            <v-text-field
              v-model="name"
              solo
              required
              :rules="generalRules"
              placeholder="Juan"
            ></v-text-field>

            Apellidos
            <v-text-field
              v-model="lastname"
              solo
              required
              :rules="generalRules"
              placeholder="Perez"
            ></v-text-field>

            DNI
            <v-text-field
              v-model="dni"
              solo
              required
              :rules="generalRules"
              placeholder="77777777"
            ></v-text-field>

            Teléfono
            <v-text-field
              v-model="phone"
              solo
              required
              :rules="generalRules"
              placeholder="98546789"
            ></v-text-field>

            <v-btn color="primary" @click="e6 = 2"> Continue </v-btn>
          </v-stepper-content>

          <v-stepper-step :complete="e6 > 2" step="2" @click="e6 = 2">
            Ingresa mas Informacíon
          </v-stepper-step>

          <v-stepper-content step="2">
            Direccion
            <v-text-field
              v-model="address"
              solo
              required
              :rules="generalRules"
              placeholder="Av. example"
            ></v-text-field>

            Genero
            <v-select
              v-model="gender"
              :items="items"
              item-text="name"
              item-value="send"
              solo
              required
              placeholder="Seleccionar Genero"
            ></v-select>

            Cuidad
            <v-text-field
              v-model="city"
              solo
              :rules="generalRules"
              required
              placeholder="Arequipa"
            ></v-text-field>

            <v-btn color="primary" @click="e6 = 3"> Continue </v-btn>
          </v-stepper-content>

          <v-stepper-step :complete="e6 > 3" step="3" @click="e6 = 3">
            Datos finales
          </v-stepper-step>

          <v-stepper-content step="3">
            E-mail
            <v-text-field
              v-model="email"
              solo
              :rules="emailRules"
              required
              placeholder="example@gmail.com"
            ></v-text-field>

            Password
            <v-text-field
              solo
              v-model="password"
              :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
              :rules="[rules.required, rules.min]"
              :type="show1 ? 'text' : 'password'"
              name="input-10-1"
              hint="At least 8 characters"
              counter
              @click:append="show1 = !show1"
              v-on:keyup.enter="login"
              placeholder="*********"
            ></v-text-field>

            <v-btn
              :disabled="!valid"
              color="primary"
              class="my-3"
              @click="register"
            >
              Registrarse
            </v-btn>
          </v-stepper-content>
        </v-stepper>
      </div>
    </div>
  </v-app>
</template>
<script>
import { mapGetters, mapActions } from "vuex";

export default {
  data: () => ({
    w_with: window.innerWidth * 0.6,
    w_height: window.innerHeight,
    valid: true,
    email: "",
    emailRules: [
      v => !!v || "E-mail is required",
      v => /.+@.+\..+/.test(v) || "E-mail must be valid"
    ],
    select: null,
    show1: false,
    show2: true,
    show3: false,
    show4: false,
    password: "",
    rules: {
      required: value => !!value || "Required.",
      min: v => v.length >= 8 || "Min 8 characters"
    },
    generalRules: [v => !!v || "Este campo no puede ir vacio"],
    e6: 1,
    name: "",
    lastname: "",
    email: "",
    password_confirmation: "",
    address: "",
    ruc: "",
    dni: "",
    phone: "",
    gender: "",
    city: "",
    items: [
      {
        name: "Masculino",
        send: "masculine"
      },
      {
        name: "Femenino",
        send: "female"
      }
    ]
  }),

  methods: {
    ...mapActions("account", ["login"]),
    validate() {
      this.$refs.form.validate();
    },
    reset() {
      this.$refs.form.reset();
    },
    resetValidation() {
      this.$refs.form.resetValidation();
    },
    loginRouter() {
      this.$router.replace({ name: "loginRouter" });
    },
    register() {
      axios
        .post("/api/v1/signup", {
          name: this.name,
          lastname: this.lastname,
          email: this.email,
          password: this.password,
          password_confirmation: this.password,
          address: this.address,
          ruc: parseInt(this.ruc),
          dni: parseInt(this.dni),
          phone: this.phone,
          gender: this.gender,
          city: this.city
        })
        .then(response => {
          console.log(response);
          this.loginRouter();
        })
        .catch(error => {});
    }
  }
};
</script>
<style scoped>
.container {
  width: 100%;
  height: 100%;
}

h1 {
  font-family: "Poppins", sans-serif;
  text-align: center;
  font-size: 2.5rem;
  font-weight: 500;
  color: #444;
  margin-bottom: 40px;
  font-weight: bold;
}
.register-content {
  margin: auto;
  max-width: 60%;
}

@media screen and (max-width: 1024px) {
  .register-content {
    max-width: 80%;
  }
}
@media screen and (max-width: 767px) {
  .register-content {
    max-width: 100%;
  }
}
@media screen and (max-width: 480px) {
  .register-content {
    max-width: 100%;
  }
}
</style>
>
