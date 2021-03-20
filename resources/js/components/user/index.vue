<template>
  <div data-app>
    <v-row class="mx-5">
      <v-col class="mt-5" cols="3">
        <v-img class="py-auto" contain height="70%" src="/images/user2.svg" />
      </v-col>
      <v-col class="mt-5" cols="9">
        <div class="d-none">{{ setDataUser }}</div>
        <v-card flat>
          <v-card-text>
            <v-form ref="form" lazy-validation>
              <v-row>
                <v-col cols="12">
                  <v-row>
                    <v-col cols="12" sm="6" md="6">
                      Nombres
                      <v-text-field
                        v-model="userDetail.name"
                        :counter="10"
                        solo
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      Apellidos
                      <v-text-field
                        v-model="userDetail.lastname"
                        :counter="10"
                        solo
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      Email
                      <v-text-field
                        v-model="userDetail.email"
                        :counter="10"
                        solo
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      Address
                      <v-text-field
                        v-model="userDetail.address"
                        :counter="10"
                        solo
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      RUC
                      <v-text-field
                        v-model="userDetail.ruc"
                        :counter="10"
                        solo
                        type="number"
                        required
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      DNI
                      <v-text-field
                        v-model="userDetail.dni"
                        :counter="10"
                        solo
                        required
                        type="number"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      Telefono
                      <v-text-field
                        v-model="userDetail.phone"
                        :counter="10"
                        solo
                        required
                        type="number"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      Genero
                      <v-select
                        v-model="userDetail.gender"
                        :items="states"
                        menu-props="auto"
                        solo
                        hide-details
                        prepend-inner-icon="mdi-map"
                      ></v-select>
                    </v-col>
                    <v-col cols="12" sm="6" md="6">
                      Ciudad
                      <input
                        type="text"
                        name="name"
                        id="name"
                        v-model="userDetail.name"
                      />
                      <v-select
                        v-model="userDetail.city"
                        :items="cities"
                        menu-props="auto"
                        solo
                        hide-details
                        prepend-inner-icon="mdi-map"
                      ></v-select>
                    </v-col>
                  </v-row>
                </v-col>
              </v-row>
            </v-form>
          </v-card-text>
        </v-card>
        <v-row class="text-right">
          <v-spacer></v-spacer>
          <v-col>
            <v-btn color="success" class="mt-4" @click="onSubmit" dark>
              Guardar
            </v-btn>
          </v-col>
        </v-row>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
  data: () => ({
    states: ["masculine", "female"],
    cities: ["Arequipa", "Lima"],
    userDetail: {}
  }),
  computed: {
    ...mapGetters("account", ["user"]),
    setDataUser() {
      return (this.userDetail = this.user);
    }
  },
  methods: {
    ...mapActions("account", ["updateUser", "getUser"]),
    onSubmit() {
      this.updateUser(this.userDetail);
    }
  },
  created() {},
  mounted() {}
};
</script>

<style></style>
