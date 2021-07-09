<template>
  <div class="px-3 py-3">
    <v-row class="mx-1">
      <div class="my-2">
        <h3>Nuevo Catálogo</h3>
      </div>
      <v-spacer></v-spacer>
      <div>
        <v-checkbox v-model="is_available" label="Disponible"></v-checkbox>
      </div>
    </v-row>
    <v-card flat elevation="2">
      <v-card-text>
        <v-form ref="form" v-model="valid" lazy-validation>
          <v-row>
            <v-col cols="12">
              <v-row>
                <v-col cols="12" sm="6" md="4" lg="3">
                  Nombre de Catálogo (*)
                  <v-text-field v-model="name" required solo placeholder="Example"></v-text-field>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" sm="6" md="4" lg="3">
                  TIpo de Moneda (*)
                  <v-select
                    v-model="coin"
                    :items="coins"
                    menu-props="auto"
                    hide-details
                    prepend-inner-icon="mdi-cash-multiple"
                    solo
                    @change="typeCoin"
                  ></v-select>
                </v-col>
                <v-col cols="12" sm="6" md="4" lg="3">
                  Inversión Minima (*)
                  <v-text-field
                    v-model="minimum_investment"
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
                  Monto de Separación (*)
                  <v-text-field
                    v-model="quota_price"
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
                    v-model="calendar1"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                  >
                    <template v-slot:activator="{ on, attrs }">
                      Fecha Pago Monto de Separación (*)
                      <v-text-field
                        v-model="quota_date"
                        label="Quota Date"
                        prepend-inner-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                        solo
                      ></v-text-field>
                    </template>
                    <v-date-picker v-model="quota_date" @input="calendar1 = false"></v-date-picker>
                  </v-menu>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" sm="6" md="4" lg="3">
                  % Primer Pago (*)
                  <v-text-field
                    v-model="first_payment"
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
                    v-model="calendar2"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                  >
                    <template v-slot:activator="{ on, attrs }">
                      Fecha Primer Pago (*)
                      <v-text-field
                        v-model="date_first_payment"
                        prepend-inner-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                        solo
                      ></v-text-field>
                    </template>
                    <v-date-picker
                      v-model="date_first_payment"
                      @input="calendar2 = false"
                    ></v-date-picker>
                  </v-menu>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" sm="6" md="4" lg="3">
                  % Segundo Pago (*)
                  <v-text-field
                    v-model="second_payment"
                    prefix="%"
                    required
                    solo
                    placeholder="0"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="4" lg="3">
                  <v-menu
                    v-model="calendar3"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                  >
                    <template v-slot:activator="{ on, attrs }">
                      Fecha Segundo Pago (*)
                      <v-text-field
                        v-model="date_second_payment"
                        prepend-inner-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                        solo
                      ></v-text-field>
                    </template>
                    <v-date-picker
                      v-model="date_second_payment"
                      @input="calendar3 = false"
                    ></v-date-picker>
                  </v-menu>
                </v-col>
              </v-row>
            </v-col>
            <v-col cols="12">
              Condiciones de Cátalogo (*)
              <editor
                ref="conditions"
                :initialValue="conditions"
                :options="editorOptions"
                heigth="500px"
                initialEditType="wysiwyg"
                previewStyle="vertical"
              />
            </v-col>
            <v-col cols="12" sm="12" md="12" lg="12">
              Información Adicional de Cátalogo (*)
              <editor
                ref="additional_information"
                :initialValue="additional_information"
                :options="editorOptions"
                heigth="500px"
                initialEditType="wysiwyg"
                previewStyle="vertical"
              />
            </v-col>
            <v-col cols="12">
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
      <v-window class="elevation-1 mb-3" vertical v-for="(input, index) in inputs" :key="index">
        <v-window-item>
          <v-card flat>
            <v-card-text>
              <v-row>
                <v-col cols="12" sm="11" md="11">
                  <v-row>
                    <v-col cols="12" md="6">
                      Ciudad (*)
                      <v-select
                        v-model="input.city"
                        menu-props="auto"
                        :items="cities"
                        hide-details
                        prepend-inner-icon="mdi-map"
                        solo
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
                          Fechas de Llegada (*)
                          <v-text-field
                            v-model="input.arrival_date"
                            prepend-inner-icon="mdi-calendar"
                            solo
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
                    <v-btn color="error" fab x-small class="mt-5" @click="deleteRow(index)">
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

    <v-btn :disabled="!valid" color="#0D52D6" class="mr-4" @click="validate" dark> Guardar </v-btn>
    <ModalSave v-model="dialogSave" v-if="dialogSave" />
    <ModalError v-model="dialogError" v-if="dialogError" :body="message" />
  </div>
</template>

<script>
import 'codemirror/lib/codemirror.css'; // Editor's Dependency Style
import '@toast-ui/editor/dist/toastui-editor.css'; // Editor's Style
import '@toast-ui/editor/dist/toastui-editor-viewer.css';
import { Editor, Viewer } from '@toast-ui/vue-editor';
import { citiesPeru } from './constants';
import ModalSave from '../component/ModalSave';
import ModalError from '../component/ModalError.vue';

export default {
  components: {
    editor: Editor,
    viewer: Viewer,
    ModalSave,
    ModalError,
  },
  data: () => ({
    editorText: '',
    editorOptions: {
      hideModeSwitch: true,
    },
    imagesCatalogue: [],
    inputs: [
      {
        calendar: false,
        city: 'Lima',
        arrival_date: new Date().toISOString().substr(0, 10),
      },
    ],
    calendar1: false,
    calendar2: false,
    calendar3: false,
    valid: true,
    name: '',
    minimum_investment: null,
    quota_price: null,
    quota_date: new Date().toISOString().substr(0, 10),
    first_payment: null,
    date_first_payment: new Date().toISOString().substr(0, 10),
    second_payment: null,
    date_second_payment: new Date().toISOString().substr(0, 10),
    coin: 'soles',
    is_available: false,
    conditions: '',
    additional_information: '',
    image: '',
    coins: ['soles', 'dolares'],
    select: null,
    url: null,
    cities: citiesPeru,
    iconCoin: 'S/ .',
    dialogSave: false,
    dialogError: false,
    message: '',
  }),
  watch: {
    first_payment: function(val) {
      this.second_payment = parseInt(100 - val).toFixed();
    },
    second_payment: function(val) {
      this.first_payment = parseInt(100 - val).toFixed();
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
      this.dialogSave = true;
      if (this.imagesCatalogue.length != 0) {
        this.addImages();
      } else {
        this.addCatalogue();
      }
    },
    addImages() {
      const data = new FormData();
      this.imagesCatalogue.forEach((elements, index) => {
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
          this.image = response.data[0];
          this.addCatalogue();
        })
        .catch(error => {
          this.dialogSave = false;
          this.message =
            'Ocurrio un error al guardar la imagen, verifica que la imagen no pese mas de 10 Mb.';
          this.dialogError = true;
        });
    },
    addCatalogue() {
      let data = {
        name: this.name,
        minimum_investment: this.minimum_investment,
        quota_price: this.quota_price,
        quota_date: this.quota_date,
        first_payment: this.first_payment,
        date_first_payment: this.date_first_payment,
        second_payment: this.second_payment,
        date_second_payment: this.date_second_payment,
        coin: this.coin,
        is_available: this.is_available,
        conditions: this.getHtmlConditions(),
        additional_information: this.getHtmlAdditional(),
        image: this.image,
      };
      axios
        .post('/api/v1/catalogues', data)
        .then(response => {
          this.addArrivals(response.data.data.id);
        })
        .catch(error => {
          this.dialogSave = false;
          this.message =
            'Ocurrio un error al guardar los datos generales, verifique que todos los datos necesarioes esten completos y vuelva a intentarlo';
          this.dialogError = true;
        });
    },
    addArrivals(id) {
      axios
        .post(`/api/v1/catalogues/${id}/arrivals`, { items: this.inputs })
        .then(response => {
          this.dialogSave = false;
          this.$router.push({ name: 'listCatalogue' });
        })
        .catch(error => {
          this.dialogSave = false;
          this.message = 'Ocurrio un error al guardar los lugares de llegada, vuelva a intentarlo';
          this.dialogError = true;
        });
    },
    add() {
      this.inputs.push({
        calendar: '',
        city: '',
        arrival_date: '',
      });
    },
    deleteRow(index) {
      this.inputs.splice(index, 1);
    },
    typeCoin() {
      if (this.catalogue.coin == 'soles') this.iconCoin = 'S/.';
      else this.iconCoin = '$';
    },
  },
};
</script>
