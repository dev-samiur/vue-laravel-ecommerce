require('./bootstrap');

window.Vue = require('vue');

import App from './components/App.vue';
import VueRouter from 'vue-router';
import Routes from './routes';
import {store} from './store/store';

 Vue.use(VueRouter)

 const router= new VueRouter({
  scrollBehavior (to, from, savedPosition) {
    return { x: 0, y: 0 };
  },
   routes: Routes,
   mode: 'history'
 })

new Vue({
    render: h => h(App),
    store: store,
    router
  }).$mount('#app')
