export const headerOrder = [
  {
    text: 'Nro Orden',
    value: 'id',
    align: 'center',
    sortable: false,
  },
  {
    text: 'Creado por',
    value: 'user.name',
    align: 'center',
    sortable: false,
  },
  {
    text: 'Cliente',
    value: 'customer.FullName',
    align: 'center',
    sortable: false,
  },
  {
    text: 'Catalogo',
    value: 'catalogue.name',
    align: 'center',
    sortable: false,
  },
  {
    text: 'Estado',
    value: 'status',
    align: 'center',
    sortable: false,
  },
  {
    text: 'Total de Orden',
    value: 'total_order',
    align: 'center',
    sortable: false,
  },
  { text: 'Actions', value: 'actions', sortable: false, align: 'center' },
];

export const headerProduct = [
  {
    text: 'Imagen',
    value: 'image',
    align: 'center',
    sortable: false,
  },
  {
    text: 'Model',
    value: 'model',
    align: 'center',
    sortable: false,
  },
  {
    text: 'Cantidad de Producto',
    value: 'quantity',
    align: 'center',
    sortable: false,
    width: 10,
  },
  {
    text: 'Precio del Producto Total',
    value: 'total',
    align: 'center',
    sortable: false,
  },
  {
    text: 'Colores',
    value: 'colors',
    align: 'center',
    sortable: false,
  },
  {
    text: 'Acciones',
    value: 'actions',
    align: 'center',
    sortable: false,
  },
];

export const headerNormalAdd = [
  { text: 'Imagen', value: 'images', align: 'center', sortable: false },
  {
    text: 'Modelo',
    value: 'model',
    align: 'center',
    sortable: false,
  },
  {
    text: 'Marca',
    value: 'brand',
    align: 'center',
    sortable: false,
  },
  {
    text: 'Precio unitario (A)',
    value: 'price_unit',
    align: 'center',
    sortable: false,
  },
  {
    text: 'Cantidad Mínima de Pedido (B)',
    value: 'quantity_group',
    align: 'center',
    sortable: false,
  },
  {
    text: 'Precio Total (AxB)',
    value: 'price_group',
    align: 'center',
    sortable: false,
  },
  {
    text: 'Cantidad de Pedido',
    value: 'quantity_order',
    align: 'center',
    sortable: false,
    width: 135,
  },
];
export const headerRangeAdd = [
  { text: 'Imagen', value: 'images', align: 'center', sortable: false },
  {
    text: 'Modelo',
    value: 'model',
    align: 'center',
    sortable: false,
  },
  {
    text: 'Precio por cantidad de Pedido',
    value: 'ranges',
    align: 'center',
    sortable: false,
  },
  {
    text: 'Cantidad de Pedido',
    value: 'quantity_order',
    align: 'center',
    sortable: false,
  },
  {
    text: 'Colores',
    value: 'colors',
    align: 'center',
    sortable: false,
  },
  {
    text: 'Precio del Pedido',
    value: 'total',
    align: 'center',
    sortable: false,
  },
];
