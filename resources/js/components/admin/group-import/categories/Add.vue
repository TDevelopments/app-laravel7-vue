<template>
  <v-col>
    <h3>Nueva Categoria</h3>
    <v-window class="elevation-1" vertical>
      <v-window-item>
        <v-card flat>
          <v-card-text>
            <v-row>
              <v-col cols="12" sm="6" md="6">
                Nombre Categoria
                <v-text-field
                  v-model="category.name"
                  solo
                  required
                  placeholder="Example"
                  v-on:keyup.enter="addCategory"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-window-item>
    </v-window>
    <v-btn color="success" class="mr-4 mt-3" @click="addCategory">
      Guardar
    </v-btn>
    <ModalSave v-model="dialogSave" v-if="dialogSave" />
    <ModalError v-model="dialogError" v-if="dialogError" :body="message" />
  </v-col>
</template>

<script>
import ModalSave from '../component/ModalSave';
import ModalError from '../component/ModalError.vue';
export default {
  components: {
    ModalSave,
    ModalError,
  },
  data: () => ({
    valid: true,
    category: {
      name: '',
    },
    dialogSave: false,
    dialogError: false,
    message: '',
  }),
  methods: {
    addCategory() {
      this.dialogSave = true;
      axios
        .post('/api/v1/categories', this.category, {
          headers: {
            Accept: 'application/json',
          },
        })
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
};
</script>
