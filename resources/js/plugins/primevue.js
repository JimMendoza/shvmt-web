import PrimeVue from 'primevue/config';
import Aura from '@primeuix/themes/aura';
import { definePreset } from '@primeuix/themes';
import ConfirmationService from 'primevue/confirmationservice';
import ToastService from 'primevue/toastservice';

const TemaHuanca = definePreset(Aura, {
    semantic: {
        primary: {
            50: '#fff9e8',
            100: '#f8ebbd',
            200: '#efd98a',
            300: '#e3c552',
            400: '#c9a227',
            500: '#a9831d',
            600: '#876616',
            700: '#6e4f17',
            800: '#593f19',
            900: '#493519',
            950: '#291c0c',
        },
    },
});

export default function configurarPrimeVue(aplicacion) {
    aplicacion.use(PrimeVue, {
        theme: {
            preset: TemaHuanca,
            options: {
                darkModeSelector: '.modo-oscuro',
            },
        },
        ripple: true,
    });
    aplicacion.use(ConfirmationService);
    aplicacion.use(ToastService);
}
