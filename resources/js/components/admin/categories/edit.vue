<template>
  <v-col>
    <v-window class="elevation-1" vertical>
      <v-window-item>
        <v-card flat>
          <v-card-text>
            <h3>Edit Catalogue</h3>
            <v-divider></v-divider>
            <v-form ref="form" v-model="valid" lazy-validation>
              <v-row>
                <v-col cols="12" sm="6" md="6">
                  Catalogue Name
                  <v-text-field
                    v-model="categorie.name"
                    solo
                    required
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-form>
          </v-card-text>
        </v-card>
      </v-window-item>
    </v-window>
    <v-btn color="success" class="mr-4" @click="udpdateCategorie">
      Update
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
  mounted() {
    this.getCategorie();
  },
  methods: {
    validate() {
      console.log(this.arrivalsDates);
    },
    getCategorie() {
      axios
        .get(`/api/v1/categories/${this.$route.params.id}`, {
          headers: {
            Authorization: "Bearer " + this.$store.getters.getToken,
            Accept: "application/json",
          },
        })
        .then((response) => {
          console.log(response);
          this.categorie = response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    udpdateCategorie() {
      axios
        .put(`/api/v1/categories/${this.$route.params.id}`, this.categorie, {
          headers: {
            Authorization: "Bearer " + this.$store.getters.getToken,
            Accept: "application/json",
          },
        })
        .then((response) => {
          console.log(response);
          this.$router.push({name: 'listCategory'})
        })
        .catch((error) => {
          console.log(error);
        });
    },  
  },
};
</script>