import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue';
import store from './store';
import router from './router';

const buildApp = async () => {
    await store.dispatch("auth/currentUser");
    const app = createApp(App);
    app.use(router);
    app.use(store);
    app.mount("#app");
};

buildApp();
