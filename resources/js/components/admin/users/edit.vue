<template>
  <v-col>
    <v-window v-model="window" class="elevation-1" vertical>
      <v-window-item>
        <v-card flat>
          <v-card-text>
            <h3>Add New Product Normal</h3>
            <v-divider></v-divider>
            <v-form ref="form" v-model="valid" lazy-validation>
              <v-row>
                <v-col cols="12" sm="8" md="8">
                  <v-row>
                    <v-col cols="12" sm="6" md="6">
                      <v-text-field
                        v-model="product.model"
                        :counter="10"
                        label="Product Model"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      <v-text-field
                        v-model="product.slug"
                        :counter="10"
                        label="Slug"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      <v-text-field
                        v-model="product.stock"
                        :counter="10"
                        label="Stock"
                        type="number"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      <v-text-field
                        v-model="product.brand"
                        :counter="10"
                        label="Brand"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      <v-text-field
                        v-model="product.price_unit"
                        :counter="10"
                        label="Price Unit"
                        type="number"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      <v-text-field
                        v-model="product.price_group"
                        :counter="10"
                        label="Price Group"
                        required
                        type="number"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      <v-text-field
                        v-model="product.quantity_group"
                        :counter="10"
                        label="Quantity Group"
                        required
                        type="number"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      <v-select
                        v-model="product.type_group"
                        :items="states"
                        menu-props="auto"
                        label="Type Group"
                        hide-details
                        prepend-icon="mdi-map"
                      ></v-select>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      <v-select
                        v-model="product.category"
                        item-text="name"
                        item-value="id"
                        :items="categories"
                        menu-props="auto"
                        label="Category"
                        hide-details
                        prepend-icon="mdi-map"
                      ></v-select>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      <v-select
                        v-model="product.catalogue"
                        item-text="name"
                        item-value="id"
                        :items="catalogues"
                        menu-props="auto"
                        label="Catalogue"
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
                      label="Images Product"
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
    <v-col class="ma-2">
      <v-row>
        <h4 class="mt-5">Add Arrival Dates</h4>
        <v-btn color="primary" fab x-small class="mt-4 ml-3" @click="add">
          <v-icon>mdi-plus</v-icon>
        </v-btn>
      </v-row>
    </v-col>
    <v-window
      v-model="window"
      class="elevation-1 mb-3"
      vertical
      v-for="(input, index) in inputs"
      :key="index"
    >
      <v-window-item>
        <v-card flat>
          <v-card-text>
            <v-row>
              <v-col cols="12" sm="11" md="11">
                <v-row>
                  <v-col cols="12" sm="6" md="6">
                    <v-select
                      v-model="input.city"
                      :items="states"
                      menu-props="auto"
                      label="City"
                      hide-details
                      prepend-icon="mdi-map"
                    ></v-select>
                  </v-col>
                  <v-col cols="12" sm="6" md="6">
                    <v-menu
                      v-model="input.calendar"
                      :close-on-content-click="false"
                      :nudge-right="40"
                      transition="scale-transition"
                      offset-y
                      min-width="auto"
                    >
                      <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                          v-model="input.arrival_date"
                          label="Date First Payment"
                          prepend-icon="mdi-calendar"
                          readonly
                          v-bind="attrs"
                          v-on="on"
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        v-model="input.arrival_date"
                        @input="input.calendar = false"
                      ></v-date-picker>
                    </v-menu>
                  </v-col>
                </v-row>
              </v-col>
              <v-col cols="12" sm="1" md="1" class="">
                <div class="text-center">
                  <v-btn
                    color="error"
                    fab
                    x-small
                    class="mt-5"
                    @click="deleteRow(index)"
                  >
                    <v-icon>mdi-minus</v-icon>
                  </v-btn>
                </div>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-window-item>
    </v-window>
    <v-btn :disabled="!valid" color="success" class="mr-4" @click="validate">
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
    states: ["units", "sets"],
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
    product: {
      model: "",
      slug: "",
      stock: "",
      brand: "",
      price_unit: "",
      price_group: "",
      quantity_group: "",
      type_group: "",
      category: "",
      catalogue: "",
    },
    select: null,
    url: null,
    urls: [],
  }),
  mounted() {
    this.getCatalogues();
    this.getCategories();
    this.getProduct();
  },
  methods: {
    validate() {
      console.log(this.product.catalogue.name);
      console.log("hola");
      this.udpdateProduct();
    },
    getProduct() {
      axios
        .get(`/api/v1/products/${this.$route.params.id}`, {
          headers: {
            Authorization: "Bearer " + this.$store.getters.getToken,
            Accept: "application/json",
            "Content-Type": "application/json",
          },
        })
        .then((response) => {
          console.log(response);
          this.product = response.data.data;
          console.log(this.product);
        })
        .catch((error) => {
          console.log(error);
          // reject(error);
        });
    },
    udpdateProduct() {
      console.log(this.product);
      axios
        .put(
          `/api/v1/products/${this.$route.params.id}`,
          {
            model: this.product.model,
            slug: this.product.slug,
            stock: this.product.stock,
            brand: this.product.brand,
            price_unit: this.product.price_unit,
            price_group: this.product.price_group,
            quantity_group: this.product.quantity_group,
            type_group: this.product.type_group,
            category_id: this.product.category.id,
            catalogue_id: this.product.catalogue.id,
          },
          {
            headers: {
              Authorization: "Bearer " + this.$store.getters.getToken,
              Accept: "application/json",
              "Content-Type": "application/json",
            },
          }
        )
        .then((response) => {
          console.log(response);
          this.$router.push({ name: "listProduct" });
        })
        .catch((error) => {
          console.log(error);
          // reject(error);
        });
    },
    addArrivals(id) {
      this.inputs.forEach((elements) => {
        axios
          .post(`/api/catalogues/${id}/arrivals`, elements, {
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
      });
    },
    add() {
      this.inputs.push({
        calendar: "",
        city: "",
        arrival_date: "",
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
    getCategories() {
      axios
        .get("/api/v1/categories", {
          headers: { Authorization: "Bearer " + this.$store.getters.getToken },
        })
        .then((response) => {
          console.log(response);
          this.loading = false;
          this.categories = response.data.data;
          console.log(this.categories);
        })
        .catch((error) => {});
    },
    getCatalogues() {
      axios
        .get("/api/v1/catalogues", {
          headers: { Authorization: "Bearer " + this.$store.getters.getToken },
        })
        .then((response) => {
          console.log(response);
          this.loading = false;
          this.catalogues = response.data.data;
          console.log(this.catalogues);
        })
        .catch((error) => {
          //console.log(error)
          // reject(error);
        });
    },
  },
};
</script>