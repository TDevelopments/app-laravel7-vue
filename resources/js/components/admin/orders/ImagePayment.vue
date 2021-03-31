<template>
  <v-dialog v-model="show" width="700">
    <v-zoomer
      ref="zoomer"
      style="width: 700px; height: 700px;"
      :max-scale="10"
      :zooming-elastic="false"
      :zoomed.sync="zoomed"
    >
      <v-hover v-slot="{ hover }">
        <v-img
          contain
          :src="image"
          max-width="700"
          max-height="700"
          class="text-center align-center"
        >
          <v-btn v-if="hover" color="#0D52D6" fab small dark @click="$refs.zoomer.zoomIn()">
            <v-icon>mdi-magnify-plus</v-icon>
          </v-btn>
          <v-btn v-if="hover" color="#0D52D6" fab small dark @click="$refs.zoomer.zoomOut()">
            <v-icon>mdi-magnify-minus</v-icon>
          </v-btn>
        </v-img>
      </v-hover>
    </v-zoomer>
  </v-dialog>
</template>
<script>
export default {
  datadata: () => ({
    zoomed: false,
  }),
  props: ['image', 'value'],
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
