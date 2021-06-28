<template>
  <div class="my-3 mx-5">
    <v-row>
      <h3>Añadir Color</h3>
    </v-row>
    <v-row class="border mb-3">
      <v-col cols="12" sm="6" md="6">
        Nombre Color
        <v-text-field
          v-model="name"
          solo
          required
          placeholder="Example"
          v-on:keyup.enter="addColor"
          class="border"
          flat
          dense
          hide-details
        ></v-text-field>
      </v-col>
      <v-col cols="12" sm="12" md="6" lg="6">
        <h3>Codigo</h3>
        <v-card class="text-center">
          <v-card-text>
            <v-row>
              <v-col cols="12" md="6">
                <v-color-picker hide-inputs v-model="color" class="mx-auto"></v-color-picker>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <v-btn color="success" class="mr-4 mt-3" @click="addColor">
      Guardar
    </v-btn>
  </div>
</template>

<script>
export default {
  data: () => ({
    valid: true,
    name: '',
    code: '',
    type: 'hex',
    hex: '#FF00FF',
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
    addColor() {
      let data = {
        name: this.name,
        code: this.showColor,
      };

      console.log(data);
      axios
        .post('/api/v1/colors', data)
        .then(response => {
          this.$router.replace({ name: 'listColors' });
        })
        .catch(error => {
          console.log(error);
        });
    },
  },
};
</script>
<style scoped>
.border {
  border: 1px solid #d2d6de;
  background-color: white;
}
</style>
