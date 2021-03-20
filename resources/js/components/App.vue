<template>
  <div>
    <section class="section">
      <main>
        <router-view></router-view>
      </main>
    </section>
  </div>
</template>

<script>
export default {
  created: function() {
    this.$http.interceptors.response.use(undefined, function(err) {
      return new Promise(function(resolve, reject) {
        if (
          err.request.status === 401 &&
          err.config &&
          !err.config.__isRetryRequest
        ) {
          this.$store.dispatch("account/logout");
        }
        throw err;
      });
    });
  }
};
</script>
<style scoped>
</style>
