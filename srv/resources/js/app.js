require('./bootstrap');
window.Vue = require('vue');
Vue.component('login-modal', () => import('./components/Task.vue'));
const app= new Vue({
    el: '#app'
});
