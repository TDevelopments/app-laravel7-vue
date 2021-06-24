import Vue from "vue";
import Vuex from "vuex";
import account from "./account";
import groupImport from "./group-import";
import groupSales from "./group-sales";
Vue.use(Vuex);

const store = new Vuex.Store({
  modules: {
    account,
    groupImport,
    groupSales
  },
  // enable strict mode (adds overhead!)
  // for dev mode only
  strict: process.env.DEV
});

export default store;
