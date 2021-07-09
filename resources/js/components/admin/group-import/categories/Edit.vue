<template>
  <div v-if="spinnerLoading">
    <Spinner />
  </div>
  <v-col v-else>
    <v-window class="elevation-1" vertical>
      <v-window-item>
        <v-card flat>
          <v-card-text>
            <h3>Edit Catalogue</h3>
            <v-divider></v-divider>
            <v-row>
              <v-col cols="12" sm="6" md="6">
                Catalogue Name
                <v-text-field
                  v-model="categorie.name"
                  solo
                  required
                  v-on:keyup.enter="udpdateCategorie"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-window-item>
    </v-window>
    <v-btn color="success" class="mr-4" @click="udpdateCategorie">
      Guardar
    </v-btn>
    <ModalSave v-model="dialogSave" v-if="dialogSave" />
    <ModalError v-model="dialogError" v-if="dialogError" :body="message" />
  </v-col>
</template>

<script>
import ModalSave from '../component/ModalSave';
import ModalError from '../component/ModalError';
import Spinner from '../component/SpinnerLoading';

export default {
  components: {
    ModalSave,
    ModalError,
    Spinner,
  },
  data: () => ({
    valid: true,
    categorie: {
      name: '',
    },
    dialogSave: false,
    dialogError: false,
    spinnerLoading: true,
    message: '',
  }),

  methods: {
    getCategorie() {
      axios
        .get(`/api/v1/categories/${this.$route.params.id}`, {
          headers: {
            Accept: 'application/json',
          },
        })
        .then(response => {
          this.categorie = response.data.data;
          this.spinnerLoading = false;
        })
        .catch(error => {
          this.dialogSave = false;
          this.message = 'No se pudo obtener los datos.';
          this.dialogError = true;
        });
    },
    udpdateCategorie() {
      this.dialogSave = true;
      axios
        .put(`/api/v1/categories/${this.$route.params.id}`, this.categorie)
        .then(response => {
          this.dialogSave = false;
          this.$router.replace({ name: 'listCategory' });
        })
        .catch(error => {
          this.dialogSave = false;
          this.message =
            'Ocurrio un error al guardar los datos generales, verifique que todos los datos necesarioes esten completos y vuelva a intentarlo';
          this.dialogError = true;
        });
    },
  },
  mounted() {
    this.getCategorie();
  },
};
</script>
