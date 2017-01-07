
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('app-header', require('./components/partials/Header.vue'));
Vue.component('app-footer', require('./components/partials/Footer.vue'));
Vue.component('errors', require('./components/partials/Errors.vue'));
Vue.component('latest-doodles', require('./components/doodles/Latest.vue'));
Vue.component('doodle-preview', require('./components/doodles/Preview.vue'));

Vue.http.headers.common['X-CSRF-TOKEN'] = document.getElementsByName('csrf-token')[0].getAttribute('content');
Vue.http.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('access_token');

import auth from './components/auth';

const router = new VueRouter({
    routes: require('./routes'),
    mode: 'history',
    linkActiveClass: 'active'
});

new Vue({
    el: '#app',
    router: router,
    data() {
        return {
            user: null
        }
    },
    mounted () {
        auth.checkAuth(this);
    },
    methods: {
        logout: function () {
            auth.logout(this, router);
        }
    }
});
