import Vue from 'vue';
import Auth from './Auth.js';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Login from './components/user/Login.vue';
import Register from './components/user/Register.vue';
import Products from "./components/product/Products";
import AddProduct from "./components/product/AddProduct";
import EditProduct from "./components/product/EditProduct";
import ShowProduct from "./components/product/ShowProduct";

const routes = [
    {
        path: '/login',
        component: Login,
        name: "Login"
    },
    {
        path: '/register',
        component: Register,
        name: "Register"
    },
    {
        path: '/dashboard',
        component: Products,
        name: "Products",
    },
    {
        path: '/product/add',
        component: AddProduct,
        name: "Add Product",
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/product/edit/:id',
        component: EditProduct,
        name: "Edit Product",
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/product/:id',
        component: ShowProduct,
        name: "Show Product",
    }
];

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth) ) {
        if (Auth.check()) {
            next();
            return;
        } else {
            router.push('/login');
        }
    } else {
        next();
    }
});

export default router;
