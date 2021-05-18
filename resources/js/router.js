import Vue from 'vue';
import Router from 'vue-router';
Vue.use(Router);

// Pages Login
import Login from './components/login/Login';
import Home from './components/admin/navigation';
import NotFound from './components/login/NotFound';
import Logout from './components/login/Logout';
import Register from './components/login/Register';
import Dashboard from './components/admin/group-import/dashboard/Dashboard';
import PDFCatalogue from './components/pdf/cataloguePDF';

// Pages View CRUD Catalogues
import ListCatalogue from './components/admin/group-import/catalogues/List';
import AddCatalogue from './components/admin/group-import/catalogues/Add';
import EditCatalogue from './components/admin/group-import/catalogues/Edit';

// Pages View CRUD Products
import ListProduct from './components/admin/group-import/products/List';
import AddProduct from './components/admin/group-import/products/Add';
import EditProduct from './components/admin/group-import/products/Edit';

// Pages View CRUD ProductsRange
import AddProductRange from './components/admin/group-import/products/AddRange';
import EditProductRange from './components/admin/group-import/products/EditRange';

// Pages View CRUD Categories
import ListCategory from './components/admin/group-import/categories/List';
import AddCategory from './components/admin/group-import/categories/Add';
import EditCategory from './components/admin/group-import/categories/Edit';

// Pages View CRUD Categories
import ListUser from './components/admin/group-import/users/List';
import AddUser from './components/admin/group-import/users/Add';
import EditUser from './components/admin/group-import/users/Edit';

// Pages View CRUD Measures
import ListMeasure from './components/admin/group-import/measure/List';
import AddMeasure from './components/admin/group-import/measure/Add';
import EditMeasure from './components/admin/group-import/measure/Edit';

// Pages View CRUD Concept Payment
import ListConcept from './components/admin/group-import/concept/List';
import AddConcept from './components/admin/group-import/concept/Add';
import EditConcept from './components/admin/group-import/concept/Edit';

// Pages View CRUD State Order
import ListState from './components/admin/group-import/state/List';
import AddState from './components/admin/group-import/state/Add';
import EditState from './components/admin/group-import/state/Edit';

// Pages View CRUD State Send
import ListStateSend from './components/admin/group-import/stateSend/List';
import AddStateSend from './components/admin/group-import/stateSend/Add';
import EditStateSend from './components/admin/group-import/stateSend/Edit';

// Pages View CRUD Banks
import ListBank from './components/admin/group-import/bank/List';
import AddBank from './components/admin/group-import/bank/Add';
import EditBank from './components/admin/group-import/bank/Edit';

// Pages View CRUD Advisers
import ListAdviser from './components/admin/group-import/adviser/List';
import AddAdviser from './components/admin/group-import/adviser/Add';
import EditAdviser from './components/admin/group-import/adviser/Edit';

// Pages View Orders
import ListOrder from './components/admin/group-import/orders/List';
import AddOrder from './components/admin/group-import/orders/Add';
import EditOrder from './components/admin/group-import/orders/Edit';
import FilterOrder from './components/admin/group-import/orders/Filter';
import PrintOrder from './components/admin/group-import/orders/printOrder';

// Pages Stock Product
import ListStockProduct from './components/admin/stock/product/List';
import AddStockProduct from './components/admin/stock/product/Add';
import EditStockProduct from './components/admin/stock/product/Edit';

// Pages Stock Location
import ListStockLocation from './components/admin/stock/location/List';
import AddStockLocation from './components/admin/stock/location/Add';
import EditStockLocation from './components/admin/stock/location/Edit';

// Pages Stock Customer
import ListStockCustomer from './components/admin/stock/customer/List';
import AddStockCustomer from './components/admin/stock/customer/Add';
import EditStockCustomer from './components/admin/stock/customer/Edit';

// Pages Stock Brand
import ListStockBrand from './components/admin/stock/brand/List';
import AddStockBrand from './components/admin/stock/brand/Add';
import EditStockBrand from './components/admin/stock/brand/Edit';

// Pages Stock Categories
import ListStockCategorie from './components/admin/stock/categorie/List';
import AddStockCategorie from './components/admin/stock/categorie/Add';
import EditStockCategorie from './components/admin/stock/categorie/Edit';

// Pages Stock Categories
import ListStockSubCategorie from './components/admin/stock/subCategorie/List';
import AddStockSubCategorie from './components/admin/stock/subCategorie/Add';
import EditStockSubCategorie from './components/admin/stock/subCategorie/Edit';

// Pages Stock Categories
import ListStockProductType from './components/admin/stock/productType/List';
import AddStockProductType from './components/admin/stock/productType/Add';
import EditStockProductType from './components/admin/stock/productType/Edit';

// Pages Stock Unit
import ListStockUnit from './components/admin/stock/unit/List';
import AddStockUnit from './components/admin/stock/unit/Add';
import EditStockUnit from './components/admin/stock/unit/Edit';

// Pages Stock Status
import ListStockStatus from './components/admin/stock/status/List';
import AddStockStatus from './components/admin/stock/status/Add';
import EditStockStatus from './components/admin/stock/status/Edit';

// Pages Stock StockRecord
import ListStockStockRecord from './components/admin/stock/stockRecord/List';
import AddStockStockRecord from './components/admin/stock/stockRecord/Add';
import EditStockStockRecord from './components/admin/stock/stockRecord/Edit';

// Pages Stock Delivery
import ListStockDelivery from './components/admin/stock/delivery/List';
import AddStockDelivery from './components/admin/stock/delivery/Add';
import EditStockDelivery from './components/admin/stock/delivery/Edit';

// Pages Product For Catalogue
import ProductCatalogue from './components/admin/group-import/catalogues/ProductForCatalogue';

// Pages User
import Welcome from './components/Welcome';
import GroupImport from './components/group-imports';
import HomeGroupImport from './components/group-imports/ListCatalogues';
import ListProductCatalogue from './components/group-imports/ListProduct';
import ProductDetail from './components/group-imports/ProductDetail';

// Page Cart
import CartGroupImport from './components/group-imports/CartGroupImport';
import UserSetting from './components/user';

// Order User
import OrderUser from './components/group-imports/ListOrders';

export default new Router({
  routes: [
    {
      path: '/',
      name: 'welcome',
      component: Welcome,
    },
    {
      path: '/importaciones',
      name: 'group-import',
      redirect: '/importaciones/catalogos',
      component: GroupImport,
      children: [
        {
          path: '/importaciones/catalogos',
          name: 'homeGroupImport',
          component: HomeGroupImport,
        },
        {
          path: '/importaciones/catalogos/:id/',
          name: 'listProductforCatalogue',
          component: ListProductCatalogue,
        },
        {
          path: '/importaciones/catalogos/:id/:type/:sku',
          name: 'ProductDetail',
          component: ProductDetail,
        },
        {
          path: '/importaciones/cart',
          name: 'cartGroupImport',
          component: CartGroupImport,
        },
        {
          path: '/user-account',
          name: 'UserSettingIG',
          component: UserSetting,
          meta: {
            requiresAuth: true,
          },
        },
        {
          path: '/order-user',
          name: 'orderUser',
          component: OrderUser,
          meta: {
            requiresAuth: true,
          },
        },
      ],
    },
    {
      path: '/login',
      name: 'loginRouter',
      component: Login,
    },
    {
      path: '/register',
      name: 'register',
      component: Register,
    },
    {
      path: '/logout',
      name: 'logout',
      component: Logout,
      meta: {
        requiresAuth: true,
      },
    },
    {
      // Routes Admin
      path: '/admin',
      name: 'Home',
      redirect: '/admin/dashboard',
      component: Home,
      meta: {
        requiresAuth: true,
      },
      children: [
        // Dashboard
        {
          path: '/admin/dashboard',
          name: 'dashboard',
          component: Dashboard,
        },
        // Catalogues
        {
          path: '/admin/catalogues',
          name: 'listCatalogue',
          component: ListCatalogue,
        },
        {
          path: '/admin/catalogue/add',
          name: 'addCatalogue',
          component: AddCatalogue,
        },
        {
          path: '/admin/catalogue/:id/edit',
          name: 'editCatalogue',
          component: EditCatalogue,
        },
        {
          path: '/admin/catalogue/:id/products',
          name: 'productCatalogue',
          component: ProductCatalogue,
        },
        // Products
        {
          path: '/admin/products',
          name: 'listProduct',
          component: ListProduct,
        },
        {
          path: '/admin/product/add',
          name: 'addProduct',
          component: AddProduct,
        },
        {
          path: '/admin/product/:id/edit',
          name: 'editProduct',
          component: EditProduct,
        },
        // Products Range
        {
          path: '/admin/product-range/add',
          name: 'addProductRange',
          component: AddProductRange,
        },
        {
          path: '/admin/product-range/:id/edit',
          name: 'editProductRange',
          component: EditProductRange,
        },
        // Categories
        {
          path: '/admin/categories',
          name: 'listCategory',
          component: ListCategory,
        },
        {
          path: '/admin/category/add',
          name: 'addCategory',
          component: AddCategory,
        },
        {
          path: '/admin/category/:id/edit',
          name: 'editCategory',
          component: EditCategory,
        },
        // Users
        {
          path: '/admin/users',
          name: 'listUser',
          component: ListUser,
        },
        {
          path: '/admin/user/add',
          name: 'addUser',
          component: AddUser,
        },
        {
          path: '/admin/user/:id/edit',
          name: 'editUser',
          component: EditUser,
        },
        // Measures
        {
          path: '/admin/measures',
          name: 'listMeasure',
          component: ListMeasure,
        },
        {
          path: '/admin/measure/add',
          name: 'addMeasure',
          component: AddMeasure,
        },
        {
          path: '/admin/measure/:id/edit',
          name: 'editMeasure',
          component: EditMeasure,
        },
        // Orders
        {
          path: '/admin/order',
          name: 'listOrder',
          component: ListOrder,
        },
        {
          path: '/admin/order/add',
          name: 'addOrder',
          component: AddOrder,
        },
        {
          path: '/admin/order/:id/edit',
          name: 'editOrder',
          component: EditOrder,
        },
        {
          path: '/admin/orders/filter',
          name: 'filterOrder',
          component: FilterOrder,
        },
        // Concept
        {
          path: '/admin/concept',
          name: 'listConcept',
          component: ListConcept,
        },
        {
          path: '/admin/concept/add',
          name: 'addConcept',
          component: AddConcept,
        },
        {
          path: '/admin/concept/:id/edit',
          name: 'editConcept',
          component: EditConcept,
        },
        // State Order
        {
          path: '/admin/state',
          name: 'listState',
          component: ListState,
        },
        {
          path: '/admin/state/add',
          name: 'addState',
          component: AddState,
        },
        {
          path: '/admin/state/:id/edit',
          name: 'editState',
          component: EditState,
        },
        // State Send
        {
          path: '/admin/state-send',
          name: 'listStateSend',
          component: ListStateSend,
        },
        {
          path: '/admin/state-send/add',
          name: 'addStateSend',
          component: AddStateSend,
        },
        {
          path: '/admin/state-send/:id/edit',
          name: 'editStateSend',
          component: EditStateSend,
        },
        // Bank
        {
          path: '/admin/bank',
          name: 'listBank',
          component: ListBank,
        },
        {
          path: '/admin/bank/add',
          name: 'addBank',
          component: AddBank,
        },
        {
          path: '/admin/bank/:id/edit',
          name: 'editBank',
          component: EditBank,
        },
        // Adviser
        {
          path: '/admin/adviser',
          name: 'listAdviser',
          component: ListAdviser,
        },
        {
          path: '/admin/adviser/add',
          name: 'addAdviser',
          component: AddAdviser,
        },
        {
          path: '/admin/adviser/:id/edit',
          name: 'editAdviser',
          component: EditAdviser,
        },
        // Module Sale
        // -> Product
        {
          path: '/admin/stock/products',
          name: 'listStockProduct',
          component: ListStockProduct,
        },
        {
          path: '/admin/stock/product/add',
          name: 'addStockProduct',
          component: AddStockProduct,
        },
        {
          path: '/admin/stock/product/:id/edit',
          name: 'editStockProduct',
          component: EditStockProduct,
        },
        // -> Brand
        {
          path: '/admin/stock/brands',
          name: 'listStockBrand',
          component: ListStockBrand,
        },
        {
          path: '/admin/stock/brand/add',
          name: 'addStockBrand',
          component: AddStockBrand,
        },
        {
          path: '/admin/stock/brand/:id/edit',
          name: 'editStockBrand',
          component: EditStockBrand,
        },
        // -> Categorie
        {
          path: '/admin/stock/categories',
          name: 'listStockCategorie',
          component: ListStockCategorie,
        },
        {
          path: '/admin/stock/categorie/add',
          name: 'addStockCategorie',
          component: AddStockCategorie,
        },
        {
          path: '/admin/stock/categorie/:id/edit',
          name: 'editStockCategorie',
          component: EditStockCategorie,
        },
        // -> Product Type
        {
          path: '/admin/stock/product-types',
          name: 'listStockProductType',
          component: ListStockProductType,
        },
        {
          path: '/admin/stock/product-type/add',
          name: 'addStockProductType',
          component: AddStockProductType,
        },
        {
          path: '/admin/stock/product-type/:id/edit',
          name: 'editStockProductType',
          component: EditStockProductType,
        },
        // -> Sub-Categorie
        {
          path: '/admin/stock/sub-categories',
          name: 'listStockSubCategorie',
          component: ListStockSubCategorie,
        },
        {
          path: '/admin/stock/sub-categorie/add',
          name: 'addStockSubCategorie',
          component: AddStockSubCategorie,
        },
        {
          path: '/admin/stock/sub-categorie/:id/edit',
          name: 'editStockSubCategorie',
          component: EditStockSubCategorie,
        },
        // -> Units
        {
          path: '/admin/stock/units',
          name: 'listStockUnit',
          component: ListStockUnit,
        },
        {
          path: '/admin/stock/unit/add',
          name: 'addStockUnit',
          component: AddStockUnit,
        },
        {
          path: '/admin/stock/unit/:id/edit',
          name: 'editStockUnit',
          component: EditStockUnit,
        },
        // -> Status
        {
          path: '/admin/stock/statuss',
          name: 'listStockStatus',
          component: ListStockStatus,
        },
        {
          path: '/admin/stock/status/add',
          name: 'addStockStatus',
          component: AddStockStatus,
        },
        {
          path: '/admin/stock/status/:id/edit',
          name: 'editStockStatus',
          component: EditStockStatus,
        },
        // -> Locations
        {
          path: '/admin/stock/locations',
          name: 'listStockLocation',
          component: ListStockLocation,
        },
        {
          path: '/admin/stock/location/add',
          name: 'addStockLocation',
          component: AddStockLocation,
        },
        {
          path: '/admin/stock/location/:id/edit',
          name: 'editStockLocation',
          component: EditStockLocation,
        },
        // -> Customers
        {
          path: '/admin/stock/customers',
          name: 'listStockCustomer',
          component: ListStockCustomer,
        },
        {
          path: '/admin/stock/customer/add',
          name: 'addStockCustomer',
          component: AddStockCustomer,
        },
        {
          path: '/admin/stock/customer/:id/edit',
          name: 'editStockCustomer',
          component: EditStockCustomer,
        },
        // -> Stock
        {
          path: '/admin/stock/stock-records',
          name: 'listStockStockRecord',
          component: ListStockStockRecord,
        },
        {
          path: '/admin/stock/stock-record/add',
          name: 'addStockStockRecord',
          component: AddStockStockRecord,
        },
        {
          path: '/admin/stock/stock-record/:id/edit',
          name: 'editStockStockRecord',
          component: EditStockStockRecord,
        },
        // -> Delivery
        {
          path: '/admin/stock/deliveries',
          name: 'listStockDelivery',
          component: ListStockDelivery,
        },
        {
          path: '/admin/stock/delivery/add',
          name: 'addStockDelivery',
          component: AddStockDelivery,
        },
        {
          path: '/admin/stock/delivery/:id/edit',
          name: 'editStockDelivery',
          component: EditStockDelivery,
        },
      ],
    },
    {
      path: '/print/:id/order',
      name: 'printOrder',
      component: PrintOrder,
    },
    {
      path: '/print/catalogue',
      name: 'PDFCatalogue',
      component: PDFCatalogue,
    },
    {
      path: '/404',
      name: '404',
      component: NotFound,
    },
    {
      path: '*',
      redirect: '/404',
    },
  ],
  linkActiveClass: 'is-active',
  mode: 'history',
});
