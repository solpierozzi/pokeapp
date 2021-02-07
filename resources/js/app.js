import './bootstrap';

window.Vue = require('vue').default;

Vue.component('example-component', require('./components/Pokemon.vue').default);

const app = new Vue({
    el: '#app',
});