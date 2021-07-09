<template>
  <div class="px-3 py-3">
    <v-row class="mx-1">
      <div class="my-2">
        <h3 v-if="varBoolean">Datos Generales Generales</h3>
        <h3 v-else>Nuevo producto por conjunto</h3>
      </div>
      <v-spacer></v-spacer>
      <div>
        <v-switch v-model="varBoolean" class="ml-2" />
      </div>
    </v-row>

    <v-row>
      <v-col cols="12" class="pt-0">
        <v-card flat elevation="2">
          <v-card-text>
            <v-form ref="form" v-model="valid" lazy-validation>
              <v-row>
                <v-col cols="12" sm="4" md="4" v-if="!varBoolean">
                  Modelo (*)
                  <v-text-field
                    solo
                    v-model="product.model"
                    required
                    placeholder="Example"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="4" md="4" v-if="!varBoolean">
                  Marca
                  <v-text-field
                    solo
                    v-model="product.brand"
                    required
                    placeholder="Example"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="4" md="4" v-if="!varBoolean">
                  Incremento
                  <v-text-field
                    solo
                    v-model="product.magnifying"
                    required
                    type="number"
                    placeholder="0"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="3" md="3" lg="3" v-if="!varBoolean">
                  Stock Meta (*)
                  <v-text-field
                    v-model="product.stock"
                    type="number"
                    solo
                    placeholder="0"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="3" md="3" lg="3" v-if="!varBoolean">
                  Cantidad minima por cliente (*)
                  <v-text-field
                    v-model="product.quantity_group"
                    type="number"
                    solo
                    placeholder="0"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="3" md="3" lg="3" v-if="!varBoolean">
                  Precio por unidad (*)
                  <v-text-field
                    v-model="product.price_unit"
                    type="number"
                    solo
                    placeholder="0"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="3" md="3" lg="3" v-if="!varBoolean">
                  Precio por conjunto (*)
                  <v-text-field
                    v-model="productQG"
                    type="number"
                    solo
                    readonly
                    placeholder="0"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="3" md="3" lg="3" v-if="!varBoolean">
                  Género
                  <v-select
                    v-model="gender"
                    item-text="name"
                    item-value="send"
                    :items="genderItems"
                    menu-props="auto"
                    solo
                    hide-details
                    placeholder="Selecciona"
                  ></v-select>
                </v-col>
                <v-col cols="12" sm="3" md="3" lg="3">
                  Tipo de grupo (*)
                  <v-select
                    v-model="product.type_group"
                    Types
                    Group
                    :items="measures"
                    menu-props="auto"
                    solo
                    hide-details
                    placeholder="Selecciona"
                  ></v-select>
                </v-col>
                <v-col cols="12" sm="3" md="3" lg="3">
                  Categoria (*)
                  <v-select
                    v-model="product.category_id"
                    item-text="name"
                    item-value="id"
                    :items="categories"
                    menu-props="auto"
                    solo
                    hide-details
                    placeholder="Selecciona"
                  ></v-select>
                </v-col>
                <v-col cols="12" sm="3" md="3" lg="3">
                  Catalogo (*)
                  <v-select
                    v-model="product.catalogue_id"
                    item-text="name"
                    item-value="id"
                    :items="catalogues"
                    menu-props="auto"
                    solo
                    hide-details
                    placeholder="Selecciona"
                  ></v-select>
                </v-col>
              </v-row>
            </v-form>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" sm="12" md="6" lg="6" v-if="!varBoolean">
        <h3>Colores de producto</h3>
        <v-select
          v-model="colors"
          :items="colorsSelect"
          label="Select"
          item-text="name"
          item-value="code"
          multiple
          chips
          solo
          dense
          persistent-hint
        ></v-select>
      </v-col>
      <v-col cols="12" sm="12" md="6" lg="6" v-if="!varBoolean">
        <h3>Detalles del producto</h3>
        <v-card>
          <v-card-text>
            <v-combobox v-model="description" chips clearable multiple solo>
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
      <v-col cols="12" sm="12" md="6" lg="6" v-if="!varBoolean">
        <h3>Subir imagenes</h3>
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
                        <v-icon color="red">
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
                label="Imagenes del Producto"
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
      <!-- <v-col cols="12" sm="12" md="6" lg="6" v-if="!varBoolean">
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
      </v-col> -->
    </v-row>
    <v-col v-if="varBoolean" class="ma-2">
      <v-row>
        <h4 class="mt-5">Añadir Productos Masivos</h4>
      </v-row>
    </v-col>
    <v-window class="elevation-1 mb-3" vertical v-if="varBoolean">
      <v-window-item>
        <div class="table-responsive-sm">
          <table class="table">
            <thead class="bg-primary text-white">
              <tr>
                <th scope="col">Model</th>
                <th scope="col">Stock</th>
                <th scope="col">Marca</th>
                <th scope="col">Precio Unitario</th>
                <th scope="col">Cantidad Minima por Cliente</th>
                <th scope="col">Precio Total por Conjunto</th>
                <th scope="col">Colores</th>
                <th scope="col">Detalles</th>
                <th scope="col">Imagen</th>
                <th scope="col">
                  <v-btn small icon dark color="black" @click="addVariation">
                    <v-icon small>mdi-plus </v-icon>
                  </v-btn>
                </th>
              </tr>
            </thead>
            <tr v-for="(itemV, indexV) in variaciones" :key="indexV">
              <td>
                <v-text-field v-model="itemV.model" solo dense required></v-text-field>
              </td>
              <td>
                <v-text-field v-model="itemV.stock" solo dense required></v-text-field>
              </td>
              <td>
                <v-text-field v-model="itemV.brand" solo dense required></v-text-field>
              </td>
              <td>
                <v-text-field v-model="itemV.price_unit" solo dense required></v-text-field>
              </td>
              <td>
                <v-text-field v-model="itemV.quantity_group" solo dense required></v-text-field>
              </td>
              <td>
                <v-text-field v-model="itemV.price_group" solo dense required></v-text-field>
              </td>
              <td>
                <v-dialog transition="dialog-bottom-transition" max-width="600">
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn small color="primary" v-bind="attrs" v-on="on" class="mt-1">
                      + Colores
                    </v-btn>
                  </template>
                  <template v-slot:default="dialog">
                    <v-card>
                      <v-toolbar color="primary" dark>
                        Añadir Colores
                      </v-toolbar>
                      <v-card-text class="mt-5">
                        <v-row>
                          <v-col cols="12" md="6">
                            <v-color-picker
                              hide-inputs
                              v-model="color"
                              class="mx-auto"
                            ></v-color-picker>
                          </v-col>
                          <v-col cols="12" md="6">
                            <v-row>
                              <v-col>
                                <v-btn class="mb-5 my-auto mt-2" @click="addColorMultiple(indexV)">
                                  Añadir Color
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
                              <v-col v-for="(item, index) in itemV.colors" :key="index" cols="1">
                                <v-avatar
                                  :color="item"
                                  size="15"
                                  @click="deleteColorMultiple(indexV, index)"
                                ></v-avatar>
                              </v-col>
                            </v-row>
                          </v-col>
                        </v-row>
                      </v-card-text>
                      <v-card-actions class="justify-end">
                        <v-btn text @click="dialog.value = false">Close</v-btn>
                      </v-card-actions>
                    </v-card>
                  </template>
                </v-dialog>
              </td>
              <td>
                <v-dialog transition="dialog-bottom-transition" max-width="600">
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn color="primary" small v-bind="attrs" v-on="on" class="mt-1">
                      + Detalles
                    </v-btn>
                  </template>
                  <template v-slot:default="dialog">
                    <v-card>
                      <v-toolbar color="primary" dark>Añadir Descripcion</v-toolbar>
                      <v-card-text>
                        <v-combobox v-model="itemV.description" chips clearable multiple solo>
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
                      <v-card-actions class="justify-end">
                        <v-btn text @click="dialog.value = false">Close</v-btn>
                      </v-card-actions>
                    </v-card>
                  </template>
                </v-dialog>
              </td>
              <td>
                <v-file-input
                  v-model="itemV.images_upload"
                  label="Imagen"
                  multiple
                  solo
                  counter
                  dense
                  accept="image/png, image/jpeg"
                  prepend-icon="mdi-camera"
                  @change="uploadImage(itemV.images_upload, indexV)"
                  @click="uploadImage(itemV.images_upload, indexV)"
                  @click:clear="clearImage(indexV)"
                >
                </v-file-input>
              </td>
              <td>
                <v-btn small icon dark color="red" @click="deleteVariation(indexV)">
                  <v-icon small>mdi-minus </v-icon>
                </v-btn>
              </td>
            </tr>
          </table>
        </div>
      </v-window-item>
    </v-window>
    <v-row class="mx-3">
      <v-spacer> </v-spacer>
      <v-btn color="red" dark class="mr-3 my-5" @click="listRouter">
        <v-icon left> mdi-delete </v-icon>
        Cancelar
      </v-btn>
      <v-btn :disabled="!valid" color="#0D52D6" dark class="mr-3 my-5" @click="validate">
        <v-icon left> mdi-content-save </v-icon>
        Guardar
      </v-btn>
    </v-row>
    <ModalSave v-model="dialogSave" v-if="dialogSave" />
    <ModalError v-model="dialogError" v-if="dialogError" :body="message" />
  </div>
</template>
<script>
import ModalSave from '../component/ModalSave';
import ModalError from '../component/ModalError';

export default {
  components: {
    ModalSave,
    ModalError,
  },
  data: () => ({
    // Object Product
    product: {},
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
    // Data Images(Response to peticion post save images)
    image: [],
    // Data of Color Picker
    colors: [],
    type: 'hex',
    hex: '#FF00FF',
    // Validation
    valid: true,
    colorsSelect:[],
    varBoolean: false,
    variaciones: [],
    varSelection: ['color', 'T/T'],
    selection: 'color',
    dialogColor: false,
    dialgoDescripciones: false,
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
    dialogSave: false,
    dialogError: false,
    message: '',
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
    this.getCatalogues();
    this.getCategories();
    this.getMeasures();
    this.getColors();
  },

  methods: {
    // Validation
    validate() {
      this.dialogSave = true
      if (this.varBoolean) {
        this.addProduct();
      } else {
        if (this.files.length != 0) {
          this.addImages();
        } else {
          this.addProduct();
        }
      }
    },
    // Peticion Get Categories
    getCategories() {
      axios
        .get('/api/v1/categories')
        .then(response => {
          this.categories = response.data.data;
        })
        .catch(error => {});
    },

    // Peticion Get Catalogues
    getCatalogues() {
      axios
        .get('/api/v1/catalogues')
        .then(response => {
          this.catalogues = response.data.data;
        })
        .catch(error => {

        });
    },

    getMeasures() {
      axios
        .get('/api/v1/measures')
        .then(response => {
          response.data.forEach(element => {
            this.measures.push(element.name);
          });
        })
        .catch(error => {

        });
    },

    getColors() {
      axios
        .get('/api/v1/colors')
        .then(response => {
          this.colorsSelect = response.data.data
        })
        .catch(error => {

        });
    },

    // Peticion Add Catalogue
    addProduct() {
      if (this.varBoolean) {
        axios
          .post('/api/v1/products-massive', { products: this.variaciones })
          .then(response => {
            this.dialogSave = false;
            this.$router.replace({ name: 'listProduct' });
          })
          .catch(error => {
            this.dialogSave = false;
            this.message =
              'Ocurrio un error al guardar los datos generales, verifique que todos los datos necesarioes esten completos y vuelva a intentarlo';
            this.dialogError = true;
          });
      } else {
        let data = {};
        for (const property in this.product) {
          if (this.product[property] != null || this.product[property] != '') {
            data.[property] = this.product[property];
          }
        }
        if (this.image != null || this.image.length != 0) {
          data.images = this.image;
        }
        if (this.description != null || this.description.length != 0) {
          data.description  = this.description;
        }
        if (this.colors != null || this.colors.length != 0) {
          data.colors = this.colors;
        }
        if (this.gender != null || this.gender != 0) {
          data.gender = this.gender;
        }
        axios
          .post('/api/v1/products', data)
          .then(response => {
            this.$router.replace({ name: 'listProduct' });
          })
          .catch(error => {
            this.dialogSave = false;
            this.message =
              'Ocurrio un error al guardar los datos generales, verifique que todos los datos necesarioes esten completos y vuelva a intentarlo';
            this.dialogError = true;
          });
      }
    },

    // Peticion Add Images
    addImages() {
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
          this.image = response.data;
          this.addProduct();
        })
        .catch(error => {
          this.dialogSave = false;
          this.message =
            'Ocurrio un error al guardar la imagen, verifica que la imagen no pese mas de 10 Mb.';
          this.dialogError = true;
        });
    },

    // Remove Chips of Descriptions
    remove(item) {
      this.description.splice(this.description.indexOf(item), 1);
      this.description = [...this.description];
    },

    // Preview Images
    previewImages() {
      if (this.files.length != 0) {
        this.files.forEach(element => {
          this.urls.push({
            src: URL.createObjectURL(element),
            checkbox: false,
          });
        });
      }
    },

    // Clear Images
    clear() {
      this.files = [];
      this.urls = [];
    },

    // Add Colors
    addPColor() {
      this.colors.push(this.showColor);
    },

    // Delete Color
    deleteColor(index) {
      this.colors.splice(index, 1);
    },

    addColorMultiple(id) {
      this.variaciones[id].colors.push(this.showColor);
    },

    // Delete Color
    deleteColorMultiple(id, index) {
      this.variaciones[id].colors.splice(index, 1);
    },

    // Return List Product
    listRouter() {
      this.$router.replace({ name: 'listProduct' });
    },
    // Add New Component Variation
    addVariation() {
      if (
        this.product.catalogue_id != '' &&
        this.product.category_id != '' &&
        this.product.type_group != ''
      ) {
        this.variaciones.push({
          model: '',
          stock: '',
          brand: '',
          price_unit: '',
          price_group: '',
          quantity_group: '',
          type_group: this.product.type_group,
          category_id_id: this.product.category_id,
          catalogue_id_id: this.product.catalogue_id,
          images: [],
          images_upload: [],
          description: [],
          colors: [],
        });
      } else {
        alert('Tienes que llenar los datos Generales Primero');
      }
    },

    // Delete Component Variation
    deleteVariation(index) {
      this.variaciones.splice(index, 1);
    },

    uploadImage(images, id) {
      if (images != 0) {
        const data = new FormData();
        images.forEach((elements, index) => {
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
            this.variaciones[id].images = response.data;
          })
          .catch(error => {

          });
      }
    },
    clearImage(id) {
      this.variaciones[id].images_upload = [];
      this.variaciones[id].images = [];
    },
  },
};
</script>
