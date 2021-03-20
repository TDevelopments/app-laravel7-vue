export default function() {
  return {
    catalogues: [],
    catalogue: {},
    product: {},
    cart: JSON.parse(localStorage.getItem("cart-group-import")) || []
  };
}
