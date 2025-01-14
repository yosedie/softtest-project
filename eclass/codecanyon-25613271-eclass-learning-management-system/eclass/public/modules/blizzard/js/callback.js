//JS for initializing inertia js
"use Strict";

require('./bootstrap');

import BootstrapVue from 'bootstrap-vue';
import '../css/bootstrap.min.css';
import '../../../node_modules/bootstrap-vue/dist/bootstrap-vue.css';

Vue.use(BootstrapVue);

// If you want to add to window object
 // Translation
 Vue.prototype.translate=require('../../js/VueTranslation/Translation').default.translate;

// require('./bootstrap');
import Vue from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue'

createInertiaApp({
  resolve: name => require(`./Pages/${name}`),
  setup({ el, App, props }) {
    new Vue({
      render: h => h(App, props),
    }).$mount(el)
  },
})