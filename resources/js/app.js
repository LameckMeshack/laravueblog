import './bootstrap';

import Vue from 'vue';

// window.Vue = require('vue');

Vue.component('mainapp', require('./components /mainapp.vue').default)
const app = new Vue({ 
    el: '#app'
})
