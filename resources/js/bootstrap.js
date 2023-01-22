import _ from 'lodash';
import axios from 'axios';
import 'bootstrap';
import Echo from "laravel-echo"
import Pusher from "pusher-js";


axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Accept'] = 'application/json';
axios.defaults.headers.common['Content-Type'] = 'application/json';
axios.defaults.baseURL = '/api/';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

window.axios = axios;
window.Pusher = Pusher
window._ = _;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'secret',
    wsHost: window.location.hostname,
    wsPort: 6001,
    disableStats: true,
    forceTLS: false,
    cluster: 'mt1'

});
