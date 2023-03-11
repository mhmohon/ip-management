import {createRouter, createWebHistory} from 'vue-router';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            name: 'login',
            component: () => import('./pages/Login.vue')
        },
        {
            path: '/home',
            name: 'home',
            component: () => import('./pages/Home.vue')
        },
        {
            path: '/ip-address/add',
            name: 'ip.create',
            component: () => import('./pages/ipaddress/Create.vue')
        },
        {
            path: '/ip-address/edit/:id',
            name: 'ip.edit',
            component: () => import('./pages/ipaddress/Edit.vue')
        },
        {
            path: '/auditlogs',
            name: 'auditlogs',
            component: () => import('./pages/AuditLogs.vue')
        }
    ],
})
router.beforeEach((to, from, next) => {
    if (to.path !== '/' && !isAuthenticated()) {
        return next({path: '/'})
    }
    if (isAuthenticated() && to.name === 'login') {
        next({ name: 'home' });
    }
    return next()
})

// define a fallback route for URLs that are not defined in the routes
router.addRoute({
    path: '/:catchAll(.*)',
    redirect: { name: 'home' },
});

function isAuthenticated() {
    return Boolean(localStorage.getItem('APP_USER_TOKEN'))
}

export default router;
