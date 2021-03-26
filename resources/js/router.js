import Vue from 'vue';
import Router from 'vue-router';
Vue.use(Router);

// Pages Login
import Login from './components/login/Login';
import Home from './components/admin/navigation';
import NotFound from './components/login/NotFound';
import Logout from './components/login/Logout';
import Register from './components/login/Register';
import Dashboard from './components/admin/dashboard/Dashboard';

// Pages View CRUD Catalogues
import ListCatalogue from './components/admin/catalogues/List';
import AddCatalogue from './components/admin/catalogues/Add';
import EditCatalogue from './components/admin/catalogues/Edit';

// Pages View CRUD Products
import ListProduct from './components/admin/products/List';
import AddProduct from './components/admin/products/Add';
import EditProduct from './components/admin/products/Edit';

// Pages View CRUD ProductsRange
import AddProductRange from './components/admin/products/AddRange';
import EditProductRange from './components/admin/products/EditRange';

// Pages View CRUD Categories
import ListCategory from './components/admin/categories/List';
import AddCategory from './components/admin/categories/Add';
import EditCategory from './components/admin/categories/Edit';

// Pages View CRUD Categories
import ListUser from './components/admin/users/List';
import AddUser from './components/admin/users/Add';
import EditUser from './components/admin/users/Edit';

// Pages View CRUD Measures
import ListMeasure from './components/admin/measure/List';
import AddMeasure from './components/admin/measure/Add';
import EditMeasure from './components/admin/measure/Edit';

// Pages View Orders
import ListOrder from './components/admin/orders/List';
import EditOrder from './components/admin/orders/Edit';

// Pages Product For Catalogue
import ProductCatalogue from './components/admin/catalogues/ProductForCatalogue';

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
          path: '/admin/order/:id/edit',
          name: 'editOrder',
          component: EditOrder,
        },
      ],
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
