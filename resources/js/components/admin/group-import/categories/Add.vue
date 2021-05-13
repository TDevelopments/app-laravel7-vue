<template>
  <v-col>
    <h3>Nueva Categoria</h3>
    <v-window class="elevation-1" vertical>
      <v-window-item>
        <v-card flat>
          <v-card-text>
            <v-row>
              <v-col cols="12" sm="6" md="6">
                Nombre Categoria
                <v-text-field
                  v-model="category.name"
                  solo
                  required
                  placeholder="Example"
                  v-on:keyup.enter="addCategory"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-window-item>
    </v-window>
    <v-btn color="success" class="mr-4 mt-3" @click="addCategory">
      Guardar
    </v-btn>
  </v-col>
</template>

<script>
export default {
  data: () => ({
    valid: true,
    category: {
      name: "",
    },
  }),
  methods: {
    validate() {
      console.log(this.arrivalsDates);
    },
    addCategory() {
      axios
        .post("/api/v1/categories", this.category, {
          headers: {
            Accept: "application/json",
          },
        })
        .then((response) => {
          this.$router.replace({ name: "listCategory" });
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>
