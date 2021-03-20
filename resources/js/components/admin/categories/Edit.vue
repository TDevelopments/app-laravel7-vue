<template>
  <v-col>
    <v-window class="elevation-1" vertical>
      <v-window-item>
        <v-card flat>
          <v-card-text>
            <h3>Edit Catalogue</h3>
            <v-divider></v-divider>
            <v-row>
              <v-col cols="12" sm="6" md="6">
                Catalogue Name
                <v-text-field
                  v-model="categorie.name"
                  solo
                  required
                  v-on:keyup.enter="udpdateCategorie"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-window-item>
    </v-window>
    <v-btn color="success" class="mr-4" @click="udpdateCategorie">
      Guardar
    </v-btn>
  </v-col>
</template>

<script>
export default {
  data: () => ({
    valid: true,
    categorie: {
      name: "",
    },
  }),

  methods: {
    validate() {
      console.log(this.arrivalsDates);
    },
    getCategorie() {
      axios
        .get(`/api/v1/categories/${this.$route.params.id}`, {
          headers: {
            Accept: "application/json",
          },
        })
        .then((response) => {
          this.categorie = response.data.data;
        })
        .catch((error) => {});
    },
    udpdateCategorie() {
      axios
        .put(`/api/v1/categories/${this.$route.params.id}`, this.categorie, {
          headers: {
            Accept: "application/json",
          },
        })
        .then((response) => {
          this.$router.replace({ name: "listCategory" });
        })
        .catch((error) => {});
    },
  },
  mounted() {
    this.getCategorie();
  },
};
</script>
