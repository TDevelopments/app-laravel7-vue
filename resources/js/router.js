import Vue from "vue";
import Router from "vue-router";
Vue.use(Router);

// Pages Login
import Login from "./components/login/Login";
import Home from "./components/admin/navigation/index";
import NotFound from "./components/login/NotFound";
import Logout from "./components/login/Logout";
import Register from "./components/login/Register";
import Dashboard from "./components/admin/dashboard/Dashboard";
// Pages View CRUD Catalogues
import ListCatalogue from "./components/admin/catalogues/list";
import AddCatalogue from "./components/admin/catalogues/add";
import EditCatalogue from "./components/admin/catalogues/edit";

// Pages View CRUD Products
import ListProduct from "./components/admin/products/list";
import AddProduct from "./components/admin/products/add";
import EditProduct from "./components/admin/products/edit";

// Pages View CRUD ProductsRange
import AddProductRange from "./components/admin/products/addRange";
import EditProductRange from "./components/admin/products/editRange";

// Pages View CRUD Categories
import ListCategory from "./components/admin/categories/list";
import AddCategory from "./components/admin/categories/add";
import EditCategory from "./components/admin/categories/edit";

// Pages View CRUD Categories
import ListUser from "./components/admin/users/list";
import AddUser from "./components/admin/users/add";
import EditUser from "./components/admin/users/edit";

export default new Router({
    routes: [
        {
            path: "/login",
            name: "login",
            component: Login
        },
        {
            path: "/register",
            name: "register",
            component: Register
        },
        {
            path: "/logout",
            name: "logout",
            component: Logout,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/",
            name: "Home",
            redirect: "/dashboard",
            component: Home,
            meta: {
                requiresAuth: true
            },
            children: [
                // Dashboard
                {
                    path: "/dashboard",
                    name: "dashboard",
                    component: Dashboard
                },
                // Catalogues
                {
                    path: "/catalogues",
                    name: "listCatalogue",
                    component: ListCatalogue
                },
                {
                    path: "/catalogue/add",
                    name: "addCatalogue",
                    component: AddCatalogue
                },
                {
                    path: "/catalogue/:id/edit",
                    name: "editCatalogue",
                    component: EditCatalogue
                },
                // Products
                {
                    path: "/products",
                    name: "listProduct",
                    component: ListProduct
                },
                {
                    path: "/product/add",
                    name: "addProduct",
                    component: AddProduct
                },
                {
                    path: "/product/:id/edit",
                    name: "editProduct",
                    component: EditProduct
                },
                // Products Range
                {
                    path: "/product-range/add",
                    name: "addProductRange",
                    component: AddProductRange
                },
                {
                    path: "/product-range/:id/edit",
                    name: "editProductRange",
                    component: EditProductRange
                },
                // Categories
                {
                    path: "/categories",
                    name: "listCategory",
                    component: ListCategory
                },
                {
                    path: "/category/add",
                    name: "addCategory",
                    component: AddCategory
                },
                {
                    path: "/category/:id/edit",
                    name: "editCategory",
                    component: EditCategory
                },
                // Users
                {
                    path: "/users",
                    name: "listUser",
                    component: ListUser
                },
                {
                    path: "/user/add",
                    name: "addUser",
                    component: AddUser
                },
                {
                    path: "/user/:id/edit",
                    name: "editUser",
                    component: EditUser
                }
            ]
        },
        {
            path: "/404",
            name: "404",
            component: NotFound
        },
        {
            path: "*",
            redirect: "/404"
        }
    ],
    linkActiveClass: "is-active",
    mode: "history"
});
