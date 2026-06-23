import axios from 'axios';

const http = axios.create({
    baseURL: '/api',
    withCredentials: true,
    headers: {
        Accept: 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
    },
});

http.defaults.xsrfCookieName = 'XSRF-TOKEN';
http.defaults.xsrfHeaderName = 'X-XSRF-TOKEN';

export default http;
