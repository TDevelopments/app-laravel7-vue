<template>
  <v-row>
    <v-col cols="12" sm="12" md="6" lg="6">
      <v-col cols="12">
        <h3>Add Product Normal</h3>
        <v-card flat elevation="2">
          <v-card-text>
            <v-form ref="form" v-model="valid" lazy-validation>
              <v-row>
                <v-col>
                  <v-row>
                    <v-col cols="12" sm="6" md="6">
                      Product Model
                      <v-text-field
                        solo
                        v-model="product.model"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      Brand
                      <v-text-field
                        solo
                        v-model="product.brand"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6" lg="3">
                      Stock
                      <v-text-field
                        v-model="product.stock"
                        type="number"
                        solo
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6" lg="3">
                      Quantity Group
                      <v-text-field
                        v-model="product.quantity_group"
                        type="number"
                        solo
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6" lg="3">
                      Price Unit
                      <v-text-field
                        v-model="product.price_unit"
                        prefix="$"
                        type="number"
                        solo
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6" lg="3">
                      Price Group
                      <v-text-field
                        v-model="productQG"
                        prefix="$"
                        type="number"
                        solo
                        readonly
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="4" md="4">
                      Type Group
                      <v-select
                        v-model="product.type_group"
                        :items="states"
                        menu-props="auto"
                        solo
                        hide-details
                      ></v-select>
                    </v-col>
                    <v-col cols="12" sm="4" md="4">
                      Category
                      <v-select
                        v-model="product.category"
                        item-text="name"
                        item-value="id"
                        :items="categories"
                        menu-props="auto"
                        solo
                        hide-details
                      ></v-select>
                    </v-col>
                    <v-col cols="12" sm="4" md="4">
                      Catalogue
                      <v-select
                        v-model="product.catalogue"
                        item-text="name"
                        item-value="id"
                        :items="catalogues"
                        menu-props="auto"
                        solo
                        hide-details
                      ></v-select>
                    </v-col>
                  </v-row>
                </v-col>
              </v-row>
            </v-form>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12">
        <h3>Add Product's Colors</h3>
        <v-card class="text-center">
          <v-card-text>
            <v-row>
              <v-col cols="12" sm="5" md="6">
                <v-color-picker
                  :swatches="swatches"
                  show-swatches
                  hide-inputs
                  hide-mode-switch
                  elevation="2"
                ></v-color-picker>
              </v-col>
              <v-col cols="12" sm="7" md="6">
                <v-sheet dark class="pa-2">
                  <pre></pre>
                </v-sheet>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>
    </v-col>
    <v-col cols="12" sm="12" md="6" lg="6">
      <v-col cols="12">
        <h3>Add Product's Descriptions</h3>
        <v-card>
          <v-card-text>
            <v-combobox
              v-model="chips"
              chips
              clearable
              class="pt-5"
              label="Insert the product's descriptions"
              multiple
              solo
            >
              <template v-slot:selection="{ attrs, item, select, selected }">
                <v-chip
                  v-bind="attrs"
                  :input-value="selected"
                  close
                  label
                  class="my-2"
                  @click="select"
                  @click:close="remove(item)"
                  color="primary"
                >
                  {{ item }}
                </v-chip>
              </template>
            </v-combobox>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col>
        <h3>Upload Images</h3>
        <v-card class="mt-5">
          <v-item-group v-model="selected" multiple>
            <v-row>
              <v-col v-for="(item, i) in urls" :key="i" cols="12" md="6">
                <v-item v-slot="{ active, toggle }">
                  <v-img
                    :src="item.src"
                    height="150"
                    class="text-right pa-2"
                    @click="toggle"
                  >
                    <v-btn icon>
                      <v-icon>
                        {{ active ? "mdi-heart" : "mdi-heart-outline" }}
                      </v-icon>
                    </v-btn>
                  </v-img>
                </v-item>
              </v-col>
            </v-row>
          </v-item-group>
          <v-col>
            <v-file-input
              class="mt-5"
              v-model="files"
              label="Images Product"
              multiple
              prepend-icon="mdi-paperclip"
              @change="Preview_image"
              @click="Preview_image"
              @click:clear="clear"
            >
              <template v-slot:selection="{ text }">
                <v-chip small label color="primary">
                  {{ text }}
                </v-chip>
              </template>
            </v-file-input>
          </v-col>
        </v-card>
      </v-col>
    </v-col>
    <v-col>
      <v-btn tile color="success" @click="validate">
        <v-icon left> mdi-content-save </v-icon>
        Save
      </v-btn>
    </v-col>
  </v-row>
</template>
<script>
import axios from "axios";
export default {
  data: () => ({
    selected: [],
    chips: [],
    description: "",
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
      stock: 0,
      brand: "",
      price_unit: 0,
      price_group: 0,
      quantity_group: 0,
      type_group: "",
      category: "",
      catalogue: "",
    },
    select: null,
    url: null,
    urls: [],
    types: ["Unit", "Set"],
    image: [],
    swatches: [
      ["#FF0000", "#AA0000", "#550000"],
      ["#FFFF00", "#AAAA00", "#555500"],
      ["#00FF00", "#00AA00", "#005500"],
      ["#00FFFF", "#00AAAA", "#005555"],
      ["#0000FF", "#0000AA", "#000055"],
    ],
  }),
  computed:{
    productQG: function () {
      // `this` points to the vm instance
      this.product.price_group = this.product.price_unit * this.product.quantity_group;
      return this.product.price_group;
    }
  },
  mounted() {
    this.getCatalogues();
    this.getCategories();
  },
  methods: {
    remove(item) {
      this.chips.splice(this.chips.indexOf(item), 1);
      this.chips = [...this.chips];
    },
    validate() {
      console.log(this.product.catalogue);
      this.addImages();
    },
    addCatalogue() {
      axios
        .post(
          "/api/v1/products",
          {
            model: this.product.model,
            slug: this.product.model,
            stock: this.product.stock,
            brand: this.product.brand,
            price_unit: this.product.price_unit,
            price_group: this.product.price_group,
            quantity_group: this.product.quantity_group,
            type_group: this.product.type_group,
            category_id: this.product.category,
            catalogue_id: this.product.catalogue,
            images: this.image,
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
          this.$router.replace({ name: "listProduct" });
        })
        .catch((error) => {
          console.log(error);
          // reject(error);
        });
    },
    addImages() {
      const data = new FormData();
      this.files.forEach((elements, index) => {
        console.log(index);
        console.log(elements);
        data.append(`image_uploads[${index}]`, elements);
      });
      axios
        .post(`/api/v1/uploads`, data, {
          headers: {
            Authorization: "Bearer " + this.$store.getters.getToken,
            Accept: "application/json",
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          this.image = response.data;
          console.log("aqui", response.data);
          this.addCatalogue();
        })
        .catch((error) => {
          console.log(error);
          // reject(error);
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