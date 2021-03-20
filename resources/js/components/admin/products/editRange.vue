<template>
  <v-col>
    <v-window v-model="window" class="elevation-1" vertical>
      <v-window-item>
        <v-card flat>
          <v-card-text>
            <h3>Edit Product Range</h3>
            <v-divider></v-divider>
            <v-form ref="form" v-model="valid" lazy-validation>
              <v-row>
                <v-col cols="12" sm="8" md="8">
                  <v-row>
                    <v-col cols="12" sm="6" md="6">
                      <v-text-field
                        v-model="productRange.model"
                        :counter="10"
                        label="Product Model"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      <v-text-field
                        v-model="productRange.slug"
                        :counter="10"
                        label="Slug"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      <v-text-field
                        v-model="productRange.stock"
                        :counter="10"
                        label="Stock"
                        required
                        type="number"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      <v-text-field
                        v-model="productRange.brand"
                        :counter="10"
                        label="Brand"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      <v-select
                        v-model="productRange.category"
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
                        v-model="productRange.catalogue"
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
                      id="files"
                      ref="files"
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
        <h4 class="mt-5">Add Ranges</h4>
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
                  <v-col cols="12" sm="4" md="4">
                    <v-text-field
                      v-model="input.price"
                      :counter="10"
                      label="Price"
                      required
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="4" md="4">
                    <v-text-field
                      v-model="input.min"
                      :counter="10"
                      label="Minimum"
                      required
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="4" md="4">
                    <v-text-field
                      v-model="input.max"
                      :counter="10"
                      label="Maximum"
                      required
                    ></v-text-field>
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
    window: null,
    valid: true,
    productRange: {
      model: "",
      slug: "",
      stock: "",
      brand: "",
      category: "",
      catalogue: "",
    },
    catalogues: [],
    categories: [],
    select: null,
    url: null,
    urls: [],
    inputs: [],
  }),
  mounted() {
    this.getProductRange();
    this.getCategories();
    this.getCatalogues();
  },
  methods: {
    validate() {
      console.log(this.productRange.catalogue);
      this.addProductRange();
    },
    getProductRange() {
      axios
        .get(`/api/v1/product-ranges/${this.$route.params.id}`, {
          headers: {
            Authorization: "Bearer " + this.$store.getters.getToken,
            Accept: "application/json",
          },
        })
        .then((response) => {
          console.log(response);
          this.productRange = response.data.data;
          this.inputs = response.data.data.ranges;
          this.productRange.catalogue = response.data.data.catalogue.id;
          this.productRange.category = response.data.data.category.id;
          console.log(this.inputs);
          console.log(this.productRange);
        })
        .catch((error) => {
          console.log(error);
          // reject(error);
        });
    },
    addProductRange() {
      // this.files.forEach((elements, index) => {
      //   console.log(index);
      //   console.log(elements);
      //   data.append(`images_upload[${index}]`, elements);
      // });
      console.log("data",this.productRange);
      axios
        .put(
          `/api/v1/product-ranges/${this.$route.params.id}`,
          {
            model: this.productRange.model,
            slug: this.productRange.slug,
            stock: this.productRange.stock,
            brand: this.productRange.brand,
            category_id: this.productRange.category,
            catalogue_id: this.productRange.catalogue,
          },
          {
            headers: {
              Authorization: "Bearer " + this.$store.getters.getToken,
              Accept: "application/json",
            },
          }
        )
        .then((response) => {
          console.log(response);
          this.addRange(response.data.data.id);
        })
        .catch((error) => {
          console.log(error);
          // reject(error);
        });
    },
    addRange(id) {
      axios
        .post(
          `/api/v1/product-ranges/${id}/ranges`,
          { items: this.inputs },
          {
            headers: {
              Authorization: "Bearer " + this.$store.getters.getToken,
              Accept: "application/json",
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
    add() {
      this.inputs.push({
        min: "",
        max: "",
        price: "",
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