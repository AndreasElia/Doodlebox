module.exports = [{
    path: '/',
    redirect: { path: '/home' }
}, {
    path: '/home',
    name: 'home',
    component: require('./components/Home.vue'),
    meta: {
        showLatest: true
    }
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
    path: '/doodles',
    component: require('./components/doodles/Doodles.vue'),
    children: [{
        path: '/',
        name: 'doodles',
        component: require('./components/doodles/Index.vue')
    }, {
        path: 'create',
        name: 'create-doodle',
        component: require('./components/doodles/Create.vue')
    }, {
        path: ':id',
        name: 'show-doodle',
        component: require('./components/doodles/Show.vue')
    }, {
        path: ':id/edit',
        name: 'edit-doodle',
        component: require('./components/doodles/Edit.vue')
    }]
}, {
    path: '*',
    name: '404',
    component: require('./components/errors/404.vue')
}];
