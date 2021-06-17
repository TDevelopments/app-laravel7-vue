import router from '../../router';
import axios from 'axios';
export function login({ commit }, user) {
  return new Promise((resolve, reject) => {
    commit('auth_request');
    axios({
      url: '/api/v1/login',
      data: user,
      method: 'POST',
    })
      .then(resp => {
        const token = resp.data.access_token;
        const user = resp.data.user;
        localStorage.setItem('token', token);
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        commit('auth_success', { token, user });
        router.go(-1);
        resolve(resp);
      })
      .catch(err => {
        console.log(err.response);
        alert(err.response.data.message);
        commit('auth_error');
        localStorage.removeItem('token');
        reject(err);
      });
  });
}
export function register({ commit }, user) {
  return new Promise((resolve, reject) => {
    commit('auth_request');
    axios({
      url: '/api/v1/signup',
      data: user,
      method: 'POST',
    })
      .then(resp => {
        const token = resp.data.access_token;
        const user = resp.data.user;
        localStorage.setItem('token', token);
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        commit('auth_success', { token, user });
        resolve(resp);
        console.log(resp);
      })
      .catch(err => {
        commit('auth_error', err);
        commit('err_response', err.response.data.errors);
        localStorage.removeItem('token');
        reject(err);
      });
  });
}
export function getUser({ commit }) {
  return new Promise((resolve, reject) => {
    commit('auth_request');
    axios({
      url: '/api/v1/user',
      method: 'GET',
    })
      .then(resp => {
        const user = resp.data.data;
        commit('auth_user', user);
        resolve(resp);
      })
      .catch(err => {
        commit('auth_error', err);
        delete axios.defaults.headers.common['Authorization'];
        localStorage.removeItem('token');
        reject(err);
      });
  });
}
export function logout({ commit }) {
  return new Promise((resolve, reject) => {
    console.log('ejecutando');
    commit('logout');
    axios({
      url: '/api/v1/logout',
      method: 'GET',
    })
      .then(response => {
        commit('logout');
        localStorage.removeItem('token');
        delete axios.defaults.headers.common['Authorization'];
        router.push({ name: 'welcome' });
        resolve();
      })
      .catch(error => {
        commit('logout', error);
        localStorage.removeItem('token');
        reject(error);
      });
  });
}
export async function updateUser({ commit }, user) {
  console.log('datos', user);
  // await axios({
  //   url: "/api/v1/user-update",
  //   method: "PUT",
  //   data: user
  // })
  //   .then(response => {
  //     console.log(response);
  //   })
  //   .catch(err => console.log(err));
}
