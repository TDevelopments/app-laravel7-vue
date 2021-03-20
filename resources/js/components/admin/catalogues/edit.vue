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
        v-for="(input, index) in arrivalsDates"
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
                        readonly
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
                      @click="deleteRow(index,input.id)"
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
    <v-btn :disabled="!valid" color="success" class="mr-4" @click="udpdateCatalogue">
      Validate
    </v-btn>
  </div>
</template>

<script>
import moment from 'moment'
export default {
  data: () => ({
    e1: null,
    arrivalsDates: [],
    images: [],
    w_with: window.innerWidth * 0.3,
    w_height: window.innerHeight * 0.23,
    menu1: false,
    menu2: false,
    menu3: false,
    menu4: false,
    window: null,
    valid: true,
    catalogue: {
      name: "",
      minimum_investment: "",
      quota_price: "",
      quota_date: "",
      first_payment: "",
      date_first_payment: "",
      second_payment: "",
      date_second_payment: "",
    },
    select: null,
    url: null,
    states: [
      "Alabama",
      "Alaska",
      "American Samoa",
      "Arizona",
      "Arkansas",
      "California",
      "Colorado",
      "Connecticut",
      "Delaware",
      "District of Columbia",
      "Federated States of Micronesia",
      "Florida",
      "Georgia",
      "Guam",
      "Hawaii",
      "Idaho",
      "Illinois",
      "Indiana",
      "Iowa",
      "Kansas",
      "Kentucky",
      "Louisiana",
      "Maine",
      "Marshall Islands",
      "Maryland",
      "Massachusetts",
      "Michigan",
      "Minnesota",
      "Mississippi",
      "Missouri",
      "Montana",
      "Nebraska",
      "Nevada",
      "New Hampshire",
      "New Jersey",
      "New Mexico",
      "New York",
      "North Carolina",
      "North Dakota",
      "Northern Mariana Islands",
      "Ohio",
      "Oklahoma",
      "Oregon",
      "Palau",
      "Pennsylvania",
      "Puerto Rico",
      "Rhode Island",
      "South Carolina",
      "South Dakota",
      "Tennessee",
      "Texas",
      "Utah",
      "Vermont",
      "Virgin Island",
      "Virginia",
      "Washington",
      "West Virginia",
      "Wisconsin",
      "Wyoming",
    ],
    idDelete: [],
  }),
  mounted() {
    this.getCatalogue();
  },
  methods: {
    validate() {
        console.log(this.arrivalsDates);
    },
    getCatalogue() {
      axios
        .get(`/api/v1/catalogues/${this.$route.params.id}`, {
          headers: {
            Authorization: "Bearer " + this.$store.getters.getToken,
            Accept: "application/json",
            "Content-Type": "application/json",
          },
        })
        .then((response) => {
          console.log(response);
          this.catalogue = response.data.data;
          console.log(this.catalogue);
          this.catalogue.arrivals.forEach((element) => {
            this.arrivalsDates.push({
              id: element.id,
              calendar: false,
              city: element.city,
              arrival_date: moment(element.arrival_date).format('YYYY-MM-DD')
            });
          });
        })
        .catch((error) => {
          console.log(error);
          // reject(error);
        });
    },

    addArrivals(id) {
      axios
        .post(`/api/v1/catalogues/${id}/arrivals`, {items:this.arrivalsDates}, {
          headers: {
            Authorization: "Bearer " + this.$store.getters.getToken,
            Accept: "application/json",
            "Content-Type": "application/json",
          },
        })
        .then((response) => {
          console.log(response);
          this.$router.replace({ name: "listCatalogue" });
        })
        .catch((error) => {
          console.log(error);
          // reject(error);
        });
    },
    deleteArrivals() {
      axios
        .delete("/api/v1/arrivals",{
          headers: {
            Authorization: "Bearer " + this.$store.getters.getToken,
            Accept: "application/json",
          },
          data:{
            items: this.idDelete
          }
        })
        .then((response) => {
          console.log(response);
        })
        .catch((error) => {
          console.log(error);
          // reject(error);
        });
    },
    add() {
      this.arrivalsDates.push({
        calendar: "",
        city: "",
        arrival_date: "",
      });
    },

    udpdateCatalogue() {
      axios
        .put(`/api/v1/catalogues/${this.$route.params.id}`, this.catalogue, {
          headers: {
            Authorization: "Bearer " + this.$store.getters.getToken,
            Accept: "application/json",
            "Content-Type": "application/json",
          },
        })
        .then((response) => {
          console.log(response);
          this.deleteArrivals();
          this.addArrivals(response.data.data.id);
        })
        .catch((error) => {
          console.log(error);
          // reject(error);
        });
    },
    

    reset() {
      this.$refs.form.reset();
    },
    resetValidation() {
      this.$refs.form.resetValidation();
    },
    Preview_image() {
      this.url = URL.createObjectURL(this.images[0]);
    },
    deleteRow(index,id) {
      this.arrivalsDates.splice(index, 1);
      console.log(this.arrivalsDates);
      this.idDelete.push(id);
      console.log(this.idDelete);
    },
  },
};
</script>