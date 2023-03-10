/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import Vue from 'vue'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
import VueSimpleAlert from "vue-simple-alert";
import VueTelInput from 'vue-tel-input';
import 'vue-tel-input/dist/vue-tel-input.css';
global.jQuery = require('jquery');
var $ = global.jQuery;
window.$ = $;
Vue.use(VueSimpleAlert, { reverseButtons: true });
Vue.use(VueTelInput);
Vue.component('v-select', vSelect)

//Components import

Vue.component('route-super-index', require('../components/route/super/Index.vue').default);
Vue.component('route-admin-index', require('../components/route/admin/Index.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

Vue.prototype.$alertGlobal = function(objOtitulo='', text='', type='', confirmButtonText='Ok') {
  	if (text!='') {
        this.$fire({
            title: objOtitulo,
            text: text,
            type: type,
            confirmButtonText: confirmButtonText
        })
    } else {
        this.$fire(objOtitulo)
    }
};
