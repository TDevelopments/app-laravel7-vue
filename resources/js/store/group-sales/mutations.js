export function data_request(state) {
  state.request_status = 'loading';
}

export function data_success(state, data) {
  state.request_status = 'success';
  state.data.products = data.data;
  state.data.links = links;
  state.data.meta = meta;
}

export function error_request(state) {
  state.request_status = 'error';
}

export function err_response(state, data) {
  state.err = data;
}

export function setProduct(state, val) {
  state.product = val;
}

export function setCart(state, val) {
  let json = JSON.stringify(val);
  localStorage.setItem("cart-sales", json);
  state.cart = val;
}
