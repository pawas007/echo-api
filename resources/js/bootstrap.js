import _ from 'lodash';
import axios from 'axios';
import 'bootstrap';
import Echo from "laravel-echo"
import Pusher from "pusher-js";

window._ = _;
//  AXIOS Default settings
axios.defaults.withCredentials = true;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Accept'] = 'application/json';
axios.defaults.headers.common['Content-Type'] = 'application/json';
axios.defaults.baseURL = '/api/';
window.axios = axios;
// SET TOKEN TO AXIOS
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}


window.Pusher = Pusher
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'secret',
    wsHost: window.location.hostname,
    wsPort: 6001,
    disableStats: true,
    forceTLS: false,
    cluster: 'mt1'

});
