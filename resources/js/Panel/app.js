require('../bootstrap');
import Vue from 'vue/dist/vue'

window.Vue = require('vue');

//Panel Import Begin
import App from './App.vue';
import SideNav from './routes/SideNav.vue';
import Login from './auth/Login.vue';
import { routes } from './routes/routes.js';
//Panel Import End

//Mix Import Begin
import VueSocketIO from 'vue-socket.io';
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
//Mix Import End
Vue.use(VueRouter);
Vue.use(VueAxios, axios);
import Vuex from 'vuex'
Vue.use(Vuex)
import nestableStore from "./components/nestable/NestableStore"
const store = new Vuex.Store(nestableStore)
// Vue.use(new VueSocketIO({
//     debug: true,
//     connection: 'http://localhost:1414'
// }));

Vue.mixin({
    methods: {
        globalHelper: function () {
            alert("Hello world");
        },
    },
});

//PANEL BEGIN
const router = new VueRouter({
    mode: 'history',
    routes: routes
});

const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App),
    store
});

const sideNav = new Vue({
    el: '#sideNav',
    router: router,
    render: h => h(SideNav),
});

const login = new Vue({
    el: '#panelLogin',
    router: router,
    render: h => h(Login),
});
//PANEL END
