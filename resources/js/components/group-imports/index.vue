<template>
  <div>
    <v-app class="color-background">
      <v-system-bar height="35" window color="#FBFBFB" class="p-page-new">
        <v-btn small text class="text-capitalize" @click="welcomeRoute">
          <v-icon color="#D22E2E">mdi-home-outline</v-icon>
          <div class="color-nav">Home</div>
        </v-btn>
        <v-btn small text class="text-capitalize">
          <v-icon color="#D22E2E">mdi-information-outline</v-icon>
          <div class="color-nav">Acerca</div>
        </v-btn>
        <v-btn small text class="text-capitalize">
          <v-icon color="#D22E2E">mdi-email-outline</v-icon>
          <div class="color-nav">Contacto</div>
        </v-btn>
        <v-spacer></v-spacer>
        <v-btn small text class="text-capitalize hidden-xs-only" @click="logout" v-if="isLoggedIn">
          <v-icon color="#D22E2E">mdi-logout</v-icon>
          <div class="color-nav">Logout</div>
        </v-btn>
        <v-btn small text class="text-capitalize hidden-xs-only" @click="login" v-else>
          <v-icon color="#D22E2E">mdi-login</v-icon>
          <div class="color-nav">Login/Register</div>
        </v-btn>
      </v-system-bar>
      <v-app-bar flat color="#fff" class="hidden-xs-only m-page-new nav-font" max-height="64">
        <v-toolbar-title class="px-0" @click="catalogueRoute">
          <div class="d-flex title-nav">
            <v-img max-height="50" max-width="50" contain src="/images/LogoPNG.png"></v-img>
            <div class="my-auto ml-2 title-nav">BIZZPERU</div>
          </div>
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items v-if="isLoggedIn">
          <!-- <v-btn text @click="cartView">Carrito</v-btn> -->
          <v-btn
            active-class="button-nav-active"
            class="button-nav"
            text
            :to="{ name: 'homeGroupImport' }"
          >
            Catálogos
          </v-btn>
          <v-btn
            active-class="button-nav-active"
            class="button-nav"
            text
            :to="{ name: 'UserSettingIG' }"
          >
            {{ user.name | name }}
          </v-btn>
          <v-btn
            active-class="button-nav-active"
            class="button-nav"
            text
            :to="{ name: 'orderUser' }"
          >
            Mis Pedidos
          </v-btn>
          <v-btn
            active-class="button-nav"
            class="button-nav"
            text
            v-if="role"
            @click="dashboardRoute"
          >
            Administrar
          </v-btn>
        </v-toolbar-items>
        <v-toolbar-items v-else>
          <v-btn
            active-class="button-nav-active"
            class="button-nav"
            text
            :to="{ name: 'homeGroupImport' }"
          >
            Catálogos
          </v-btn>
        </v-toolbar-items>
      </v-app-bar>

      <v-app-bar flat color="#fff" class="hidden-sm-and-up" max-height="64">
        <v-toolbar-title @click="catalogueRoute">
          <div class="d-flex">
            <v-img max-height="50" max-width="50" contain src="/images/LogoPNG.png"></v-img>
            <div class="my-auto ml-2 title-nav">BIZZPERU</div>
          </div>
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
          <template v-slot:activator="{ on }">
            <v-app-bar-nav-icon v-on="on"></v-app-bar-nav-icon>
          </template>
          <v-card>
            <v-toolbar flat color="#D22E2E" dark>
              <v-toolbar-title>
                <div class="d-flex">
                  <v-img max-height="50" max-width="50" contain src="/images/LogoPNG.png"></v-img>
                  <div class="my-auto ml-2 title-nav-mobile">BIZZPERU</div>
                </div>
              </v-toolbar-title>
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
                  <v-list-item-content @click="userRoute">
                    <v-list-item-title> {{ user.name | name }} </v-list-item-title>
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
                    <v-list-item-title>Logout</v-list-item-title>
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
        <main>
          <router-view></router-view>
        </main>
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
  filters: {
    name: function(value) {
      if (value == null) {
        value = '';
      }
      let c = value;
      let s = ' ';
      let a = c.split(s);
      switch (a.length) {
        case 1:
          return value;
        case 2:
          return value;
        case 3:
          return a[0] + ' ' + a[1];
        case 4:
          return a[0] + ' ' + a[2];
        default:
          return value;
      }
    },
  },
};
</script>

<style scope>
@import url('https://fonts.googleapis.com/css2?family=Gothic+A1:wght@500&display=swap');
.color-background {
  background-color: #fff !important;
}
.nav-font {
  font-family: 'Gothic A1', sans-serif;
}
.m-page-new {
  margin-right: 9%;
  margin-left: 9%;
  padding-left: 0 !important;
  padding-right: 0 !important;
}
.p-page-new {
  padding-right: 10%;
  padding-left: 10%;
  border-bottom: 1px solid #e5e5e5 !important;
}
.color-nav {
  color: #d22e2e;
}
.title-nav {
  color: #d22e2e;
  font-weight: bold;
  font-size: 23px;
  cursor: pointer;
  letter-spacing: 2px;
}
.title-nav-mobile {
  color: white;
  font-weight: bold;
  font-size: 23px;
  letter-spacing: 2px;
}
.button-nav:hover {
  background-color: #d22e2e !important;
  color: white !important;
}
.button-nav-active {
  background-color: #d22e2e !important;
  color: white !important;
  text-decoration: underline !important;
}
@media (max-width: 960px) {
  .m-page-new {
    margin-right: 0;
    margin-left: 0;
  }
  .p-page-new {
    padding-right: 0;
    padding-left: 0;
  }
  .title-nav-mobile {
    color: white;
  }
}
@media (max-width: 600px) {
  .m-page-new {
    margin-right: auto;
    margin-left: auto;
  }
  .p-page-new {
    padding-right: 0;
    padding-left: 0;
  }
  .title-nav-mobile {
    color: white;
  }
}
@media (max-width: 360px) {
  .m-page-new {
    margin-right: auto;
    margin-left: auto;
  }
  .p-page-new {
    padding-right: 0;
    padding-left: 0;
  }
  .title-nav-mobile {
    color: white;
  }
}
</style>
