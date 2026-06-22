import { createRouter, createWebHistory } from 'vue-router';
import DisenoPublico from '@/layouts/DisenoPublico.vue';
import DisenoAdministrativo from '@/layouts/DisenoAdministrativo.vue';
import DisenoAutenticacion from '@/layouts/DisenoAutenticacion.vue';

const rutas = [
    {
        path: '/',
        component: DisenoPublico,
        children: [
            {
                path: '',
                name: 'inicio',
                component: () => import('@/modules/inicio/paginas/InicioPagina.vue'),
            },
        ],
    },
    {
        path: '/admin/login',
        component: DisenoAutenticacion,
        children: [
            {
                path: '',
                name: 'acceso',
                component: () => import('@/modules/autenticacion/paginas/AccesoPagina.vue'),
            },
        ],
    },
    {
        path: '/admin',
        component: DisenoAdministrativo,
        children: [
            {
                path: '',
                redirect: '/admin/dashboard',
            },
            {
                path: 'dashboard',
                name: 'panel',
                component: () => import('@/modules/dashboard/paginas/PanelPagina.vue'),
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: rutas,
    scrollBehavior: () => ({ top: 0 }),
});

export default router;
