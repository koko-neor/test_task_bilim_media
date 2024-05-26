import { createApp } from 'vue';
import App from './components/App.vue';
import router from './router';
import axios from 'axios';

axios.defaults.baseURL = 'http://localhost:8000';
axios.defaults.withCredentials = true;

const token = localStorage.getItem('token');
if (token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

axios.get('/sanctum/csrf-cookie').then(() => {
    createApp(App).use(router).mount('#app');
}).catch(error => {
    console.error('CSRF token fetch failed:', error);
});
