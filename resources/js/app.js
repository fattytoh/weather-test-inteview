import Vue from "vue";
import App from "./App.vue";
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap';
import '../css/style.css'

const app = new Vue({
    el: '#app',
    render: h => h(App)
});
