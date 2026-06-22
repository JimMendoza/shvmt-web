import { createApp } from 'vue';
import { createPinia } from 'pinia';
import Aplicacion from '@/Aplicacion.vue';
import router from '@/router';
import configurarPrimeVue from '@/plugins/primevue';
import 'primeicons/primeicons.css';

const aplicacion = createApp(Aplicacion);

aplicacion.use(createPinia());
aplicacion.use(router);
configurarPrimeVue(aplicacion);

aplicacion.mount('#app');
