<template>
  <v-col>
    <v-window v-model="window" class="elevation-1" vertical>
      <v-window-item>
        <v-card flat>
          <v-card-text>
            <h3>Add New User</h3>
            <v-divider></v-divider>
            <v-form ref="form" v-model="valid" lazy-validation>
              <v-row>
                <v-col cols="12" sm="8" md="8">
                  <v-row>
                    <v-col cols="12" sm="6" md="6">
                      <v-text-field
                        v-model="user.name"
                        :counter="10"
                        label="Name"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      <v-text-field
                        v-model="user.lastname"
                        :counter="10"
                        label="Lastname"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      <v-text-field
                        v-model="user.email"
                        :counter="10"
                        label="Email"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      <v-text-field
                        v-model="user.password"
                        :counter="10"
                        label="Password"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      <v-text-field
                        v-model="user.address"
                        :counter="10"
                        label="Address"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      <v-text-field
                        v-model="user.ruc"
                        :counter="10"
                        label="RUC"
                        type="number"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      <v-text-field
                        v-model="user.dni"
                        :counter="10"
                        label="DNI"
                        required
                        type="number"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      <v-text-field
                        v-model="user.phone"
                        :counter="10"
                        label="Phone"
                        required
                        type="number"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      <v-select
                        v-model="user.gender"
                        :items="states"
                        menu-props="auto"
                        label="Gender"
                        hide-details
                        prepend-icon="mdi-map"
                      ></v-select>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      <v-select
                        v-model="user.city"
                        :items="cities"
                        menu-props="auto"
                        label="City"
                        hide-details
                        prepend-icon="mdi-map"
                      ></v-select>
                    </v-col>
                  </v-row>
                </v-col>
                <v-col cols="12" sm="4" md="4">
                  <v-col>
                    <v-carousel
                      cycle
                      height="250"
                      hide-delimiter-background
                      hide-delimiters
                    >
                      <v-carousel-item
                        v-for="(item, i) in urls"
                        :key="i"
                        :src="item.src"
                      >
                        <v-checkbox
                          v-model="item.checkbox"
                          color="black"
                          light
                        ></v-checkbox>
                      </v-carousel-item>
                    </v-carousel>
                  </v-col>
                  <v-col>
                    <v-file-input
                      v-model="files"
                      label="Images user"
                      multiple
                      prepend-icon="mdi-paperclip"
                      @change="Preview_image"
                      @click:clear="clear"
                    >
                      <template v-slot:selection="{ text }">
                        <v-chip small label color="primary">
                          {{ text }}
                        </v-chip>
                      </template>
                    </v-file-input>
                  </v-col>
                </v-col>
              </v-row>
            </v-form>
          </v-card-text>
        </v-card>
      </v-window-item>
    </v-window>
    <v-btn :disabled="!valid" color="success" class="mr-4" @click="addUser">
      Validate
    </v-btn>
  </v-col>

</template>
<script>
import axios from "axios";
export default {
  data: () => ({
    checkbox: false,
    e1: null,
    inputs: [],
    states: ["masculine", "female"],
    w_with: window.innerWidth * 0.3,
    w_height: window.innerHeight * 0.23,
    files: [],
    catalogues: [],
    categories: [],
    menu1: false,
    menu2: false,
    menu3: false,
    menu4: false,
    window: null,
    valid: true,
    user: {
      name: "",
      lastname: "",
      email: "",
      password: "",
      address: "",
      ruc: "",
      dni: "",
      phone: "",
      gender: "",
      city: "",
    },
    select: null,
    url: null,
    urls: [],
    cities: ["Arequipa", "Lima"],

  }),
  mounted() {

  },
  methods: {
    validate() {
      console.log(this.user.catalogue);
      this.addCatalogue();
    },
    addUser() {
      axios
        .post("/api/v1/users", this.user, {
          headers: {
            Authorization: "Bearer " + this.$store.getters.getToken,
            Accept: "application/json",
            "Content-Type": "application/json",
          },
        })
        .then((response) => {
          console.log(response);
          
        })
        .catch((error) => {
          console.log(error);
          // reject(error);
        });
    },
    reset() {
      this.$refs.form.reset();
    },
    resetValidation() {
      this.$refs.form.resetValidation();
    },
    Preview_image() {
      if (this.files.length == 0) {
        console.log("esta vacio");
      } else {
        this.url = URL.createObjectURL(this.files[0]);
        this.files.forEach((element) => {
          this.urls.push({
            src: URL.createObjectURL(element),
            checkbox: false,
          });
        });
        console.log(this.urls);
      }
    },
    deleteRow(index) {
      this.inputs.splice(index, 1);
    },
    clear() {
      this.files = [];
      this.urls = [];
      console.log("hola", this.urls, this.files);
    },
  },
};
</script>