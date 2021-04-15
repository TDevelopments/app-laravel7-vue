<template>
  <v-menu v-model="show" absolute offset-y style="max-width: 600px">
    <v-list flat>
      <v-list-item v-for="(item, index) in items" :key="index">
        <v-list-item-title>{{ item.title }}</v-list-item-title>
      </v-list-item>
    </v-list>
  </v-menu>
</template>
<script>
export default {
  props: ['user', 'value'],
  data: () => ({
    quantity: 1,
    loading: false,
    selection: 1,
    model: 0,
    zoomed: false,
    items: [
      { title: 'Click Me' },
      { title: 'Click Me' },
      { title: 'Click Me' },
      { title: 'Click Me 2' },
    ],
  }),
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
