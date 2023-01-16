import './bootstrap';
import { createApp, } from 'vue';


import Notifications from '@kyvg/vue3-notification'

const app = createApp({});

import Chat from './components/Chat.vue';
app.component('chat', Chat);



app.use(Notifications).mount('#app');
