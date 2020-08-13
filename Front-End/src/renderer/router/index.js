import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

import login from "../pages/login";
import dashboard from "../pages/dashboard";
import invoice from "../pages/invoice";
import stock from "../pages/stock";
import products from "../pages/products";
import details from "../pages/details";
import categories from "../pages/categories";
import sales from "../pages/sales";
import sellItems from "../pages/sellItems";
import income from "../pages/income";
import statics from "../pages/statics";
import lend from "../pages/lend";
import lendForm from "../pages/lendForm";
import addProduct from "../pages/addProduct";
import barcode from "../pages/barcode";
import Users from "../pages/Users";
import Dealers from "../pages/dealers";

export default new Router({
  routes: [
    {path: '/',name: 'login-page',component: login},
    {path: '/dashboard', component: dashboard,name: 'dashboard'},
    {path: '/invoice', component: invoice,name:'invoice'},
    {path: '/stock' , component: stock},
    {path: '/products' , component: products},
    {path: '/details' , component: details},
    {path: '/categories' , component: categories},
    {path: '/sales' , component: sales},
    {path: '/sellItems' , component: sellItems},
    {path: '/income' , component: income},
    {path: '/statics' , component: statics},
    {path: '/lend' , component: lend},
    {path: '/lendForm' , component: lendForm,name:'lend_form'},
    {path: '/addProduct',component: addProduct},
    {path: '/barcode',component: barcode},
    {path: '/users',component: Users},
    {path: '/dealers',component: Dealers},
    {
      path: '*',
      redirect: '/'
    }
  ]
})
