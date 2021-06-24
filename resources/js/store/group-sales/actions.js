import axios from 'axios';

export function getProducts({ commit }, getters) {
  if (!getters.products.length) {
    return new Promise((resolve, reject) => {
      commit('data_request');
      axios({
        url: '/api/v1/products-availables',
        method: 'GET',
      })
        .then((resp) => {
          commit('data_success', resp.data);
          resolve(resp);
        })
        .catch((err) => {
          commit('error_request');
          reject(err);
        });
    });
  }
}

export async function getProduct({ commit, getters }, id) {
  try {
    if (!getters.products.length) {
      await dispatch('getProducts');
    }
    let products = getters.data.products;
    let product = {};
    products.forEach((prod) => {
      if (prod.id == id) {
        product = prod;
      }
    });
    commit('setProduct', product);
  } catch (error) {
    commit('error_request');
  }
}

export function addCart({ commit, getters }, payload) {
  try {
    let cart = getters.cart;
    cart.push(payload.product);
    commit('setCart', cart);
  } catch (error) {
    commit('error_request');
  }
}
