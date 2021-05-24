<template>
  <div class="my-3 mx-5">
    <v-row>
      <h3>Editar Producto</h3>
    </v-row>
    <v-row class="border mb-3">
      <v-col cols="12" md="3" sm="6">
        Modelo (*)
        <v-text-field
          class="border"
          flat
          hide-details
          solo
          dense
          v-model="product.Model"
        ></v-text-field>
      </v-col>
      <v-col cols="12" md="3" sm="6">
        Nombre de Producto (*)
        <v-text-field
          class="border"
          flat
          hide-details
          solo
          dense
          v-model="product.ProductName"
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
          v-model="product.UnitPrice"
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
          v-model="product.SellingPrice"
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
          v-model="cat"
          :items="categories"
          item-text="CategoryName"
          item-value="id"
          menu-props="auto"
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
          v-model="subcat"
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
          v-model="br"
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
          v-model="tp"
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
          v-model="un"
          :items="unit"
          item-text="UnitName"
          item-value="id"
          no-data-text="No hay se encontraron datos"
        ></v-select>
      </v-col>
      <v-col cols="12" md="3" sm="4" class="py-0">
        <v-checkbox v-model="product.ProductAvailable" dense class="mt-5">
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
        <v-checkbox v-model="product.AvailableColors" dense class="mt-5">
          <template v-slot:label>
            <div class="mt-2">
              Colores Disponible
            </div>
          </template>
        </v-checkbox>
      </v-col>
      <v-col cols="12" md="3" sm="4" class="py-0">
        <v-checkbox v-model="product.AvailableSize" dense class="mt-5">
          <template v-slot:label>
            <div class="mt-2">
              Tallas Disponible
            </div>
          </template>
        </v-checkbox>
      </v-col>
      <v-col cols="12" md="3" sm="4" class="py-0">
        <v-checkbox v-model="product.AvailableGender" dense class="mt-5">
          <template v-slot:label>
            <div class="mt-2">
              Genero Disponible
            </div>
          </template>
        </v-checkbox>
      </v-col>
    </v-row>
    <v-row class="border mb-3">
      <v-col cols="12" md="3" v-if="product.AvailableColors">
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
      <v-col cols="12" md="3" v-if="product.AvailableSize">
        <div class="d-flex mb-2">
          Tallas
          <v-spacer></v-spacer>
          <v-icon color="#000" @click="plusSize">mdi-plus</v-icon>
        </div>
        <div v-for="(si, index) in product.Size" :key="index" class="d-flex">
          <v-text-field
            class="border mr-3 mb-1"
            v-model="product.Size[index]"
            flat
            hide-details
            solo
            dense
          ></v-text-field>
          <v-icon color="#000" @click="minusSize(index)">mdi-minus</v-icon>
        </div>
      </v-col>
      <v-col cols="12" md="3" v-if="product.AvailableGender">
        Genero
        <v-select hide-details flat class="border" solo dense></v-select>
      </v-col>
    </v-row>
    <v-row>
      <v-col class="p-0">
        Descripcion del Producto
        <editor
          ref="description"
          :initialValue="product.ProductDescription"
          :options="editorOptions"
          heigth="500px"
          initialEditType="wysiwyg"
          previewStyle="vertical"
          v-if="loading"
        />
      </v-col>
    </v-row>
    <v-row class="my-3">
      <v-spacer></v-spacer>
      <v-btn
        class="mx-1 my-4 border"
        elevation="0"
        color="#0D52D6"
        dark
        small
        @click="updateProduct"
        >Guardar</v-btn
      >
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
    type: 'hex',
    hex: '#FF00FF',
    product: {
      ProductDescription: '',
      ProductName: '',
      UnitPrice: '',
      SellingPrice: '',
      ProductAvailable: false,
      AvailableColors: false,
      AvailableSize: false,
      AvailableGender: false,
      Sale_category_id: [],
      Sale_sub_category_id: [],
      Sale_brand_id: [],
      Sale_product_type_id: [],
      Sale_product_unit_id: [],
      Gender: [],
      Size: [],
      Color: [],
    },
    loading: false,
    categories: [],
    cat: null,
    subCategories: [],
    subcat: null,
    brand: [],
    br: null,
    unit: [],
    un: null,
    typeProduct: [],
    tp: null,
    colors: [],
    size: [],
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
    addPColor() {
      this.colors.push(this.showColor);
    },
    deleteColor(index) {
      this.colors.splice(index, 1);
    },
    getProduct() {
      axios
        .get(`/api/v1/sale-products/${this.$route.params.id}`)
        .then(response => {
          console.log(response);
          this.product = response.data.data;
          this.cat = response.data.data.Category.id;
          this.subcat =
            response.data.data.SubCategory != null ? response.data.data.SubCategory.id : null;
          this.br = response.data.data.Brand.id;
          this.un = response.data.data.SaleProductUnit.id;
          this.tp = response.data.data.SaleProductType.id;
          this.colors = response.data.data.Color != null ? response.data.data.Color : [];
          this.size = response.data.data.Size != null ? response.data.data.Size : [];
          this.loading = true;
          console.log('data', response.data.data);
        })
        .catch(error => {});
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
      this.product.Size.push(0);
    },
    minusSize(index) {
      this.product.Size.splice(index, 1);
    },
    updateProduct() {
      if (this.product.AvailableColors == false) {
        delete this.product.Color;
      } else {
        this.product.Color = this.colors;
      }

      if (this.product.AvailableSize == false) {
        delete this.product.Size;
      }

      if (this.subcat == null || this.subcat == '') {
        delete this.product.sale_sub_category_id;
      } else {
        this.product.sale_sub_category_id = this.subcat;
      }

      if (this.getHtml() == '' || this.getHtml() == null) {
        delete this.product.ProductDescription;
      } else {
        this.product.ProductDescription = this.getHtml();
      }
      if (this.product.ProductName == '' || this.product.ProductName == null) {
        delete this.product.ProductName;
      }
      if (this.product.SellingPrice == '' || this.product.SellingPrice == null) {
        delete this.product.SellingPrice;
      }
      if (this.product.UnitPrice == '' || this.product.UnitPrice == null) {
        delete this.product.UnitPrice;
      }
      if (this.product.Discount == '' || this.product.Discount == null) {
        delete this.product.Discount;
      }
      if (this.product.UnitWeight == '' || this.product.UnitWeight == null) {
        delete this.product.UnitWeight;
      }

      console.log(this.subcat);
      axios
        .put(`/api/v1/sale-products/${this.$route.params.id}`, {
          ...this.product,
          sale_category_id: this.cat,
          sale_brand_id: this.br,
          sale_product_type_id: this.tp,
          sale_product_unit_id: this.un,
        })
        .then(response => {
          console.log(response);
          this.$router.replace({ name: 'listStockProduct' });
        })
        .catch(error => {});
    },
  },
  mounted() {
    this.getProduct();
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
