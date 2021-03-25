<template>
  <div>
    <v-row class="mx-2 my-2">
      <v-col cols="12">
        <h3>Editar producto</h3>
        <v-card flat elevation="2">
          <v-card-text>
            <v-form ref="form" v-model="valid" lazy-validation>
              <v-row>
                <v-col cols="12" sm="6" md="3">
                  Modelo
                  <v-text-field solo v-model="product.model" required></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="3">
                  Marca
                  <v-text-field solo v-model="product.brand" required></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="3">
                  SKU
                  <v-text-field solo v-model="product.sku" required readonly></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="3">
                  Incremento
                  <v-text-field
                    solo
                    v-model="product.magnifying"
                    required
                    type="number"
                    placeholder="0"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6" lg="3">
                  Stock Meta
                  <v-text-field v-model="product.stock" type="number" solo></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6" lg="3">
                  Cantidad minima por cliente
                  <v-text-field v-model="product.quantity_group" type="number" solo></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6" lg="3">
                  Precio por unidad
                  <v-text-field v-model="product.price_unit" type="number" solo></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6" lg="3">
                  Precio por conjunto
                  <v-text-field v-model="productQG" type="number" solo readonly></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6" lg="3">
                  Género
                  <v-select
                    v-model="product.gender"
                    item-text="name"
                    item-value="send"
                    :items="genderItems"
                    menu-props="auto"
                    solo
                    hide-details
                    placeholder="Selecciona"
                  ></v-select>
                </v-col>
                <v-col cols="12" sm="6" md="6" lg="3">
                  Tipo de grupo
                  <v-select
                    v-model="product.type_group"
                    Types
                    Group
                    :items="measures"
                    menu-props="auto"
                    solo
                    hide-details
                  ></v-select>
                </v-col>
                <v-col cols="12" sm="6" md="6" lg="3">
                  Categoria
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
                <v-col cols="12" sm="6" md="6" lg="3">
                  Catalogo
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
            </v-form>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" sm="12" md="6" lg="6">
        <h3>Colores de producto</h3>
        <v-card class="text-center">
          <v-card-text>
            <v-row>
              <v-col cols="12" md="6">
                <v-color-picker hide-inputs v-model="color" class="mx-auto"></v-color-picker>
              </v-col>
              <v-col cols="12" md="6">
                <v-row>
                  <v-col>
                    <v-btn class="mb-5 my-auto mt-2" @click="addPColor">
                      Añadir Producto
                    </v-btn>
                  </v-col>
                  <v-col>
                    <v-sheet dark class="pa-1">
                      <p class="mt-2 text-white">{{ showColor }}</p>
                    </v-sheet>
                  </v-col>
                </v-row>
                <v-col>
                  <h5>Colores</h5>
                </v-col>
                <v-row class="pr-3">
                  <v-col v-for="(item, index) in colors" :key="index" cols="1">
                    <v-avatar :color="item" size="15" @click="deleteColor(index)"></v-avatar>
                  </v-col>
                </v-row>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" sm="12" md="6" lg="6">
        <h3>Detalles del producto</h3>
        <v-card>
          <v-card-text>
            <v-combobox
              v-model="description"
              chips
              clearable
              class="pt-5"
              label="Inserta los detalles del producto"
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
      <v-col cols="12" sm="12" md="6" lg="6">
        <h3>Subir Imagenes</h3>
        <v-card class="mt-5">
          <v-item-group v-model="selectedDelete" multiple>
            <v-row>
              <v-col v-for="(item, i) in images" :key="i" cols="12" sm="3" md="3">
                <v-item v-slot="{ active, toggle }" class="mx-3">
                  <v-img :src="item.path" height="150" class="text-right" @click="toggle" contain>
                    <v-btn icon>
                      <v-icon color="red" @click="deleteImage(i, item)">
                        mdi-delete
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
              @change="previewImages"
              @click="previewImages"
              @click:clear="clear"
              ref="fileupload"
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
      <v-col cols="12" sm="12" md="6" lg="6">
        <h3>Subir video</h3>
        <v-card class="mt-5">
          <v-card-text>
            <v-item-group v-model="selected" multiple>
              <v-row>
                <v-col v-for="(item, i) in urls" :key="i" cols="12" md="3" sm="3">
                  <v-item v-slot="{ active, toggle }">
                    <v-img
                      :src="item.src"
                      height="150"
                      class="text-right pa-2"
                      @click="toggle"
                      contain
                    >
                      <v-btn icon>
                        <v-icon>
                          {{ active ? 'mdi-heart' : 'mdi-heart-outline' }}
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
                label="Video del producto"
                multiple
                prepend-icon="mdi-paperclip"
                @change="previewImages"
                @click="previewImages"
                @click:clear="clear"
              >
                <template v-slot:selection="{ text }">
                  <v-chip small label color="primary">
                    {{ text }}
                  </v-chip>
                </template>
              </v-file-input>
            </v-col>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <v-row class="mx-3">
      <v-spacer> </v-spacer>
      <v-btn color="red" dark class="mr-3 my-5" @click="listRouter">
        <v-icon left> mdi-delete </v-icon>
        Cancelar
      </v-btn>
      <v-btn :disabled="!valid" color="success" class="mr-3 my-5" @click="validate">
        <v-icon left> mdi-content-save </v-icon>
        Guardar
      </v-btn>
    </v-row>
  </div>
</template>

<script>
export default {
  data: () => ({
    // Object Product
    product: {
      model: '',
      slug: '',
      sku: '',
      stock: '',
      brand: '',
      price_unit: '',
      price_group: '',
      quantity_group: '',
      type_group: '',
      category: '',
      catalogue: '',
      images: null,
    },
    // Object Catalogue
    catalogues: [],
    // Object Categorie
    categories: [],
    // Object of Images
    files: [],
    // Chip of Description
    description: [],
    selected: [],
    select: null,
    // Options of Types Group
    types: ['unidades', 'sets', 'cajas'],
    // Url of Images
    urls: [],
    // Data of Color Picker
    colors: [],
    type: 'hex',
    hex: '#FF00FF',
    // Items Image Delete
    selectedDelete: [],
    // Items Image Show
    images: [],
    // Validation
    valid: true,
    measures: [],
    gender: 'none',
    genderItems: [
      {
        name: 'Ninguno',
        send: 'none',
      },
      {
        name: 'Masculino',
        send: 'masculine',
      },
      {
        name: 'Femenino',
        send: 'female',
      },
    ],
  }),
  computed: {
    productQG: function() {
      this.product.price_group = this.product.price_unit * this.product.quantity_group;
      return this.product.price_group;
    },
    color: {
      get() {
        return this[this.type];
      },
      set(v) {
        this[this.type] = v;
      },
    },
    showColor() {
      if (typeof this.color === 'string') return this.color;

      return JSON.stringify(
        Object.keys(this.color).reduce((color, key) => {
          color[key] = Number(this.color[key].toFixed(2));
          return color;
        }, {}),
        null,
        2
      );
    },
  },
  mounted() {
    this.getProduct();
    this.getCatalogues();
    this.getCategories();
    this.getMeasures();
  },
  methods: {
    // Validation
    validate() {
      if (this.files.length != 0) {
        this.addImages();
      } else {
        this.editProduct();
      }
    },

    // Peticion Get Categories
    getCategories() {
      axios
        .get('/api/v1/categories')
        .then(response => {
          console.log(response);
          this.loading = false;
          this.categories = response.data.data;
          console.log(this.categories);
        })
        .catch(error => {});
    },

    // Peticion Get Catalogues
    getCatalogues() {
      axios
        .get('/api/v1/catalogues')
        .then(response => {
          console.log(response);
          this.loading = false;
          this.catalogues = response.data.data;
          console.log(this.catalogues);
        })
        .catch(error => {
          //console.log(error)
          // reject(error);
        });
    },

    getMeasures() {
      axios
        .get('/api/v1/measures')
        .then(response => {
          console.log(response.data);
          response.data.forEach(element => {
            this.measures.push(element.name);
          });
        })
        .catch(error => {
          //console.log(error)
          // reject(error);
        });
    },

    // Peticion Get Product
    getProduct() {
      axios
        .get(`/api/v1/products/${this.$route.params.id}`, {
          headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
          },
        })
        .then(response => {
          console.log(response);
          this.product = response.data.data;
          this.product.catalogue = response.data.data.catalogue.id;
          this.product.category = response.data.data.category.id;
          response.data.data.description.forEach(element => {
            this.description.push(element);
          });
          response.data.data.colors.forEach(element => {
            this.colors.push(element);
          });
          response.data.data.images.forEach(element => {
            this.images.push(element);
          });
        })
        .catch(error => {
          console.log(error);
          // reject(error);
        });
    },

    // Peticion Add Images
    addImages() {
      // Declaring Forma Data
      const data = new FormData();
      this.files.forEach((elements, index) => {
        data.append(`image_uploads[${index}]`, elements);
      });

      axios
        .post(`/api/v1/uploads`, data, {
          headers: {
            Accept: 'application/json',
            'Content-Type': 'multipart/form-data',
          },
        })
        .then(response => {
          response.data.forEach(elements => {
            this.product.images.push(elements);
            console.log(elements);
          });
          console.log('imagenes', this.product.images);
          this.editProduct();
        })
        .catch(error => {
          console.log(error);
          // reject(error);
        });
    },

    // Peticion Update Product
    editProduct() {
      console.log(this.product);

      let data = {
        model: this.product.model,
        stock: this.product.stock,
        sku: this.product.sku,
        brand: this.product.brand,
        price_unit: this.product.price_unit,
        price_group: this.product.price_group,
        quantity_group: this.product.quantity_group,
        type_group: this.product.type_group,
        category_id: this.product.category,
        catalogue_id: this.product.catalogue,
        description: this.description,
        colors: this.colors,
        images: this.product.images,
        magnifying: this.product.magnifying,
        gender: this.product.gender,
      };

      axios
        .put(`/api/v1/products/${this.$route.params.id}`, data, {
          headers: {
            Accept: 'application/json',
          },
        })
        .then(response => {
          console.log('Response', response);
          this.$router.replace({ name: 'listProduct' });
        })
        .catch(error => {
          console.log(error);
          // reject(error);
        });
    },

    // Remove Chips of Descriptions
    remove(item) {
      this.description.splice(this.description.indexOf(item), 1);
      this.description = [...this.description];
    },

    // Preview Images
    previewImages() {
      if (this.files.length == 0) {
        console.log('esta vacio');
      } else {
        this.files.forEach((element, index) => {
          this.images.push({
            path: URL.createObjectURL(element),
            new: true,
            id: index,
          });
        });
        console.log(this.urls);
      }
    },

    // Clear Images
    clear() {
      this.files = [];
    },

    // Clear One Image
    clearOneImage(index) {
      this.files.splice(index, 1);
    },

    // Add Color
    addPColor() {
      this.colors.push(this.showColor);
    },

    // Delete Color
    deleteColor(index) {
      this.colors.splice(index, 1);
    },

    // Delete Image
    deleteImage(index, item) {
      this.images.splice(index, 1);
      if (!item.new) {
        this.product.images.splice(index, 1);
      }
      if (item.new) {
        this.clearOneImage(item.id);
      }
      this.$refs.fileupload.model = this.files;
    },

    // Return List Product
    listRouter() {
      this.$router.replace({ name: 'listProduct' });
    },
  },
};
</script>
