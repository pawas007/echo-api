import './bootstrap';
import {createApp} from 'vue';
import Notifications from '@kyvg/vue3-notification'
import router from "@/router/router";
import App from './app.vue';

const app = createApp(App);
app.use(Notifications).use(router)
    .mount('#app');
