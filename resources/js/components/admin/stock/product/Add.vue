<template>
  <div class="my-3 mx-5">
    <v-row>
      <h3>Añadir Producto</h3>
    </v-row>
    <v-row class="border mb-3">
      <v-col cols="12" md="3" sm="6">
        Modelo (*)
        <v-text-field class="border" flat hide-details solo dense v-model="model"></v-text-field>
      </v-col>
      <v-col cols="12" md="3" sm="6">
        Nombre de Producto (*)
        <v-text-field
          class="border"
          flat
          hide-details
          solo
          dense
          v-model="productName"
        ></v-text-field>
      </v-col>
      <v-col cols="12" md="3" sm="6">
        Precio Unitario
        <v-text-field
          class="border"
          flat
          hide-details
          solo
          dense
          v-model="unitPrice"
        ></v-text-field>
      </v-col>
      <v-col cols="12" md="3" sm="6">
        Precio de Venta
        <v-text-field
          class="border"
          flat
          hide-details
          solo
          dense
          v-model="sellingPrice"
        ></v-text-field>
      </v-col>
      <!-- <v-col cols="12" md="3" sm="6">
        Unidades en Stock
        <v-text-field class="border" flat hide-details solo dense></v-text-field>
      </v-col> -->
      <!-- <v-col cols="12" md="3" sm="6">
        Unidades en Orden
        <v-text-field class="border" flat hide-details solo dense></v-text-field>
      </v-col> -->
      <v-col cols="12" md="3" sm="6">
        Categoria (*)
        <v-select
          hide-details
          flat
          class="border"
          solo
          dense
          v-model="sale_category_id"
          :items="categories"
          item-text="CategoryName"
          item-value="id"
          no-data-text="No hay se encontraron datos"
        ></v-select>
      </v-col>
      <v-col cols="12" md="3" sm="6">
        Sub-Categoria
        <v-select
          hide-details
          flat
          class="border"
          solo
          dense
          v-model="sale_sub_category_id"
          :items="subCategories"
          item-text="SubCategoryName"
          item-value="id"
          no-data-text="No hay se encontraron datos"
        ></v-select>
      </v-col>
      <v-col cols="12" md="3" sm="6">
        Marca (*)
        <v-select
          hide-details
          flat
          class="border"
          solo
          dense
          v-model="sale_brand_id"
          :items="brand"
          item-text="BrandName"
          item-value="id"
          no-data-text="No hay se encontraron datos"
        ></v-select>
      </v-col>
      <v-col cols="12" md="3" sm="6">
        Tipo de Producto (*)
        <v-select
          hide-details
          flat
          class="border"
          solo
          dense
          v-model="sale_product_type_id"
          :items="typeProduct"
          item-text="TypeName"
          item-value="id"
          no-data-text="No hay se encontraron datos"
        ></v-select>
      </v-col>
      <v-col cols="12" md="3" sm="6">
        Unidad (*)
        <v-select
          hide-details
          flat
          class="border"
          solo
          dense
          v-model="sale_product_unit_id"
          :items="unit"
          item-text="UnitName"
          item-value="id"
          no-data-text="No hay se encontraron datos"
        ></v-select>
      </v-col>
      <v-col cols="12" md="3" sm="4" class="py-0">
        <v-checkbox v-model="productAvailable" dense class="mt-5">
          <template v-slot:label>
            <div class="mt-2">
              Producto Disponible
            </div>
          </template>
        </v-checkbox>
      </v-col>
      <!-- <v-col cols="12" md="3" sm="6">
        Estado
        <v-text-field class="border" flat hide-details solo dense></v-text-field>
      </v-col> -->
    </v-row>
    <v-row class="border mb-3">
      <v-col cols="12" md="3" sm="4" class="py-0">
        <v-checkbox v-model="availableColors" dense class="mt-5">
          <template v-slot:label>
            <div class="mt-2">
              Colores Disponible
            </div>
          </template>
        </v-checkbox>
      </v-col>
      <v-col cols="12" md="3" sm="4" class="py-0">
        <v-checkbox v-model="availableSize" dense class="mt-5">
          <template v-slot:label>
            <div class="mt-2">
              Tallas Disponible
            </div>
          </template>
        </v-checkbox>
      </v-col>
      <v-col cols="12" md="3" sm="4" class="py-0">
        <v-checkbox v-model="availableGender" dense class="mt-5">
          <template v-slot:label>
            <div class="mt-2">
              Genero Disponible
            </div>
          </template>
        </v-checkbox>
      </v-col>
    </v-row>
    <v-row class="border mb-3">
      <v-col cols="12" md="3" v-if="availableColors">
        <div>Colores de producto</div>

        <v-col cols="12" class="pb-0 pt-2">
          <v-color-picker hide-inputs v-model="color" class="mx-auto"></v-color-picker>
        </v-col>
        <v-col cols="12" class="pb-2 pt-0">
          <v-btn class="mb-5 my-auto mt-2" @click="addPColor" small>
            Añadir Color
          </v-btn>
          <div>Colores</div>
          <v-row class="pr-3 pa-1">
            <v-col v-for="(item, index) in colors" :key="index" cols="1">
              <v-avatar :color="item" size="15" @click="deleteColor(index)"></v-avatar>
            </v-col>
          </v-row>
        </v-col>
      </v-col>
      <v-col cols="12" md="3" v-if="availableSize">
        <div class="d-flex mb-2">
          Tallas
          <v-spacer></v-spacer>
          <v-icon color="#000" @click="plusSize">mdi-plus</v-icon>
        </div>
        <div v-for="(si, index) in size" :key="index" class="d-flex">
          <v-text-field
            class="border mr-3 mb-1"
            v-model="size[index]"
            flat
            hide-details
            solo
            dense
          ></v-text-field>
          <v-icon color="#000" @click="minusSize(index)">mdi-minus</v-icon>
        </div>
      </v-col>
      <v-col cols="12" md="3" v-if="availableGender">
        Genero
        <v-select hide-details flat class="border" solo dense v-model="gender"></v-select>
      </v-col>
    </v-row>
    <v-row>
      <v-col class="p-0">
        Descripcion del Producto
        <editor
          ref="description"
          :initialValue="description"
          :options="editorOptions"
          heigth="500px"
          initialEditType="wysiwyg"
          previewStyle="vertical"
        />
      </v-col>
    </v-row>
    <v-row class="my-3">
      <v-spacer></v-spacer>
      <v-btn class="mx-1 my-4 border" elevation="0" color="#0D52D6" dark small @click="addProduct">
        Guardar
      </v-btn>
      <v-btn class="mx-1 my-4 border" elevation="0" small>Cancelar</v-btn>
    </v-row>
  </div>
</template>
<script>
import 'codemirror/lib/codemirror.css'; // Editor's Dependency Style
import '@toast-ui/editor/dist/toastui-editor.css'; // Editor's Style
import '@toast-ui/editor/dist/toastui-editor-viewer.css';
import { Editor, Viewer } from '@toast-ui/vue-editor';

export default {
  components: {
    editor: Editor,
    viewer: Viewer,
  },
  data: () => ({
    editorOptions: {
      hideModeSwitch: true,
    },
    description: '',
    model: '',
    productName: '',
    unitPrice: '',
    sellingPrice: '',
    productAvailable: false,
    availableColors: false,
    availableSize: false,
    availableGender: false,
    sale_category_id: null,
    sale_sub_category_id: null,
    sale_brand_id: null,
    sale_product_type_id: null,
    sale_product_unit_id: null,
    gender: [],
    size: [],
    colors: [],
    type: 'hex',
    hex: '#FF00FF',
    categories: [],
    subCategories: [],
    brand: [],
    unit: [],
    typeProduct: [],
  }),
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
  methods: {
    scroll() {
      this.$refs.toastuiEditor.invoke('scrollTop', 10);
    },
    moveTop() {
      this.$refs.toastuiEditor.invoke('moveCursorToStart');
    },
    getHtml() {
      let html = this.$refs.description.invoke('getMarkdown');
      return html;
    },
    addProduct() {
      let data = {
        ProductName: this.productName != null ? this.productName : '',
        ProductDescription: this.getHtml() != null ? this.getHtml() : '',
        Model: this.model, // R
        UnitPrice: this.unitPrice != null ? this.unitPrice : '',
        SellingPrice: this.sellingPrice != null ? this.sellingPrice : '',
        ProductAvailable: this.productAvailable,
        AvailableColors: this.availableColors,
        AvailableSize: this.availableSize,
        AvailableGender: this.availableGender,
        Color: this.colors != null ? this.colors : [], // R
        Size: this.size != null ? this.size : [], // R
        Gender: 'Ninguno',
        sale_category_id: this.sale_category_id, // R
        sale_sub_category_id: this.sale_sub_category_id,
        sale_brand_id: this.sale_brand_id, // R
        sale_product_type_id: this.sale_product_type_id, // R
        sale_product_unit_id: this.sale_product_unit_id, // R
      };
      if (this.sale_sub_category_id == null) {
        delete data.sale_sub_category_id;
      }
      if (this.getHtml() == '') {
        delete data.ProductDescription;
      }
      if (this.productName == '') {
        delete data.ProductName;
      }
      if (this.sellingPrice == '') {
        delete data.SellingPrice;
      }
      if (this.unitPrice == '') {
        delete data.UnitPrice;
      }
      axios
        .post('/api/v1/sale-products', data)
        .then(response => {
          this.$router.push({
            name: 'listStockProduct',
          });
          console.log(response);
        })
        .catch(error => {});
    },
    addPColor() {
      this.colors.push(this.showColor);
    },
    deleteColor(index) {
      this.colors.splice(index, 1);
    },
    getCategories() {
      axios
        .get('/api/v1/sale-categories?list=true')
        .then(response => {
          this.categories = response.data.data;
          console.log(response);
        })
        .catch(error => {});
    },
    getSubCategories() {
      axios
        .get('/api/v1/sale-sub-categories?list=true')
        .then(response => {
          this.subCategories = response.data.data;
          console.log(response);
        })
        .catch(error => {});
    },
    getBrands() {
      axios
        .get('/api/v1/sale-brands?list=true')
        .then(response => {
          this.brand = response.data.data;
          console.log(response);
        })
        .catch(error => {});
    },
    getUnit() {
      axios
        .get('/api/v1/sale-units?list=true')
        .then(response => {
          this.unit = response.data.data;
          console.log(response);
        })
        .catch(error => {});
    },
    getTypeProduct() {
      axios
        .get('/api/v1/sale-product-types?list=true')
        .then(response => {
          this.typeProduct = response.data.data;
          console.log(response);
        })
        .catch(error => {});
    },
    plusSize() {
      this.size.push(0);
    },
    minusSize(index) {
      this.size.splice(index, 1);
    },
  },
  mounted() {
    this.getCategories();
    this.getSubCategories();
    this.getBrands();
    this.getUnit();
    this.getTypeProduct();
  },
};
</script>
<style scoped>
.border {
  border: 1px solid #d2d6de;
  background-color: white;
}
</style>
