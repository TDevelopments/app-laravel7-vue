<template>
  <div class="px-3 py-3">
    <v-row class="mx-1">
      <div class="my-2">
        <h3 v-if="varBoolean">Datos Generales Generales</h3>
        <h3 v-else>Nuevo Producto (Rango)</h3>
      </div>
      <v-spacer></v-spacer>
      <div>
        <v-switch v-model="varBoolean" @click="valueInitial" label="Añadir Variaciones" />
      </div>
    </v-row>
    <v-row>
      <v-col cols="12">
        <v-card flat elevation="2">
          <v-card-text>
            <v-form ref="form" lazy-validation>
              <v-row>
                <v-col>
                  <v-row>
                    <v-col cols="12" sm="6" md="4" lg="4">
                      Modelo (*)
                      <v-text-field
                        solo
                        v-model="productRange.model"
                        required
                        placeholder="Example"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4" lg="4">
                      Marca
                      <v-text-field
                        solo
                        v-model="productRange.brand"
                        required
                        placeholder="Example"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4" lg="4">
                      Stock Meta (*)
                      <v-text-field
                        v-model="productRange.stock"
                        type="number"
                        solo
                        placeholder="0"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="4" md="4">
                      Categoria (*)
                      <v-select
                        v-model="productRange.category_id"
                        item-text="name"
                        item-value="id"
                        :items="categories"
                        menu-props="auto"
                        solo
                        hide-details
                        placeholder="Selecciona"
                      ></v-select>
                    </v-col>
                    <v-col cols="12" sm="4" md="4">
                      Catalogo (*)
                      <v-select
                        v-model="productRange.catalogue_id"
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
                </v-col>
              </v-row>
            </v-form>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" sm="12" md="6" lg="6" v-if="!varBoolean">
        <h3>Colores de Producto</h3>
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
      <v-col cols="12" sm="12" :md="!varBoolean ? '6' : '12'" :lg="!varBoolean ? '6' : '12'">
        <h3>Detalles del Producto</h3>
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
      <v-col v-if="!varBoolean" cols="6">
        <h3>Subir Imagenes</h3>
        <v-card class="mt-5">
          <v-card-text>
            <v-item-group v-model="selected" multiple>
              <v-row>
                <v-col v-for="(item, i) in images" :key="i" cols="12" md="3" sm="3">
                  <v-item v-slot="{ active, toggle }">
                    <v-img
                      :src="item.src"
                      height="150"
                      class="text-right pa-2"
                      @click="toggle"
                      contain
                    >
                    </v-img>
                  </v-item>
                </v-col>
              </v-row>
            </v-item-group>
          </v-card-text>
          <v-col>
            <v-file-input
              class="mt-5"
              v-model="files"
              label="Imagen del Producto"
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
        </v-card>
      </v-col>
    </v-row>
    <v-col class="ma-2 mx-4">
      <v-row>
        <h4 class="mt-5">Añadir Rangos</h4>
      </v-row>
    </v-col>
    <v-window class="elevation-1 mb-3 mx-4" vertical>
      <v-window-item>
        <div class="table-responsive-lg">
          <table class="table">
            <thead class="bg-primary text-white">
              <th scope="col">Rango Minimo (*)</th>
              <th scope="col">Rango Maximo (*)</th>
              <th scope="col">Precio (*)</th>
              <th scope="col" class="text-right">
                <v-btn color="black" small @click="add" icon>
                  <v-icon small>mdi-plus</v-icon>
                </v-btn>
              </th>
            </thead>
            <tr v-for="(input, index) in inputs" :key="index">
              <td>
                <v-text-field v-model="input.min" solo required dense type="number"></v-text-field>
              </td>
              <td>
                <v-text-field v-model="input.max" solo required dense type="number"></v-text-field>
              </td>
              <td>
                <v-text-field
                  v-model="input.price"
                  solo
                  required
                  dense
                  type="number"
                ></v-text-field>
              </td>
              <td class="text-right">
                <v-btn color="error" small @click="deleteRow(index)" icon>
                  <v-icon small>mdi-minus</v-icon>
                </v-btn>
              </td>
            </tr>
          </table>
        </div>
      </v-window-item>
    </v-window>
    <v-window class="elevation-1 mb-3" vertical v-if="varBoolean">
      <v-col class="ma-2">
        <v-row>
          <h4 class="mt-5">Variaciones</h4>
        </v-row>
      </v-col>
      <v-window-item>
        <div class="table-responsive-lg">
          <table class="table">
            <thead class="bg-warning">
              <tr>
                <th scope="col">Tipo</th>
                <th scope="col">Variaciones</th>
              </tr>
            </thead>
            <tr>
              <td class="ws">
                <v-select :items="varSelection" v-model="selection"></v-select>
              </td>
              <td>
                <div class="table-responsive-sm">
                  <table class="table">
                    <thead class="bg-primary text-white">
                      <tr>
                        <th scope="col">Model</th>
                        <th scope="col">Colores</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Video</th>
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
                                        <v-btn
                                          class="mb-5 my-auto mt-2"
                                          @click="addColorMultiple(indexV)"
                                        >
                                          Añadir Color
                                        </v-btn>
                                      </v-col>
                                      <v-col>
                                        <v-sheet dark class="pa-1">
                                          <p class="mt-2 text-white">
                                            {{ showColor }}
                                          </p>
                                        </v-sheet>
                                      </v-col>
                                    </v-row>
                                    <v-col>
                                      <h5>Colores</h5>
                                    </v-col>
                                    <v-row class="pr-3">
                                      <v-col
                                        v-for="(item, index) in itemV.colors"
                                        :key="index"
                                        cols="1"
                                      >
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
                        <v-file-input
                          v-model="itemV.video"
                          label="Video"
                          multiple
                          solo
                          counter
                          dense
                          prepend-icon="mdi-video"
                          @change="previewImages"
                          @click:clear="clear"
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
              </td>
            </tr>
          </table>
        </div>
      </v-window-item>
    </v-window>

    <v-row>
      <v-spacer> </v-spacer>
      <v-btn color="red" dark class="mr-3 my-5" @click="returnList">
        <v-icon left> mdi-delete </v-icon>
        Cancelar
      </v-btn>
      <v-btn :disabled="!valid" color="success" class="mr-3 my-5" @click="validation">
        <v-icon left> mdi-content-save </v-icon>
        Guardar
      </v-btn>
    </v-row>
    <ModalSave v-model="dialogSave" v-if="dialogSave" />
    <ModalError v-model="dialogError" v-if="dialogError" :body="message" />
  </div>
</template>
<script>
import axios from 'axios';
import ModalSave from '../component/ModalSave';
import ModalError from '../component/ModalError';

export default {
  components: {
    ModalSave,
    ModalError,
  },
  data: () => ({
    // Object Product Range
    productRange: {
      model: '',
      slug: '',
      sku: '',
      stock: '',
      brand: '',
      category: '',
      catalogue: '',
      ranges: '',
    },
    // Catalogues
    catalogues: [],
    // Categories
    categories: [],
    // Content Images
    files: [],
    // Description
    selected: [],
    description: [],
    // Image
    images: [],
    imageResponse: [],
    // Colors
    type: 'hex',
    hex: '#FF00FF',
    colors: [],
    colorsSelect: [],
    // Ranges
    inputs: [
      {
        min: 0,
        max: 0,
        price: 0,
      },
    ],
    // Validacion
    valid: true,
    // Variaciones
    variaciones: [],
    varSelection: ['color', 'Tamaño/Talla'],
    selection: 'color',
    varBoolean: false,
    cont: 0,
    dialogSave: false,
    dialogError: false,
    message: '',
  }),
  methods: {
    // Validation of Request Images
    validation() {
      this.dialogSave = true
      if (this.varBoolean) {
        this.addProductRange();
      } else {
        if (this.files.length != 0) {
          this.addImages();
        } else {
          this.addProductRange();
        }
      }
    },

    // Post Images
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
          this.imageResponse = response.data;
          this.addProductRange();
        })
        .catch(error => {
          this.dialogSave = false;
          this.message =
            'Ocurrio un error al guardar la imagen, verifica que la imagen no pese mas de 10 Mb.';
          this.dialogError = true;
        });
    },

    // Post Product Range
    addProductRange() {
      if (this.varBoolean) {
        axios
          .post('/api/v1/product-ranges-massive', {
            products: this.variaciones,
          })
          .then(response => {
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
        for (const property in this.productRange) {
          if (this.productRange[property] != null && this.productRange[property] != '') {
            data.[property] = this.productRange[property];
          }
        }
        if (this.imageResponse != null && this.imageResponse.length != 0) {
         data.images = this.imageResponse;
        }
        if (this.description != null && this.description.length != 0) {
         data.description = this.description;
        }
        if (this.colors != null && this.colors.length != 0) {
         data.colors = this.colors;
        }
        if (this.inputs != null && this.inputs.length != 0) {
         data.ranges = this.inputs;
        }

        axios
          .post('/api/v1/product-ranges', data)
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

    // Get Categories
    getCategories() {
      axios
        .get('/api/v1/categories')
        .then(response => {
          this.loading = false;
          this.categories = response.data.data;
        })
        .catch(error => {});
    },

    // Get Catalogues
    getCatalogues() {
      axios
        .get('/api/v1/catalogues')
        .then(response => {
          this.loading = false;
          this.catalogues = response.data.data;
        })
        .catch(error => {});
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

    // Add New Component Range
    add() {
      this.inputs.push({
        min: '',
        max: '',
        price: '',
      });
    },

    // Delete Component Range
    deleteRow(index) {
      this.inputs.splice(index, 1);
    },

    // Add New Component Variation
    addVariation() {
      if (
        this.productRange.stock != '' &&
        this.productRange.brand != '' &&
        this.productRange.category != '' &&
        this.productRange.catalogue != '' &&
        this.description != '' &&
        this.inputs != ''
      ) {
        this.variaciones.push({
          model: this.productRange.model + this.cont,
          stock: this.productRange.stock,
          brand: this.productRange.brand,
          category_id: this.productRange.category,
          catalogue_id: this.productRange.catalogue,
          images: [],
          images_upload: [],
          description: this.description,
          colors: [],
          ranges: this.inputs,
        });
      } else {
        alert('Tienes que llenar los datos Generales Primero');
      }
      this.cont++;
    },

    // Delete Component Variation
    deleteVariation(index) {
      this.variaciones.splice(index, 1);
    },

    // Preview Images Product
    previewImages() {
      if (this.files.length == 0) {
      } else {
        this.files.forEach(element => {
          this.images.push({
            src: URL.createObjectURL(element),
            checkbox: false,
          });
        });
      }
    },

    // Delete Images Product
    clear() {
      this.files = [];
      this.images = [];
    },

    //Delete Chips Description
    remove(item) {
      this.description.splice(this.description.indexOf(item), 1);
      this.description = [...this.description];
    },

    // Add Color
    addPColor() {
      this.colors.push(this.showColor);
    },

    // Delete Color
    deleteColor(index) {
      this.colors.splice(index, 1);
    },

    // Delete Color M
    addColorMultiple(id) {
      this.variaciones[id].colors.push(this.showColor);
    },

    // Delete Color M
    deleteColorMultiple(id, index) {
      this.variaciones[id].colors.splice(index, 1);
    },

    // Return List
    returnList() {
      this.$router.replace({ name: 'listProduct' });
    },

    valueInitial() {},

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
            this.dialogSave = false;
            this.message =
              'Ocurrio un error al guardar los datos generales, verifique que todos los datos necesarioes esten completos y vuelva a intentarlo';
            this.dialogError = true;
          });
      }
    },
  },
  mounted() {
    this.getCatalogues();
    this.getCategories();
    this.getColors();
  },
  computed: {
    // Get Hex Color
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
};
</script>
<style scoped>
.ws {
  width: 10%;
}
.wi {
  width: 5%;
}
.wtf {
  width: 150px;
}
</style>
