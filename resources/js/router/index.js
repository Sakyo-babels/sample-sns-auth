import { createRouter, createWebHistory } from 'vue-router';
import store from '../store';
import Top from '../pages/Top.vue';
import Login from '../pages/Login.vue';
import Register from '../pages/Register.vue';
import SocialLogin from '../pages/SocialLogin.vue';
import SocialRegister from '../pages/SocialRegister.vue';
import SystemError from '../pages/errors/System.vue';

const routes = [
    {
        path: '/',
        name: 'Top',
        component: Top
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
        beforeEnter(to, from, next) {
            store.getters['auth/check'] ? next('/') : next();
        }
    },
    {
        path: '/register',
        name: 'Register',
        component: Register,
        beforeEnter(to, from, next) {
            store.getters['auth/check'] ? next('/') : next();
        }
    },
    {
        path: '/social-login',
        name: 'SocialLogin',
        component: SocialLogin,
        beforeEnter(to, from, next) {
            store.getters['auth/check'] ? next('/') : next();
        }
    },
    {
        path: '/social-register',
        name: 'SocialRegister',
        component: SocialRegister,
        beforeEnter(to, from, next) {
            store.getters['auth/check'] ? next('/') : next();
        }
    },
    {
        path: '/500',
        component: SystemError
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
