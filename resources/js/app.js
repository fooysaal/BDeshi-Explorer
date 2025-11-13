import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import router from './router';
import axios from 'axios';

// Import main component
import App from './App.vue';

// Configure axios defaults
axios.defaults.baseURL = window.location.origin;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Accept'] = 'application/json';

// Create Vue app
const app = createApp(App);
const pinia = createPinia();

app.use(pinia);
app.use(router);

// Make axios available globally
app.config.globalProperties.$axios = axios;

// Initialize auth
import { useAuthStore } from './stores/auth';
const authStore = useAuthStore();
authStore.initAuth();

app.mount('#app');
