export function setCatalogues(state, val) {
  // console.log("value", val);
  state.catalogues = val;
}
export function setCatalogue(state, val) {
  state.catalogue = val;
}
export function setProduct(state, val) {
  state.product = val;
}
export function setLoad(state, val) {
  state.uploadingData = val;
}
export function setCart(state, val) {
  let json = JSON.stringify(val);
  localStorage.setItem("cart-group-import", json);
  state.cart = val;
}
