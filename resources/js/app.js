require('./bootstrap');


import Vue from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue'
import { Link } from '@inertiajs/inertia-vue'
Vue.component('Link', Link);

import { Head } from '@inertiajs/inertia-vue'
Vue.component('Head', Head);

import { BootstrapVue } from 'bootstrap-vue'
Vue.use(BootstrapVue)

import VueToast from 'vue-toast-notification';
// Import one of the available themes
//import 'vue-toast-notification/dist/theme-default.css';
import 'vue-toast-notification/dist/theme-sugar.css';


import VueSweetalert2 from 'vue-sweetalert2';
// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';
const options = {
  confirmButtonColor: '#0487BF',
  cancelButtonColor: '#f44336',
};
Vue.use(VueSweetalert2,options);

Vue.use(VueToast,{
  position: 'bottom-right',
  duration:10000,
});


import { InertiaProgress } from '@inertiajs/progress'

InertiaProgress.init()


createInertiaApp({
  resolve: name => require(`./Pages/${name}`),
  setup({ el, App, props, plugin }) {
    Vue.use(plugin)

    new Vue({
      render: h => h(App, props),
    }).$mount(el)
  },
})