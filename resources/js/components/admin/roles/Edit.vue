<template>
  <div class="my-3 mx-5">
    <v-row>
      <h3>Editar Rol</h3>
    </v-row>
    <v-row class="border mb-3">
      <v-col cols="12" sm="6" md="6">
        Nombre Rol
        <v-text-field
          v-model="rol.name"
          solo
          required
          placeholder="Example"
          v-on:keyup.enter="updateRol"
          class="border"
          flat
          dense
          hide-details
        ></v-text-field>
      </v-col>
    </v-row>
    <v-btn color="success" class="mr-4 mt-3" @click="updateRol">
      Guardar
    </v-btn>
  </div>
</template>

<script>
export default {
  data: () => ({
    valid: true,
    rol: {},
  }),

  methods: {
    getMethod() {
      axios
        .get(`/api/v1/roles/${this.$route.params.id}`)
        .then(response => {
          this.rol = response.data.data;
        })
        .catch(error => {});
    },
    updateRol() {
      axios
        .put(`/api/v1/roles/${this.$route.params.id}`, this.rol)
        .then(response => {
          this.$router.replace({ name: 'listRoles' });
        })
        .catch(error => {});
    },
  },
  mounted() {
    this.getMethod();
  },
};
</script>
<style scoped>
.border {
  border: 1px solid #d2d6de;
  background-color: white;
}
</style>
