<template>
  <v-app>
    <div class="container">
      <div class="register-content">
        <h1 class="h1">Registro de Usuario</h1>
        <v-form ref="form" v-model="valid" lazy-validation>
          Nombre Completo
          <v-text-field
            v-model="name"
            solo
            required
            :rules="generalRules"
            placeholder="Juan Perez Makoto"
          ></v-text-field>

          DNI
          <v-text-field
            v-model="dni"
            solo
            required
            :rules="generalRules"
            placeholder="75632449"
          ></v-text-field>

          Email
          <v-text-field
            v-model="email"
            solo
            required
            :rules="emailRules"
            placeholder="example@gmail.com"
          ></v-text-field>

          Contraseña
          <v-text-field
            solo
            v-model="password"
            :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
            :rules="[rules.required, rules.min]"
            :type="show1 ? 'text' : 'password'"
            name="input-10-1"
            hint="At least 8 characters"
            @click:append="show1 = !show1"
            v-on:keyup.enter="login"
            placeholder="*********"
          ></v-text-field>

          Celular / Whatsapp
          <v-text-field
            v-model="phone"
            solo
            required
            :rules="generalRules"
            placeholder="98546789"
          ></v-text-field>

          Cuidad de recojo / envio
          <v-text-field
            v-model="city"
            solo
            required
            :rules="generalRules"
            placeholder="Arequipa"
          ></v-text-field>

          <v-btn :disabled="!valid" color="primary" class="my-3" @click="registerAction">
            Registrarse
          </v-btn>
        </v-form>
      </div>
    </div>
    <v-dialog v-model="dialogAfterRegister" persistent max-width="290">
      <v-card>
        <v-card-title class="headline">
          ¡Registro Exitoso!
        </v-card-title>
        <v-card-text>
          ¡Ud. ya puede realizar su pedido!
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" text @click="goBackProducts">
            Revisar Pedido
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-app>
</template>
<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  data: () => ({
    w_with: window.innerWidth * 0.6,
    w_height: window.innerHeight,
    valid: true,
    email: '',
    emailRules: [
      v => !!v || 'E-mail is required',
      v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
    ],
    select: null,
    show1: false,
    show2: true,
    show3: false,
    show4: false,
    password: '',
    rules: {
      required: value => !!value || 'Required.',
      min: v => v.length >= 8 || 'Min 8 characters',
    },
    generalRules: [v => !!v || 'Este campo no puede ir vacio'],
    e6: 1,
    name: '',
    lastname: '',
    email: '',
    password_confirmation: '',
    address: '',
    ruc: '',
    dni: '',
    phone: '',
    gender: '',
    city: '',
    items: [
      {
        name: 'Masculino',
        send: 'masculine',
      },
      {
        name: 'Femenino',
        send: 'female',
      },
    ],
    dialogAfterRegister: false,
  }),

  methods: {
    ...mapActions('account', ['login', 'register']),
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
      this.$router.replace({ name: 'loginRouter' });
    },
    registerAction() {
      this.$refs.form.validate();
      let user = {
        name: this.name,
        password: this.password,
        password_confirmation: this.password,
        email: this.email,
        dni: parseInt(this.dni),
        phone: this.phone,
        city: this.city,
      };
      this.register(user);
      this.dialogAfterRegister = true;
    },
    goBackProducts() {
      this.$router.go(-1);
    },
  },
};
</script>
<style scoped>
.container {
  width: 100%;
  height: 100%;
}

h1 {
  font-family: 'Poppins', sans-serif;
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
