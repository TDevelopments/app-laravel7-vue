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
        <v-btn color="success" class="ml-4" @click="updateRol">
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
    rol: {},
    permisions: [],
    rolPermisions: [],
    revokePermisions: [],
  }),

  methods: {
    getMethod() {
      axios
        .get(`/api/v1/roles/${this.$route.params.id}`)
        .then(response => {
          this.rol = response.data.data;
          this.rolPermisions = response.data.data.permissions;
          this.getPermisions();
          console.log(response.data.data);
        })
        .catch(error => {});
    },
    updateRol() {
      axios
        .put(`/api/v1/roles/${this.$route.params.id}`, this.rol)
        .then(response => {
          this.addPermisions();
        })
        .catch(error => {});
    },
    getPermisions() {
      axios
        .get('/api/v1/permissions')
        .then(response => {
          this.permisions = response.data.data;
          console.log(this.permisions);
          this.compare();
        })
        .catch(error => {
          console.log(error);
        });
    },
    compare() {
      console.log('aqui');
      this.permisions.forEach((e, i) => {
        this.rolPermisions.forEach((p, pi) => {
          if (e.id == p.id) {
            this.permisions.splice(i, 1);
          }
        });
      });
    },
    addPermisions() {
      let data = [];
      this.rolPermisions.forEach(e => {
        data.push(e.name);
      });
      axios
        .post(`/api/v1/roles/${this.$route.params.id}/permissions`, { permissions: data })
        .then(response => {
          this.revokeRolPermisions();
        })
        .catch(error => {
          console.log(error);
        });
    },
    revokeRolPermisions() {
      let data = [];
      this.revokePermisions.forEach(e => {
        data.push(e.name);
      });
      axios
        .put(`/api/v1/roles/${this.$route.params.id}/permissions`, { permissions: data })
        .then(response => {
          this.$router.replace({ name: 'listRoles' });
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
      this.revokePermisions.push(this.rolPermisions[index]);
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
      this.rolPermisions.forEach(e => {
        this.revokePermisions.push(e);
      });
      this.rolPermisions = [];
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
