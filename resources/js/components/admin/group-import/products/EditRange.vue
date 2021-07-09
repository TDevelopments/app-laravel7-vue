<template>
  <div v-if="spinnerDialog">
    <Spinner />
  </div>
  <div v-else class="px-3 py-3">
    <v-row class="mx-3">
      <v-col cols="12">
        <h3>Editar Producto (Rango)</h3>
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
      <v-col cols="12" sm="12" md="6" lg="6">
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

      <v-col cols="12" sm="12" md="6" lg="6">
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
    </v-row>
    <v-col class="ma-2 mx-4">
      <v-row>
        <h4 class="mt-5">Rangos</h4>
      </v-row>
    </v-col>
    <v-window class="elevation-1 mb-3 mx-4" vertical>
      <v-window-item>
        <div class="table-responsive-lg">
          <table class="table">
            <thead class="bg-primary text-white">
              <th scope="col">Rango Minimo</th>
              <th scope="col">Rango Maximo</th>
              <th scope="col">Precio</th>
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
                  prefix="$"
                  type="number"
                ></v-text-field>
              </td>
              <td class="text-right">
                <v-btn color="error" small @click="deleteRow(index, input.id)" icon>
                  <v-icon small>mdi-minus</v-icon>
                </v-btn>
              </td>
            </tr>
          </table>
        </div>
      </v-window-item>
    </v-window>
    <v-row>
      <v-spacer> </v-spacer>
      <v-btn :disabled="!valid" color="red" dark class="mr-3 my-5" @click="returnList">
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
  </div>
</template>
<script>
import axios from "axios";
import ModalSave from '../component/ModalSave';
import ModalError from '../component/ModalError';
import Spinner from '../component/SpinnerLoading'

export default {
  components: {
    ModalSave,
    ModalError,
    Spinner,
  },
  data: () => ({
    productRange: {
      images: []
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
    // Data of Color Picker
    type: "hex",
    hex: "#FF00FF",
    colors: [],
    inputs: [],
    // Items Image Delete
    selectedDelete: [],
    // Items Image Show
    images: [],
    valid: true,
    idDelete: [],
    colorsSelect: [],
    dialogSave: false,
    dialogError: false,
    message: '',
    spinnerDialog: true,
  }),
  mounted() {
    this.getProductRange();
    this.getCategories();
    this.getCatalogues();
    this.getColors();
  },
  methods: {
    validation() {
      this.dialogSave = true;
      if (this.files.length) {
        this.addImages();
      } else {
        this.editProductRange();
      }
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
    getCategories() {
      axios
        .get("/api/v1/categories")
        .then((response) => {
          this.loading = false;
          this.categories = response.data.data;
        })
        .catch((error) => {});
    },

    getCatalogues() {
      axios
        .get("/api/v1/catalogues")
        .then((response) => {
          this.loading = false;
          this.catalogues = response.data.data;
        })
        .catch((error) => {
        });
    },

    getProductRange() {
      axios
        .get(`/api/v1/product-ranges/${this.$route.params.id}`)
        .then((response) => {
          this.productRange = response.data.data;
          this.inputs = response.data.data.ranges;
          this.productRange.catalogue_id = response.data.data.catalogue.id;
          this.productRange.category_id = response.data.data.category.id;
          if (response.data.data.description != null) {
            this.description = response.data.data.description;
          }
          if (response.data.data.colors != null) {
           this.colors = response.data.data.colors;
          }
          if (response.data.data.images != null) {
            response.data.data.images.forEach((element) => {
              this.images.push(element);
            });
          }
          this.spinnerDialog = false;
        })
        .catch((error) => {
          this.dialogSave = false;
          this.message =
            'No se pudo obtner los datos, intentelo de nuevo.';
          this.dialogError = true;
        });
    },

    // Post Images
    addImages() {
      if (this.productRange.images == null) {
        this.productRange.images = [];
      }
      // Declaring Forma Data
      const data = new FormData();
      this.files.forEach((elements, index) => {
        data.append(`image_uploads[${index}]`, elements);
      });

      axios
        .post(`/api/v1/uploads`, data, {
          headers: {
            Accept: "application/json",
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          response.data.forEach((elements) => {
            this.productRange.images.push(elements);
          });
          this.editProductRange();
        })
        .catch((error) => {
          this.dialogSave = false;
          this.message =
            'Ocurrio un error al guardar la imagen, verifica que la imagen no pese mas de 10 Mb.';
          this.dialogError = true;
        });
    },

    editProductRange() {
      let data = {};
      for (const property in this.productRange) {
        if (this.productRange[property] != null) {
          data.[property] = this.productRange[property];
        }
      }

      if (this.description != null) {
        data.description = this.description;
      }

      if (this.colors != null) {
        data.colors = this.colors;
      }

      if (this.productRange.images == null) {
        delete this.productRange.images
      }

      axios
        .put(
          `/api/v1/product-ranges/${this.$route.params.id}`, data)
        .then((response) => {
          if (this.idDelete.length != 0) {
            this.deleteRanges();
            this.addRange(response.data.data.id);
          } else {
            this.addRange(response.data.data.id);
          }
        })
        .catch((error) => {
          this.dialogSave = false;
          this.message =
            'Ocurrio un error al guardar los datos generales, verifique que todos los datos necesarioes esten completos y vuelva a intentarlo';
          this.dialogError = true;
        });
    },
    addRange(id) {
      axios
        .post(`/api/v1/product-ranges/${id}/ranges`,{ items: this.inputs })
        .then((response) => {
          this.dialogSave = false;
          this.$router.replace({ name: "listProduct" });
        })
        .catch((error) => {
          this.dialogSave = false;
          this.message =
            'Ocurrio un error al guardar los rangos, vuelva a intentarlo';
          this.dialogError = true;
        });
    },
    deleteRanges() {
      axios
        .delete(`/api/v1/ranges`, {
          headers: {
            Accept: "application/json",
          },
          data: {
            items: this.idDelete,
          },
        })
        .then((response) => {})
        .catch((error) => {
          this.dialogSave = false;
          this.message =
            'Ocurrio un error al eliminar el rango.';
          this.dialogError = true;
        });
    },
    add() {
      this.inputs.push({
        min: "",
        max: "",
        price: "",
      });
    },
    previewImages() {
      if (this.files.length == 0) {
      } else {
        this.files.forEach((element, index) => {
          this.images.push({
            path: URL.createObjectURL(element),
            new: true,
            id: index,
          });
        });
      }
    },
    deleteRow(index, id) {
      this.inputs.splice(index, 1);
      this.idDelete.push(id);
    },
    clear() {
      this.files = [];
    },
    clearOneImage(index) {
      this.files.splice(index, 1);
    },

    addPColor() {
      this.colors.push(this.showColor);
    },
    deleteColor(index) {
      this.colors.splice(index, 1);
    },
    deleteImage(index, item) {
      this.images.splice(index, 1);
      if (!item.new) {
        this.productRange.images.splice(index, 1);
      }
      if (item.new) {
        this.clearOneImage(item.id);
      }
      this.$refs.fileupload.model = this.files;
    },
    //Delete Chips Description
    remove(item) {
      this.description.splice(this.description.indexOf(item), 1);
      this.description = [...this.description];
    },
    // Return List
    returnList() {
      this.$router.replace({ name: "listProduct" });
    },
  },
  computed: {
    color: {
      get() {
        return this[this.type];
      },
      set(v) {
        this[this.type] = v;
      },
    },
    showColor() {
      if (typeof this.color === "string") return this.color;

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
