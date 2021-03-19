require('./bootstrap');

import Vue from "vue";
import App from "./views/app";
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
Vue.use(Vuetify)

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    components: { App }
});
export default app;
