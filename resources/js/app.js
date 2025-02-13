import './bootstrap';
import { createApp } from 'vue';
import App from './components/App.vue';

const app = createApp({
    components: {
        App
    }
});

app.mount('#app');
