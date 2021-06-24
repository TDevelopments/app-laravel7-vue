export default function() {
  return {
    request_status: '',
    err: [],
    data: {
      products: [],
      links: {},
      meta: {}
    },
    product: {},
    cart: JSON.parse(localStorage.getItem("cart-sales")) || []
  };
}
