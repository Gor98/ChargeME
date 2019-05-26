/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VeeValidate from 'vee-validate';
import BootstrapVue from 'bootstrap-vue'
import * as VueGoogleMaps from "vue2-google-maps";

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('company-create', require('./components/CompanyCreate.vue').default);

Vue.component('company-index', require('./components/CompanyIndex.vue').default);

Vue.component('company-show', require('./components/CompanyShow.vue').default);

Vue.component('map-station', require('./components/MapStation.vue').default);

Vue.component('add-station', require('./components/AddStation.vue').default);

Vue.component('station-index', require('./components/StationIndex.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.use(VeeValidate);
Vue.use(BootstrapVue)
Vue.use(VueGoogleMaps, {
  load: {
    key: "AIzaSyAgz1UUaFHTDhzr59ACOvexgm3uHLEEHf4",
    libraries: "places"
  }
});
const app = new Vue({
    el: '#app',
});
