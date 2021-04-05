<template>
  <div>
    <v-progress-circular :size="70" :width="7" color="purple" indeterminate></v-progress-circular>
  </div>
</template>
<script>
export default {
  props: ['estado', 'mensaje'],
  data: () => ({
    loading: false,
  }),
  computed: {},
};
</script>
