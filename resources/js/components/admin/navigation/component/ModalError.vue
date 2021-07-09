<template>
  <v-dialog v-model="show" max-width="290">
    <v-card>
      <v-card-title class="text-h5">
        Ocurrio un error
      </v-card-title>
      <v-card-text>
        {{ body }}
        <br />
        <br />
        Los datos necesarios llevaran el sigueinte símbolo (*).
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="green darken-1" text @click="show = false">
          Aceptar
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script>
export default {
  props: ['value', 'body'],
  computed: {
    show: {
      get() {
        return this.value;
      },
      set(value) {
        this.$emit('input', value);
      },
    },
  },
};
</script>
