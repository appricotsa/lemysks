require('../bootstrap');
import Vue from 'vue/dist/vue'

window.Vue = require('vue');
//Website Import Begin

import WebsiteLogin from './auth/Login.vue';
import WebsiteIndex from "./Wrapper.vue";
import { websiteRoutes } from './routes/routes';
import { BootstrapVue } from "bootstrap-vue";
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
//Website Import End

//Mix Import Begin
import VueSocketIO from 'vue-socket.io';
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
//Mix Import End
Vue.use(BootstrapVue);
Vue.use(VueRouter);
Vue.use(VueAxios, axios);

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
//Website Begin
const websiteRouter = new VueRouter({
    mode: 'history',
    routes: websiteRoutes
});

const index = new Vue({
    el: '#globalWrapper',
    router: websiteRouter,
    render: h => h(WebsiteIndex),
});

const websiteLogin = new Vue({
    el: '#websiteLogin',
    router: websiteRouter,
    render: h => h(WebsiteLogin),
});
//Website End
