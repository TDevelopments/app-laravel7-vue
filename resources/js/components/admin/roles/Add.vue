<template>
  <div class="my-3 mx-5">
    <v-row>
      <h3>Añadir Rol</h3>
    </v-row>
    <v-row class="border mb-3">
      <v-col cols="12" sm="6" md="6">
        Nombre Rol
        <v-text-field
          v-model="name"
          solo
          required
          placeholder="Example"
          v-on:keyup.enter="addRol"
          class="border"
          flat
          dense
          hide-details
        ></v-text-field>
      </v-col>
    </v-row>
    <v-row>
      <v-col class="content">
        <strong>PERMISOS</strong>
        <ul>
          <li v-for="(perm, pindex) in permisions" :key="pindex" @click="permForRol(pindex)">
            {{ perm.name }}
          </li>
        </ul>
      </v-col>
      <v-col class="content ml-5">
        <strong>PERMISOS DEL ROL</strong>
        <ul>
          <li v-for="(permR, pRindex) in rolPermisions" :key="pRindex" @click="rolForPerm(pRindex)">
            {{ permR.name }}
          </li>
        </ul>
      </v-col>
      <div class="text-center">
        <v-btn
          color="blue"
          dark
          class="ml-4 mb-5"
          @click="rolPermisions.length == 0 ? allPermisison() : deleteAllPermisions()"
        >
          <v-icon>
            {{
              rolPermisions.length != 0
                ? 'mdi-arrow-collapse-horizontal'
                : 'mdi-arrow-split-horizontal'
            }}
          </v-icon>
          &nbsp;Todos
        </v-btn>
        <br />
        <v-btn color="success" class="ml-4" @click="addRol">
          Guardar
        </v-btn>
      </div>
    </v-row>
  </div>
</template>

<script>
export default {
  data: () => ({
    valid: true,
    name: '',
    permisions: [],
    rolPermisions: [],
  }),
  methods: {
    addRol() {
      let data = {
        name: this.name,
      };
      axios
        .post('/api/v1/roles', data)
        .then(response => {
          this.addPermisions(response.data.data.id);
        })
        .catch(error => {
          console.log(error);
        });
    },
    addPermisions(id) {
      let data = [];
      this.rolPermisions.forEach(e => {
        data.push(e.name);
      });
      axios
        .post(`/api/v1/roles/${id}/permissions`, { permissions: data })
        .then(response => {
          this.$router.replace({ name: 'listRoles' });
        })
        .catch(error => {
          console.log(error);
        });
    },
    getPermisions() {
      let data = {
        name: this.name,
      };
      axios
        .get('/api/v1/permissions')
        .then(response => {
          this.permisions = response.data.data;
          console.log(this.permisions);
        })
        .catch(error => {
          console.log(error);
        });
    },
    permForRol(index) {
      this.rolPermisions.push(this.permisions[index]);
      this.permisions.splice(index, 1);
      this.permisions.sort();
      this.rolPermisions.sort();
    },
    rolForPerm(index) {
      this.permisions.push(this.rolPermisions[index]);
      this.rolPermisions.splice(index, 1);
      this.permisions.sort();
      this.rolPermisions.sort();
    },
    allPermisison() {
      this.permisions.forEach(e => {
        this.rolPermisions.push(e);
      });
      this.permisions = [];
    },
    deleteAllPermisions() {
      this.getPermisions();
      this.rolPermisions = [];
    },
  },
  mounted() {
    this.getPermisions();
  },
};
</script>
<style scoped>
.border {
  border: 1px solid #d2d6de;
  background-color: white;
}
.content {
  border-radius: 10px;
  border: #d2d6de solid 1px;
  background-color: white;
}
li {
  cursor: pointer;
}
li:hover {
  background-color: #d2d6de;
  font-weight: 700;
}
</style>
