/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from "vue";

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('pagination-component', require('./components/PaginationComponent.vue').default);
Vue.component('section-index-component', require('./components/Section/IndexComponent.vue').default);
Vue.component('section-one-component', require('./components/Section/OneComponent.vue').default);
Vue.component('section-create-component', require('./components/Section/CreateComponent.vue').default);
Vue.component('section-update-component', require('./components/Section/UpdateComponent.vue').default);

Vue.component('user-index-component', require('./components/User/IndexComponent.vue').default);
Vue.component('user-one-component', require('./components/User/OneComponent.vue').default);
Vue.component('user-create-component', require('./components/User/CreateComponent.vue').default);
Vue.component('user-update-component', require('./components/User/UpdateComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import store from './store';

export const EventBus = new Vue();

const app = new Vue({
    el: '#app',
    store,
});
