<template>
  <v-app>
    <v-app-bar app color="#253035" dark clipped-left>
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title>BizzPeru</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn icon :to="{ name: 'logout' }">
        <v-icon>mdi-export</v-icon>
      </v-btn>
    </v-app-bar>

    <v-navigation-drawer v-model="drawer" :permanent="permanent" clipped app color="#253035" dark>
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

      <v-list dense nav shaped>
        <v-list-item-group >
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
            <v-list-item-title>Catalogues</v-list-item-title>
          </template>
          <v-list-item link :to="{ name: 'listCatalogue' }">
            <v-list-item-title>List</v-list-item-title>
          </v-list-item>
          <v-list-item link :to="{ name: 'addCatalogue' }">
            <v-list-item-title>Add</v-list-item-title>
          </v-list-item>
        </v-list-group>
        <v-list-group prepend-icon="mdi-archive" no-action color="#FCF3F3">
          <template v-slot:activator>
            <v-list-item-title>Product</v-list-item-title>
          </template>
          <v-list-item link :to="{ name: 'listProduct' }">
            <v-list-item-title>List</v-list-item-title>
          </v-list-item>
          <v-list-item link :to="{ name: 'addProduct' }">
            <v-list-item-title>Add</v-list-item-title>
          </v-list-item>
        </v-list-group>
        <v-list-group prepend-icon="mdi-view-list" no-action color="#FCF3F3">
          <template v-slot:activator>
            <v-list-item-title>Categories</v-list-item-title>
          </template>
          <v-list-item link :to="{ name: 'listCategory' }">
            <v-list-item-title>List</v-list-item-title>
          </v-list-item>
          <v-list-item link :to="{ name: 'addCategory' }">
            <v-list-item-title>Add</v-list-item-title>
          </v-list-item>
        </v-list-group>
        <v-list-group
          prepend-icon="mdi-account-circle"
          no-action
         color="#FCF3F3"
        >
          <template v-slot:activator>
            <v-list-item-title>Users</v-list-item-title>
          </template>
          <v-list-item link :to="{ name: 'listUser' }">
            <v-list-item-title>List</v-list-item-title>
          </v-list-item>
          <v-list-item link :to="{ name: 'addUser' }">
            <v-list-item-title>Add</v-list-item-title>
          </v-list-item>
        </v-list-group>
      </v-list>
    </v-navigation-drawer>

    <v-main style="background-color: #FCF3F3">
      <v-container fluid>
        <router-view></router-view>
      </v-container>
    </v-main>

    <!-- <v-footer app>
    </v-footer> -->
  </v-app>
</template>
<script>
export default {
  data: () => ({
    wheight: window.innerHeight,
    drawer: null,
    permanent: null,
    user: [],
  }),
  mounted() {
    this.getDataUser();
  },
  methods: {
    getDataUser() {
      axios
        .get("/api/v1/user", {
          headers: {
            Authorization: "Bearer " + this.$store.getters.getToken,
            Accept: "application/json",
          },
        })
        .then((response) => {
          console.log(response);
          this.user = response.data.data;
          console.log(this.user);
        })
        .catch((error) => {
          console.log(error);
          // reject(error);
        });
    },
  },
};
</script>
