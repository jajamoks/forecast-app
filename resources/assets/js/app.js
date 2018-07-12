require('./bootstrap');

window.Vue = require('vue');


import Vuex from 'vuex';
import VueRouter from 'vue-router';
import VueGoogleAutocomplete from 'vue-google-autocomplete';
import VueCarousel from 'vue-carousel';
import { routes } from './routes';
import storeData from './store';

Vue.component('navbar', require('./components/Navbar.vue'));
Vue.component('forecast-card', require('./components/ForecastCard.vue'));
Vue.component('destination', require('./components/Destination.vue'));
Vue.component('vue-google-autocomplete', VueGoogleAutocomplete);



// set up router
Vue.use(VueRouter);
const router = new VueRouter({
    mode: 'history',
    routes
});

// Vuex for store states
Vue.use(Vuex);
const store = new Vuex.Store(storeData)

// Carousel to display more than 1 forecast card
Vue.use(VueCarousel);

const app = new Vue({
    el: '#app',
    data: {
        destination: null
    },
    router,
    store
});
