module.exports = [{
    path: '/',
    redirect: { path: '/home' }
}, {
    path: '/home',
    name: 'home',
    component: require('./components/Home.vue')
}, {
    path: '/login',
    name: 'login',
    component: require('./components/auth/Login.vue')
}, {
    path: '/register',
    name: 'register',
    component: require('./components/auth/Register.vue')
}, {
    path: '/logout',
    name: 'logout',
    redirect: { path: '/home' }
}, {
    path: '/details',
    name: 'details',
    component: require('./components/users/Details.vue')
}, {
    path: '*',
    name: '404',
    component: require('./components/errors/404.vue')
}];
