<template>
  <div>
    <v-row>
      <v-col cols="12" sm="12" lg="12">
        <v-col cols="12">
          <h3>Add New Catalogue</h3>
          <v-card flat elevation="2">
            <v-card-text>
              <v-form ref="form" v-model="valid" lazy-validation>
                <v-row>
                  <v-col cols="12">
                    <v-row>
                      <v-col cols="12" sm="6" md="4" lg="3">
                        Catalogue Name
                        <v-text-field
                          v-model="catalogue.name"
                          required
                          solo
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6" md="4" lg="3">
                        Minimum Investment
                        <v-text-field
                          v-model="catalogue.minimum_investment"
                          required
                          prefix="$"
                          type="number"
                          solo
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6" md="4" lg="3">
                        Quota Price
                        <v-text-field
                          v-model="catalogue.quota_price"
                          type="number"
                          prefix="$"
                          required
                          solo
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6" md="4" lg="3">
                        <v-menu
                          v-model="menu1"
                          :close-on-content-click="false"
                          :nudge-right="40"
                          transition="scale-transition"
                          offset-y
                          min-width="auto"
                        >
                          <template v-slot:activator="{ on, attrs }">
                            Quota Date
                            <v-text-field
                              v-model="catalogue.quota_date"
                              label="Quota Date"
                              prepend-inner-icon="mdi-calendar"
                              readonly
                              v-bind="attrs"
                              v-on="on"
                              solo
                            ></v-text-field>
                          </template>
                          <v-date-picker
                            v-model="catalogue.quota_date"
                            @input="menu1 = false"
                          ></v-date-picker>
                        </v-menu>
                      </v-col>
                      <v-col cols="12" sm="6" md="4" lg="3">
                        First Payment
                        <v-text-field
                          v-model="catalogue.first_payment"
                          type="number"
                          prefix="%"
                          required
                          solo
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6" md="4" lg="3">
                        Second Payment
                        <v-text-field
                          v-model="catalogue.second_payment"
                          prefix="%"
                          required
                          solo
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6" md="4" lg="3">
                        <v-menu
                          v-model="menu2"
                          :close-on-content-click="false"
                          :nudge-right="40"
                          transition="scale-transition"
                          offset-y
                          min-width="auto"
                        >
                          <template v-slot:activator="{ on, attrs }">
                            Date First Payment
                            <v-text-field
                              v-model="catalogue.date_first_payment"
                              prepend-inner-icon="mdi-calendar"
                              readonly
                              v-bind="attrs"
                              v-on="on"
                              solo
                            ></v-text-field>
                          </template>
                          <v-date-picker
                            v-model="catalogue.date_first_payment"
                            @input="menu2 = false"
                          ></v-date-picker>
                        </v-menu>
                      </v-col>
                      <v-col cols="12" sm="6" md="4" lg="3">
                        <v-menu
                          v-model="menu3"
                          :close-on-content-click="false"
                          :nudge-right="40"
                          transition="scale-transition"
                          offset-y
                          min-width="auto"
                        >
                          <template v-slot:activator="{ on, attrs }">
                            Date Second Payment
                            <v-text-field
                              v-model="catalogue.date_second_payment"
                              prepend-inner-icon="mdi-calendar"
                              readonly
                              v-bind="attrs"
                              v-on="on"
                              solo
                            ></v-text-field>
                          </template>
                          <v-date-picker
                            v-model="catalogue.date_second_payment"
                            @input="menu3 = false"
                          ></v-date-picker>
                        </v-menu>
                      </v-col>
                    </v-row>
                  </v-col>
                </v-row>
              </v-form>
            </v-card-text>
          </v-card>
        </v-col>
      </v-col>
    </v-row>
    <v-col class="ma-2">
      <v-row>
        <h4 class="mt-5">Add Arrival Dates</h4>
        <v-btn color="black" fab x-small class="mt-4 ml-3" @click="add" dark>
          <v-icon>mdi-plus</v-icon>
        </v-btn>
      </v-row>
    </v-col>
    <v-col>
      <v-window
        v-model="window"
        class="elevation-1 mb-3"
        vertical
        v-for="(input, index) in inputs"
        :key="index"
      >
        <v-window-item>
          <v-card flat>
            <v-card-text>
              <v-row>
                <v-col cols="12" sm="11" md="11">
                  <v-row>
                    <v-col cols="12" md="6">
                      City
                      <v-select
                        v-model="input.city"
                        :items="states"
                        menu-props="auto"
                        hide-details
                        prepend-inner-icon="mdi-map"
                        solo
                      ></v-select>
                    </v-col>
                    <v-col cols="12" md="6">
                      <v-menu
                        v-model="input.calendar"
                        :close-on-content-click="false"
                        :nudge-right="40"
                        transition="scale-transition"
                        offset-y
                        min-width="auto"
                      >
                        <template v-slot:activator="{ on, attrs }">
                          Date Arrival
                          <v-text-field
                            v-model="input.arrival_date"
                            prepend-inner-icon="mdi-calendar"
                            solo
                            readonly
                            v-bind="attrs"
                            v-on="on"
                          ></v-text-field>
                        </template>
                        <v-date-picker
                          v-model="input.arrival_date"
                          @input="input.calendar = false"
                        ></v-date-picker>
                      </v-menu>
                    </v-col>
                  </v-row>
                </v-col>
                <v-col cols="12" sm="1" md="1" class="">
                  <div class="text-center">
                    <v-btn
                      color="error"
                      fab
                      x-small
                      class="mt-5"
                      @click="deleteRow(index)"
                    >
                      <v-icon>mdi-minus</v-icon>
                    </v-btn>
                  </div>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-window-item>
      </v-window>
    </v-col>
    <v-btn :disabled="!valid" color="success" class="mr-4" @click="validate">
      Validate
    </v-btn>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data: () => ({
    e1: null,
    inputs: [
      {
        calendar: "",
        city: "",
        arrival_date: "",
      },
    ],
    w_with: window.innerWidth * 0.3,
    w_height: window.innerHeight * 0.23,
    files: [],
    menu1: false,
    menu2: false,
    menu3: false,
    menu4: false,
    window: null,
    valid: true,
    catalogue: {
      name: "",
      minimum_investment: null,
      quota_price: null,
      quota_date: new Date().toISOString().substr(0, 10),
      first_payment: null,
      date_first_payment: new Date().toISOString().substr(0, 10),
      second_payment: null,
      date_second_payment: new Date().toISOString().substr(0, 10),
    },
    select: null,
    url: null,
    states: ["Arequipa", "Lima"],
  }),

  methods: {
    validate() {
      alert(JSON.stringify(this.inputs));
      this.addCatalogue();
    },
    addCatalogue() {
      axios
        .post("/api/v1/catalogues", this.catalogue, {
          headers: {
            Authorization: "Bearer " + this.$store.getters.getToken,
            Accept: "application/json",
            "Content-Type": "application/json",
          },
        })
        .then((response) => {
          console.log(response);
          this.addArrivals(response.data.data.id);
        })
        .catch((error) => {
          console.log(error);
          // reject(error);
        });
    },
    addArrivals(id) {
      axios
        .post(
          `/api/v1/catalogues/${id}/arrivals`,
          { items: this.inputs },
          {
            headers: {
              Authorization: "Bearer " + this.$store.getters.getToken,
              Accept: "application/json",
              "Content-Type": "application/json",
            },
          }
        )
        .then((response) => {
          console.log(response);
          this.$router.push({ name: "listCatalogue" });
        })
        .catch((error) => {
          console.log(error);
          // reject(error);
        });
    },
    add() {
      this.inputs.push({
        calendar: "",
        city: "",
        arrival_date: "",
      });
    },
    reset() {
      this.$refs.form.reset();
    },
    resetValidation() {
      this.$refs.form.resetValidation();
    },
    Preview_image() {
      this.url = URL.createObjectURL(this.files[0]);
    },
    deleteRow(index) {
      this.inputs.splice(index, 1);
    },
  },
};
</script>