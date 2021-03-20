<template>
  <v-app>
    <div class="containers">
      <div class="forms-containers">
        <div class="form">
          <div class="form-with">
            <div class="signin">
              <v-form ref="form" v-model="valid" lazy-validation>
                <div class="container">
                  <h1 class="h1">Sign up</h1>
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

                      RUC
                      <v-text-field
                        v-model="ruc"
                        solo
                        required
                        placeholder="7777777777"
                      ></v-text-field>

                      Genero
                      <v-select
                        v-model="gender"
                        :items="items"
                        item-text="name"
                        item-value="send"
                        solo
                        required
                        placeholder="98546789"
                      ></v-select>

                      Cuidad
                      <v-text-field
                        v-model="city"
                        solo
                        :rules="generalRules"
                        required
                        placeholder="98546789"
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
              </v-form>
            </div>
          </div>
        </div>
      </div>
      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>Ya tienes una cuenta?</h3>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis
              consequuntur quos, dolorem quam voluptatum voluptates labore.
              Dolores magni sint, ex totam, quas vitae unde sit tenetur esse nam
              sapiente amet!
            </p>
            <v-btn
              color="white"
              class="mr-4"
              outlined
              rounded
              dark
              @click="loginRouter"
            >
              Sign in
            </v-btn>
          </div>
          <img src="images/delivery.svg" class="image" />
        </div>
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
      (v) => !!v || "E-mail is required",
      (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
    ],
    select: null,
    show1: false,
    show2: true,
    show3: false,
    show4: false,
    password: "",
    rules: {
      required: (value) => !!value || "Required.",
      min: (v) => v.length >= 8 || "Min 8 characters",
    },
    generalRules: [(v) => !!v || "Este campo no puede ir vacio"],
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
        send: "masculine",
      },
      {
        name: "Femenino",
        send: "female",
      },
    ],
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
      this.$router.push({ name: "loginRouter" });
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
          ruc: this.ruc,
          dni: this.dni,
          phone: this.phone,
          gender: this.gender,
          city: this.city,
        })
        .then((response) => {
          console.log(response);
          this.loginRouter();
        })
        .catch((error) => {});
    },
  },
};
</script>
<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800&display=swap");
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
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
.containers {
  position: relative;
  width: 100%;
  min-height: 100vh;
  background-color: #fff;
  overflow: hidden;
}
.containers:before {
  content: "";
  position: absolute;
  width: 2500px;
  height: 2500px;
  border-radius: 50%;
  background: linear-gradient(-45deg, #4481eb, #04befe);
  top: -10%;
  right: 48%;
  transform: translateY(-50%);
  z-index: 6;
}
.form-container {
  position: absolute;
  width: 100%;
  height: 100%;
  top: 50%;
  left: 75%;
  transform: translate(-50%, -50%);
  /* background-color: red; */
}
.form {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
}
.form-with {
  max-width: 380px;
  width: 100%;
}
.signin {
  position: absolute;
  top: 50%;
  left: 75%;
  transform: translate(-50%, -50%);
  width: 30%;
  z-index: 5;
}

.panels-container {
  position: absolute;
  width: 100%;
  height: 100;
  top: 0;
  left: 0;
  display: grid;
  grid-template-columns: repeat(2, 1fr);
}
.panel {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  justify-content: space-around;
  text-align: center;
  z-index: 7;
}
.left-panel {
  pointer-events: all;
  padding: 3rem 17% 2rem 12%;
}

.panel .content {
  color: #fff;
}

.panel h3 {
  font-weight: 600;
  line-height: 1;
  font-size: 1.5rem;
}

.panel p {
  font-size: 0.95rem;
  padding: 0.7rem 0;
}

.image {
  width: 110%;
  margin-top: 5%;
}

@media (max-width: 870px) {
  .containers {
    min-height: 800px;
    height: 100vh;
  }
  .signin {
    width: 70%;
    top: 95%;
    transform: translate(-50%, -100%);
    transition: 1s 0.8s ease-in-out;
  }

  .signin,
  .containers .signin {
    left: 50%;
  }

  .panels-container {
    grid-template-columns: 1fr;
    grid-template-rows: 1fr 2fr 1fr;
  }

  .panel {
    flex-direction: row;
    justify-content: space-around;
    align-items: center;
    padding: 2.5rem 8%;
    grid-column: 1 / 2;
  }

  .left-panel {
    grid-row: 1 / 2;
  }

  .image {
    width: 300px;
    transition: transform 0.9s ease-in-out;
    transition-delay: 0.6s;
    margin-top: 0%;
  }

  .panel .content {
    padding-right: 15%;
    transition: transform 0.9s ease-in-out;
    transition-delay: 0.8s;
  }

  .panel h3 {
    font-size: 1.9rem;
  }

  .panel p {
    font-size: 0.7rem;
    padding: 0.5rem 0;
  }

  .containers:before {
    width: 1500px;
    height: 1500px;
    transform: translateX(-50%);
    left: 30%;
    bottom: 68%;
    right: initial;
    top: initial;
    transition: 2s ease-in-out;
  }
}

@media (max-width: 570px) {
  .form {
    padding: 0 1.5rem;
  }

  .image {
    display: none;
  }
  .panel .content {
    padding: 0.5rem 1rem;
  }
  .containers {
    padding: 1.5rem;
  }

  .containers:before {
    bottom: 72%;
    left: 50%;
  }
}
</style>
>
