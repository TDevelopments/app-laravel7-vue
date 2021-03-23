<template>
  <v-app>
    <v-app-bar app color="#253035" dark clipped-left>
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title>BizzPeru</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-toolbar-items>
        <v-btn text @click="iG"> Importaciones Grupales</v-btn>
        <v-btn text @click="sS"> Ventas en Stock</v-btn>
        <v-btn icon @click="logout()">
          <v-icon>mdi-export</v-icon>
        </v-btn>
      </v-toolbar-items>
    </v-app-bar>

    <v-navigation-drawer
      v-model="drawer"
      :permanent="permanent"
      clipped
      app
      color="#253035"
      dark
    >
      <v-list nav>
        <v-list-item class="px-2">
          <v-list-item-avatar>
            <v-img src="/images/user.svg"></v-img>
          </v-list-item-avatar>
        </v-list-item>

        <v-list-item>
          <v-list-item-content>
            <v-list-item-title class="title">
              {{ user.name }}
            </v-list-item-title>
            <v-list-item-subtitle>{{ user.email }}</v-list-item-subtitle>
          </v-list-item-content>
          <v-btn icon>
            <v-icon>mdi-chevron-down</v-icon>
          </v-btn>
        </v-list-item>
      </v-list>

      <v-list dense nav shaped v-if="module == 'ImportGroup'">
        <v-subheader>Importaciones Grupales</v-subheader>
        <v-list-item-group>
          <v-list-item :to="{ name: 'dashboard' }">
            <v-list-item-icon>
              <v-icon>mdi-speedometer </v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Dashboard</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-item-group>
        <v-list-group prepend-icon="mdi-bookshelf" no-action color="#FCF3F3">
          <template v-slot:activator>
            <v-list-item-title>Catálogos</v-list-item-title>
          </template>
          <v-list-item link :to="{ name: 'listCatalogue' }">
            <v-list-item-title>Listar Catálogos</v-list-item-title>
          </v-list-item>
          <v-list-item link :to="{ name: 'addCatalogue' }">
            <v-list-item-title>Crear Catálogos</v-list-item-title>
          </v-list-item>
        </v-list-group>
        <v-list-group prepend-icon="mdi-archive" no-action color="#FCF3F3">
          <template v-slot:activator>
            <v-list-item-title>Producto</v-list-item-title>
          </template>
          <v-list-item link :to="{ name: 'listProduct' }">
            <v-list-item-title>Listar Productos</v-list-item-title>
          </v-list-item>
          <v-list-item link :to="{ name: 'addProduct' }">
            <v-list-item-title>Crear Producto Conjunto</v-list-item-title>
          </v-list-item>
          <v-list-item link :to="{ name: 'addProductRange' }">
            <v-list-item-title>Crear Producto Rango</v-list-item-title>
          </v-list-item>
        </v-list-group>
        <v-list-group prepend-icon="mdi-view-list" no-action color="#FCF3F3">
          <template v-slot:activator>
            <v-list-item-title>Categorías</v-list-item-title>
          </template>
          <v-list-item link :to="{ name: 'listCategory' }">
            <v-list-item-title>Listar Categorías</v-list-item-title>
          </v-list-item>
          <v-list-item link :to="{ name: 'addCategory' }">
            <v-list-item-title>Crear Categorías</v-list-item-title>
          </v-list-item>
        </v-list-group>
        <v-list-group
          prepend-icon="mdi-account-circle"
          no-action
          color="#FCF3F3"
        >
          <template v-slot:activator>
            <v-list-item-title>Usuarios</v-list-item-title>
          </template>
          <v-list-item link :to="{ name: 'listUser' }">
            <v-list-item-title>Listar Usuarios</v-list-item-title>
          </v-list-item>
          <v-list-item link :to="{ name: 'addUser' }">
            <v-list-item-title>Crear Usuarios</v-list-item-title>
          </v-list-item>
        </v-list-group>

        <v-list-group
          prepend-icon="mdi-account-circle"
          no-action
          color="#FCF3F3"
        >
          <template v-slot:activator>
            <v-list-item-title>Unidades</v-list-item-title>
          </template>
          <v-list-item link :to="{ name: 'listMeasure' }">
            <v-list-item-title>Listar Unidades</v-list-item-title>
          </v-list-item>
          <v-list-item link :to="{ name: 'addMeasure' }">
            <v-list-item-title>Crear Unidad</v-list-item-title>
          </v-list-item>
        </v-list-group>
        <v-list-group prepend-icon="mdi-view-list" no-action color="#FCF3F3">
          <template v-slot:activator>
            <v-list-item-title>Ordenes</v-list-item-title>
          </template>
          <v-list-item link :to="{ name: 'listOrder' }">
            <v-list-item-title>Listar Categorias</v-list-item-title>
          </v-list-item>
        </v-list-group>
      </v-list>

      <v-list dense nav shaped v-if="module == 'SellStock'">
        <v-subheader>Ventas en Stock</v-subheader>
        <v-list-item-group>
          <v-list-item :to="{ name: 'dashboard' }">
            <v-list-item-icon>
              <v-icon>mdi-speedometer </v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Dashboard</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-item-group>
      </v-list>

      <template v-slot:append>
        <div class="pa-2">
          <v-btn color="#1867C0" block class="text-capitalize" @click="viewUser"
            ><v-icon class="mr-2">mdi-eye</v-icon> Ver Como Usuario
          </v-btn>
        </div>
      </template>
    </v-navigation-drawer>

    <v-main class="main">
      <v-container fluid>
        <router-view></router-view>
      </v-container>
    </v-main>

    <!-- <v-footer app>
    </v-footer> -->
  </v-app>
</template>
<script>
import { mapActions, mapGetters } from "vuex";

export default {
  data: () => ({
    wheight: window.innerHeight,
    drawer: null,
    permanent: null,
    module: "ImportGroup",
  }),
  computed: {
    ...mapGetters("account", ["user"]),
  },
  mounted() {
    this.getUser();
  },
  methods: {
    ...mapActions("account", ["logout", "getUser"]),
    pageGroupImport() {
      this.$router.push({
        name: "group-import",
      });
    },
    iG() {
      this.module = "ImportGroup";
    },
    sS() {
      this.module = "SellStock";
    },
    viewUser() {
      this.$router.push({ name: "group-import" });
    },
  },
};
</script>
<style scoped>
.main {
  background-color: #fafafa;
}
</style>
