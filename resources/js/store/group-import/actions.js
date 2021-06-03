import axios from 'axios';
import Vue from 'vue';
import router from '../../router';

export async function getCatalogues({ commit, getters }) {
  if (!getters.catalogues.length) {
    await axios({
      url: '/api/v1/catalogues-availables',
      method: 'GET',
    })
      .then(response => {
        commit('setCatalogues', response.data.data);
      })
      .catch(error => {
        console.log(error);
      });
  }
}

export async function getCatalogue({ commit, getters, dispatch, state }, id) {
  if (!getters.catalogues.length) {
    await dispatch('getCatalogues');
  }
  let catalogue = {};

  getters.catalogues.forEach((element, indexCatalogue) => {
    if (element.id == id) {
      catalogue = element;

      element.products.forEach((product, index) => {
        Vue.set(
          state.catalogues[indexCatalogue].products[index],
          'quantity',
          product.quantity_group
        );
      });

      element.productRanges.forEach((productRange, index) => {
        let minRange = 1;
        let price = 0;
        let col = [];
        if (productRange.ranges.length != 0) {
          minRange = productRange.ranges[0].min;
          price = productRange.ranges[0].price;
          productRange.ranges.forEach((range, index) => {
            if (range.min < minRange) {
              minRange = range.min;
              price = range.price;
            }
          });
        }
        if (productRange.colors != null && productRange.colors.length != 0) {
          productRange.colors.forEach(color => {
            col.push({
              color: color,
              quantity: 0,
            });
          });
        }
        console.log(productRange.colors);
        Vue.set(state.catalogues[indexCatalogue].productRanges[index], 'meta', col);
        Vue.set(state.catalogues[indexCatalogue].productRanges[index], 'quantity', minRange);
        Vue.set(state.catalogues[indexCatalogue].productRanges[index], 'cont', false);
        Vue.set(state.catalogues[indexCatalogue].productRanges[index], 'min', minRange);
        Vue.set(state.catalogues[indexCatalogue].productRanges[index], 'total', price * minRange);
      });
    }
  });
  console.log(catalogue.products);
  console.log(catalogue.productRanges);
  commit('setCatalogue', catalogue);
}

export async function getProduct({ commit, getters, dispatch }, data) {
  if (!getters.catalogues.length) {
    await dispatch('getCatalogue', data.id);
  }
  console.log('tipo', data.type, data.id, data.sku);
  let product = {};
  getters.catalogues.forEach(element => {
    if (element.id == data.id) {
      if (data.type == 'product') {
        element.products.forEach(productUnit => {
          if (productUnit.sku == data.sku) {
            product = productUnit;
          }
        });
      } else {
        element.productRanges.forEach(productRange => {
          if (productRange == data.sku) {
            product = productRange;
          }
        });
      }
    }
  });
  commit('setProduct', product);
}

export function addCart({ commit, getters }, payload) {
  let cart = getters.cart;
  let entrada = payload.products || [];
  let entrada2 = payload.product_ranges || [];
  console.log('asd', payload);
  if (!cart.length) {
    cart.push({
      id: payload.cat.id,
      name: payload.cat.name,
      minimum_investment: payload.cat.minimum_investment,
      products: entrada,
      product_ranges: entrada2,
    });
    // cart.push(payload);
  } else {
    let access = false;
    cart.forEach((catalogue, index) => {
      // console.log('aqui 2');
      // if (catalogue.id === product.catalogue_id) {
      //   catalogue.products.push(product);
      //   access = true;
      // }
      // // console.log("index", index, products.length, access);

      // if (index === cart.length - 1) {
      //   if (!access) {
      //     cart.push({
      //       id: payload.catalogue.id,
      //       name: payload.catalogue.name,
      //       minimum_investment: payload.catalogue.minimum_investment,
      //       products: [product],
      //     });
      //   }
      // }
      if (catalogue.id === payload.cat.id) {
        access = true;
        catalogue.products = entrada;
        catalogue.product_ranges = entrada2;
      } else {
        // cart.push(payload);
        if (index === cart.length - 1) {
          if (!access) {
            cart.push({
              id: payload.cat.id,
              name: payload.cat.name,
              minimum_investment: payload.cat.minimum_investment,
              products: entrada,
              product_ranges: entrada2,
            });
          }
        }
      }
    });
  }
  console.log('cart', cart);
  // let json = JSON.stringify(cart);
  // localStorage.setItem("cart-group-import", json);
  commit('setCart', cart);
}

export function removeCart({ commit, getters }, data) {
  let cart = [];
  if (data.catalogue && data.product) {
    for (let index = 0; index < getters.cart.length; index++) {
      let catalogue = getters.cart[index];
      if (catalogue.id === data.catalogue) {
        // console.log("catalogo identificado");
        catalogue.products.forEach((product, index, object) => {
          // console.log("recorriendo product");
          if (product.id === data.product) {
            // console.log("producto identificado");
            object.splice(index, 1);
          }
        });
      }
      // console.log("Observando tamaño", catalogue.cart.length);
      if (catalogue.products.length > 0) {
        // console.log("tamaño", catalogue.cart.length);
        cart.push(catalogue);
      }
    }
  }
  // console.log("mi carrito", cart);
  commit('setCart', cart);
  // let json = JSON.stringify(cart);
  // localStorage.setItem("cart-group-import", json);
}

export function generateOrder({ commit, getters, rootGetters }, catalogue) {
  let auth = rootGetters['account/isLoggedIn'];
  if (auth) {
    console.log('HOaskdjnasdjk', catalogue);
    if (catalogue.products) {
      console.log('me estas jodiendo');
      catalogue.products.forEach(product => {
        product.product_id = product.id;
      });
    }
    if (catalogue.product_ranges) {
      catalogue.product_ranges.forEach(product_range => {
        product_range.product_id = product_range.id;
        console.log(product_range.id);
      });
    }
    axios({
      url: '/api/v1/orders',
      method: 'POST',
      data: {
        catalogue_id: catalogue.id,
        products: catalogue.products ? catalogue.products : [],
        product_ranges: catalogue.product_ranges ? catalogue.product_ranges : [],
      },
    })
      .then(resp => {
        let cart = [];
        getters.cart.forEach(cata => {
          if (cata.id !== catalogue.id) {
            cart.push(cata);
          }
          commit('setCart', cart);
        });
      })
      .catch(err => console.log(err));
  } else {
    router.push({ name: 'loginRouter' });
  }
}
