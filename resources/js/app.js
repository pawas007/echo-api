import './bootstrap';
import {createApp} from 'vue';
import Notifications from '@kyvg/vue3-notification'
import router from "@/router/router";
import App from './app.vue';
import i18n from "@/libs/i18n";
import store from "./store";

const app = createApp(App);
app.use(Notifications).use(router).use(i18n).use(store)
    .mount('#app');
