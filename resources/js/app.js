require('./bootstrap');

window.Vue = require('vue').default;

import Vuetify from '../plugins/vuetify';
import router from './router';
import store from './store';
import App from './components/App';
import Axios from 'axios';
import Vue from 'vue';
import VueZoomer from 'vue-zoomer';
import VueExcelEditor from 'vue-excel-editor';

Vue.prototype.$http = Axios;
Vue.prototype.$http.defaults.baseURL = process.env.APP_URL;
const token = localStorage.getItem('token');
if (token) {
  Vue.prototype.$http.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (store.getters['account/isLoggedIn']) {
      next();
      return;
    }
    next('/login');
  } else {
    next(); // make sure to always call next()!
  }
});

Vue.use(VueZoomer);
Vue.use(VueExcelEditor);

const app = new Vue({
  el: '#app',
  components: { App },
  router,
  store,
  vuetify: Vuetify,
});
