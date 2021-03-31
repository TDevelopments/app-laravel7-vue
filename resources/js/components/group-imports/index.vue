<template>
  <div>
    <v-app class="color-background">
      <v-system-bar height="35" window color="#fff" class="px-0">
        <v-container class="px-0 m-page">
          <v-btn small text class="text-capitalize" @click="welcomeRoute">
            <v-icon>mdi-home-outline</v-icon>Home</v-btn
          >
          <v-btn small text class="text-capitalize">
            <v-icon>mdi-information-outline</v-icon>Acerca</v-btn
          >
          <v-btn small text class="text-capitalize">
            <v-icon>mdi-email-outline</v-icon>Contacto</v-btn
          >
        </v-container>
      </v-system-bar>
      <v-app-bar dark color="#709FA5" class="hidden-xs-only p-page nav-font" max-height="64">
        <v-toolbar-title @click="catalogueRoute">Importaciones Grupales</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items v-if="isLoggedIn">
          <!-- <v-btn text @click="cartView">Carrito</v-btn> -->
          <v-btn text :to="{ name: 'homeGroupImport' }"> Cátalogos </v-btn>
          <v-menu rounded offset-y>
            <template v-slot:activator="{ attrs, on }">
              <v-btn text v-bind="attrs" v-on="on">
                {{ user.name }}
                <v-icon>mdi-menu-down</v-icon>
              </v-btn>
            </template>

            <v-list>
              <v-list-item link :to="{ name: 'UserSettingIG' }">
                <v-list-item-title text>
                  Opciones
                </v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
          <v-btn text :to="{ name: 'orderUser' }"> Mis Pedidos </v-btn>
          <v-btn text v-if="role" @click="dashboardRoute"> Administrar </v-btn>
          <v-btn text @click="logout"> Salir </v-btn>
        </v-toolbar-items>
        <v-toolbar-items v-else>
          <!-- <v-btn class="text-capitalize" text @click="cartView">
            <v-icon class="mr-1">mdi-cart</v-icon>Carrito</v-btn
          > -->
          <v-btn class="text-capitalize" text @click="registerRoute">
            <v-icon class="mr-1">mdi-pencil</v-icon> Registrarse
          </v-btn>
          <v-btn class="text-capitalize" text @click="login"
            ><v-icon class="mr-1">mdi-account</v-icon> Login
          </v-btn>
        </v-toolbar-items>
      </v-app-bar>

      <v-app-bar dark color="blue-grey darken-3" class="hidden-sm-and-up" max-height="64">
        <v-toolbar-title @click="welcomeRoute">BizzPeru</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
          <template v-slot:activator="{ on }">
            <v-app-bar-nav-icon v-on="on"></v-app-bar-nav-icon>
          </template>
          <v-card>
            <v-toolbar flat color="blue-grey darken-2">
              <v-toolbar-title>BizzPeru</v-toolbar-title>
              <v-spacer></v-spacer>
              <v-btn icon @click.native="dialog = false">
                <v-icon>mdi-close</v-icon>
              </v-btn>
            </v-toolbar>

            <v-list shaped>
              <v-list-item-group v-if="isLoggedIn" color="primary">
                <v-list-item>
                  <v-list-item-icon>
                    <v-icon> mdi-account</v-icon>
                  </v-list-item-icon>
                  <v-list-item-content>
                    <v-list-item-title> {{ user.name }} </v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
                <v-list-item>
                  <v-list-item-icon>
                    <v-icon> mdi-account-convert</v-icon>
                  </v-list-item-icon>
                  <v-list-item-content @click="userRoute">
                    <v-list-item-title>Configuracion de Usuario</v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
                <v-list-item>
                  <v-list-item-icon>
                    <v-icon> mdi-view-list</v-icon>
                  </v-list-item-icon>
                  <v-list-item-content @click="orderUserRoute">
                    <v-list-item-title>Mis Pedidos</v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
                <v-list-item v-if="role">
                  <v-list-item-icon>
                    <v-icon> mdi-settings</v-icon>
                  </v-list-item-icon>
                  <v-list-item-content @click="dashboardRoute">
                    <v-list-item-title>Administrar</v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
                <v-list-item>
                  <v-list-item-icon>
                    <v-icon> mdi-logout</v-icon>
                  </v-list-item-icon>
                  <v-list-item-content @click="logout">
                    <v-list-item-title>Cerrar Sesión</v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
              </v-list-item-group>

              <v-list-item-group v-else color="primary">
                <v-list-item>
                  <v-list-item-icon>
                    <v-icon> mdi-account</v-icon>
                  </v-list-item-icon>
                  <v-list-item-content @click="login">
                    <v-list-item-title>Login</v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
                <v-list-item>
                  <v-list-item-icon>
                    <v-icon> mdi-account</v-icon>
                  </v-list-item-icon>
                  <v-list-item-content @click="registerRoute">
                    <v-list-item-title>Register</v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
              </v-list-item-group>
            </v-list>
          </v-card>
        </v-dialog>
      </v-app-bar>
      <div>
        <section class="section">
          <main>
            <router-view></router-view>
          </main>
        </section>
      </div>
    </v-app>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
export default {
  data: () => ({
    isLoading: false,
    items: [],
    model: null,
    search: null,
    tab: null,
    drawer: null,
    dialog: false,
    select: ['All', '12345678', '12345', 'asdasdasdasdkhabsd'],
    categorie: 'All',
  }),
  computed: {
    ...mapGetters('account', ['user', 'isLoggedIn', 'authStatus']),
    role() {
      let value = false;
      this.user.roles.forEach(rol => {
        if (rol.name === 'admin') {
          value = true;
        } else {
          value = false;
        }
      });
      return value;
    },
  },
  methods: {
    ...mapActions('account', ['getUser', 'logout']),
    login() {
      this.$router.push({
        name: 'loginRouter',
      });
      this.dialog = false;
    },
    registerRoute() {
      this.$router.push({
        name: 'register',
      });
      this.dialog = false;
    },
    welcomeRoute() {
      this.$router.push({
        name: 'welcome',
      });
      this.dialog = false;
    },
    dashboardRoute() {
      this.$router.push({
        name: 'Home',
      });
      this.dialog = false;
    },
    orderUserRoute() {
      this.$router.push({
        name: 'orderUser',
      });
      this.dialog = false;
    },
    cartView() {
      this.$router.push({
        name: 'cartGroupImport',
      });
      this.dialog = false;
    },
    userRoute() {
      this.$router.push({
        name: 'UserSettingIG',
      });
      this.dialog = false;
    },
    catalogueRoute() {
      this.$router.push({
        name: 'homeGroupImport',
      });
      this.dialog = false;
    },
  },
  async mounted() {
    if (this.isLoggedIn) {
      await this.getUser();
    }
  },
};
</script>

<style scope>
@import url('https://fonts.googleapis.com/css2?family=Gothic+A1:wght@500&display=swap');
.color-background {
  background-color: #f5f4f3 !important;
}
.nav-font {
  font-family: 'Gothic A1', sans-serif;
}
.m-page {
  margin-right: 15%;
  margin-left: 15%;
}
.p-page {
  padding-right: 15%;
  padding-left: 15%;
}
@media (max-width: 500px) {
  .m-page {
    margin-right: auto;
    margin-left: auto;
  }
}
@media (max-width: 360px) {
  .m-page {
    margin-right: auto;
    margin-left: auto;
  }
}
</style>
