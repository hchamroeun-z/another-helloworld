import "bootstrap/dist/js/bootstrap.bundle.min.js";
import "admin-lte/dist/js/adminlte.min.js";

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import piniaPluginPersistedstate from "pinia-plugin-persistedstate";

import App from './App.vue'
import router from './router'
import { apiVerify } from "./functions/api/auth.js";
import { useUserStore } from "./stores/user.js";
import axios from "axios";

const app = createApp(App)
const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);

app.use(pinia)
app.use(router)
app.mount('#app')

const userStore = useUserStore();
axios.interceptors.request.use((config) => {
    const token = userStore.getSanctumToken();
    if (token && !config.headers.Authorization) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

router.beforeEach(async (to, from) => {
    const { guarded } = to.meta;
    // console.log(guarded);
    if (guarded === undefined) {
        return;
    }
    try {
        const response = await apiVerify();
        const { data } = response;
        userStore.setState(data.user);
        // console.log(userStore.name);
    } catch (error) {
        if (error.response && error.response.status === 401) {
            userStore.reset();
        }
    }
    // console.log(guarded, userStore.isAuthenticated);
    if (guarded && !userStore.isAuthenticated) {
        return { name: 'auth.signin' };
    }
    if (guarded === false && userStore.isAuthenticated) {
        return { name: 'dashboard' };
    }
});