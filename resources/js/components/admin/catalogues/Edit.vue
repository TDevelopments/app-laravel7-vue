v<template>
  <div class="px-3 py-3">
    <v-row class="mx-1">
      <div class="my-2">
        <h3>Editar Catálogo</h3>
      </div>
      <v-spacer></v-spacer>
      <div>
        <v-checkbox v-model="catalogue.is_available" label="Disponible"></v-checkbox>
      </div>
    </v-row>
    <v-card flat elevation="2">
      <v-card-text>
        <v-form ref="form" v-model="valid" lazy-validation>
          <v-row>
            <v-col cols="12">
              <v-row>
                <v-col cols="12" sm="6" md="4" lg="3">
                  Nombre de Catálogo
                  <v-text-field
                    v-model="catalogue.name"
                    required
                    solo
                    placeholder="Example"
                  ></v-text-field>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" sm="6" md="4" lg="3">
                  TIpo de Moneda
                  <v-select
                    v-model="catalogue.coin"
                    :items="coins"
                    menu-props="auto"
                    hide-details
                    prepend-inner-icon="mdi-cash-multiple"
                    solo
                    @change="typeCoin"
                  ></v-select>
                </v-col>
                <v-col cols="12" sm="6" md="4" lg="3">
                  Inversión Minima
                  <v-text-field
                    v-model="catalogue.minimum_investment"
                    required
                    :prefix="iconCoin"
                    solo
                    type="number"
                    ref="minimum_investment"
                    placeholder="0"
                  ></v-text-field>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" sm="6" md="4" lg="3">
                  Monto de Separación
                  <v-text-field
                    v-model="catalogue.quota_price"
                    :prefix="iconCoin"
                    required
                    solo
                    type="number"
                    ref="quota_price"
                    placeholder="0"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="4" lg="3">
                  <v-menu
                    v-model="menu1"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                  >
                    <template v-slot:activator="{ on, attrs }">
                      Fecha Pago (MS)
                      <v-text-field
                        v-model="catalogue.quota_date"
                        label="Quota Date"
                        prepend-inner-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                        solo
                      ></v-text-field>
                    </template>
                    <v-date-picker
                      v-model="catalogue.quota_date"
                      @input="menu1 = false"
                    ></v-date-picker>
                  </v-menu>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" sm="6" md="4" lg="3">
                  % Primer Pago
                  <v-text-field
                    v-model="catalogue.first_payment"
                    type="number"
                    prefix="%"
                    required
                    solo
                    placeholder="0"
                    maxlength="3"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="4" lg="3">
                  <v-menu
                    v-model="menu2"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                  >
                    <template v-slot:activator="{ on, attrs }">
                      Fecha Primer Pago
                      <v-text-field
                        v-model="catalogue.date_first_payment"
                        prepend-inner-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                        solo
                      ></v-text-field>
                    </template>
                    <v-date-picker
                      v-model="catalogue.date_first_payment"
                      @input="menu2 = false"
                    ></v-date-picker>
                  </v-menu>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" sm="6" md="4" lg="3">
                  % Segundo Pago
                  <v-text-field
                    v-model="catalogue.second_payment"
                    prefix="%"
                    required
                    solo
                    placeholder="0"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="4" lg="3">
                  <v-menu
                    v-model="menu3"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                  >
                    <template v-slot:activator="{ on, attrs }">
                      Fecha Segundo Pago
                      <v-text-field
                        v-model="catalogue.date_second_payment"
                        prepend-inner-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                        solo
                      ></v-text-field>
                    </template>
                    <v-date-picker
                      v-model="catalogue.date_second_payment"
                      @input="menu3 = false"
                    ></v-date-picker>
                  </v-menu>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" sm="12" md="12" lg="12">
                  Condiciones de Cátalogo
                  <editor
                    ref="conditions"
                    :initialValue="catalogue.conditions"
                    :options="editorOptions"
                    heigth="500px"
                    initialEditType="wysiwyg"
                    previewStyle="vertical"
                    v-if="loading"
                  />
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" sm="12" md="12" lg="12">
                  Información Adicional de Cátalogo
                  <editor
                    v-if="loading"
                    ref="additional_information"
                    :options="editorOptions"
                    heigth="500px"
                    initialEditType="wysiwyg"
                    previewStyle="vertical"
                    :initialValue="catalogue.additional_information"
                  />
                </v-col>
              </v-row>
            </v-col>
            <v-col>
              <v-file-input
                v-model="imagesCatalogue"
                label="Imagen"
                multiple
                solo
                counter
                dense
                prepend-icon="mdi-camera"
              >
              </v-file-input>
            </v-col>
          </v-row>
        </v-form>
      </v-card-text>
    </v-card>
    <v-col class="ma-2">
      <v-row>
        <h4 class="mt-5">Añadir Lugares de Llegada</h4>
        <v-btn color="black" fab x-small class="mt-4 ml-3" @click="add" dark>
          <v-icon>mdi-plus</v-icon>
        </v-btn>
      </v-row>
    </v-col>
    <v-col>
      <v-window
        v-model="window"
        class="elevation-1 mb-3"
        vertical
        v-for="(input, index) in arrivalsDates"
        :key="index"
      >
        <v-window-item>
          <v-card flat>
            <v-card-text>
              <v-row>
                <v-col cols="12" sm="11" md="11">
                  <v-row>
                    <v-col cols="12" md="6">
                      Ciudad
                      <v-select
                        v-model="input.city"
                        :items="cities"
                        menu-props="auto"
                        hide-details
                        prepend-inner-icon="mdi-map"
                        solo
                        :readonly="input.new"
                      ></v-select>
                    </v-col>
                    <v-col cols="12" md="6">
                      <v-menu
                        v-model="input.calendar"
                        :close-on-content-click="false"
                        :nudge-right="40"
                        transition="scale-transition"
                        offset-y
                        min-width="auto"
                      >
                        <template v-slot:activator="{ on, attrs }">
                          Fechas de Llegada
                          <v-text-field
                            v-model="input.arrival_date"
                            prepend-inner-icon="mdi-calendar"
                            solo
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
                      @click="deleteRow(index, input.id)"
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
    </v-col>
    <v-btn :disabled="!valid" color="#0D52D6" dark class="mr-4" @click="validate">
      Guardar
    </v-btn>
  </div>
</template>

<script>
import 'codemirror/lib/codemirror.css'; // Editor's Dependency Style
import '@toast-ui/editor/dist/toastui-editor.css'; // Editor's Style
import '@toast-ui/editor/dist/toastui-editor-viewer.css';
import { Editor, Viewer } from '@toast-ui/vue-editor';
import moment from 'moment';

export default {
  components: {
    editor: Editor,
    viewer: Viewer,
  },
  data: () => ({
    e1: null,
    arrivalsDates: [],
    images: [],
    w_with: window.innerWidth * 0.3,
    w_height: window.innerHeight * 0.23,
    menu1: false,
    menu2: false,
    menu3: false,
    menu4: false,
    window: null,
    valid: true,
    catalogue: {
      name: '',
      minimum_investment: '',
      quota_price: '',
      quota_date: '',
      first_payment: '',
      date_first_payment: '',
      second_payment: '',
      date_second_payment: '',
      coin: '',
      conditions: '',
      additional_information: '',
      image: [],
    },
    select: null,
    url: null,
    cities: [
      'Amazonas',
      'Ancash',
      'Apurímac',
      'Arequipa',
      'Ayacucho',
      'Cajamarca',
      'Cusco',
      'Huancavelica',
      'Huánuco',
      'Ica',
      'Junín',
      'La Libertad',
      'Lambayeque',
      'Lima',
      'Loreto',
      'Madre de Dios',
      'Moquegua',
      'Pasco',
      'Piura',
      'Puno',
      'San Martín',
      'Tacna',
      'Tumbes',
      'Ucayali',
    ],
    idDelete: [],
    coins: ['soles', 'dolares'],
    iconCoin: '',
    imagesCatalogue: [],
    editorOptions: {
      hideModeSwitch: true,
    },
    loading: false,
  }),
  mounted() {
    this.getCatalogue();
    this.typeCoin();
  },
  computed: {
    productQG: function() {
      // `this` points to the vm instance
      this.product.price_group = this.product.price_unit * this.product.quantity_group;
      return this.product.price_group;
    },
  },
  watch: {
    'catalogue.first_payment': function(val) {
      this.catalogue.second_payment = parseInt(100 - val).toFixed();
    },
    'catalogue.second_payment': function(val) {
      this.catalogue.first_payment = parseInt(100 - val).toFixed();
    },
  },
  methods: {
    scroll() {
      this.$refs.toastuiEditor.invoke('scrollTop', 10);
    },
    moveTop() {
      this.$refs.toastuiEditor.invoke('moveCursorToStart');
    },
    getHtmlAdditional() {
      let html = this.$refs.additional_information.invoke('getMarkdown');
      return html;
    },
    getHtmlConditions() {
      let html = this.$refs.conditions.invoke('getMarkdown');
      return html;
    },
    validate() {
      if (this.imagesCatalogue.length != 0) {
        this.addImages();
      } else {
        this.udpdateCatalogue();
      }
    },
    getCatalogue() {
      axios
        .get(`/api/v1/catalogues/${this.$route.params.id}`)
        .then(response => {
          console.log(response);
          this.catalogue = response.data.data;
          (this.catalogue.quota_date = moment(response.data.data.quota_date).format('YYYY-MM-DD')),
            (this.catalogue.date_first_payment = moment(
              response.data.data.date_first_payment
            ).format('YYYY-MM-DD')),
            (this.catalogue.date_second_payment = moment(
              response.data.data.date_second_payment
            ).format('YYYY-MM-DD')),
            this.catalogue.arrivals.forEach(element => {
              this.arrivalsDates.push({
                id: element.id,
                calendar: false,
                city: element.city,
                new: true,
                arrival_date: moment(element.arrival_date).format('YYYY-MM-DD'),
              });
            });
          console.log('asd', this.catalogue);
          this.loading = true;
        })
        .catch(error => {});
    },
    addImages() {
      const data = new FormData();
      this.imagesCatalogue.forEach((elements, index) => {
        console.log(index);
        console.log(elements);
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
          this.catalogue.image = response.data[0];
          console.log('aqui', response.data[0]);
          this.udpdateCatalogue();
        })
        .catch(error => {
          console.log(error);
          // reject(error);
        });
    },

    addArrivals(id) {
      axios
        .post(
          `/api/v1/catalogues/${id}/arrivals`,
          { items: this.arrivalsDates },
          {
            headers: {
              Accept: 'application/json',
              'Content-Type': 'application/json',
            },
          }
        )
        .then(response => {
          this.$router.replace({ name: 'listCatalogue' });
        })
        .catch(error => {});
    },
    deleteArrivals() {
      axios
        .delete('/api/v1/arrivals', {
          headers: {
            Accept: 'application/json',
          },
          data: {
            items: this.idDelete,
          },
        })
        .then(response => {})
        .catch(error => {});
    },
    add() {
      this.arrivalsDates.push({
        calendar: '',
        city: '',
        arrival_date: '',
        new: false,
      });
    },

    udpdateCatalogue() {
      let data = {
        name: this.catalogue.name,
        minimum_investment: this.catalogue.minimum_investment,
        quota_price: this.catalogue.quota_price,
        quota_date: this.catalogue.quota_date,
        first_payment: this.catalogue.first_payment,
        date_first_payment: this.catalogue.date_first_payment,
        second_payment: this.catalogue.second_payment,
        date_second_payment: this.catalogue.date_second_payment,
        coin: this.catalogue.coin,
        conditions: this.getHtmlConditions(),
        additional_information: this.getHtmlAdditional(),
        image: this.catalogue.image,
      };
      axios
        .put(`/api/v1/catalogues/${this.$route.params.id}`, data)
        .then(response => {
          if (this.idDelete.length != 0) {
            this.deleteArrivals();
            this.addArrivals(response.data.data.id);
          } else {
            this.addArrivals(response.data.data.id);
          }
        })
        .catch(error => {});
    },
    deleteRow(index, id) {
      this.arrivalsDates.splice(index, 1);
      this.idDelete.push(id);
    },
    typeCoin() {
      if (this.catalogue.coin == 'soles') this.iconCoin = 'S/.';
      else this.iconCoin = '$';
    },
  },
};
</script>
