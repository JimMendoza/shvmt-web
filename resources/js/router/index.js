import { createRouter, createWebHistory } from 'vue-router';
import DisenoPublico from '@/layouts/DisenoPublico.vue';
import DisenoAdministrativo from '@/layouts/DisenoAdministrativo.vue';
import DisenoAutenticacion from '@/layouts/DisenoAutenticacion.vue';
import { usarAutenticacionStore } from '@/modules/autenticacion/store/autenticacion.store';

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
        meta: { soloInvitados: true },
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
        meta: { requiereAutenticacion: true },
        children: [
            {
                path: '',
                redirect: '/admin/dashboard',
            },
            {
                path: 'dashboard',
                name: 'panel',
                component: () => import('@/modules/dashboard/paginas/PanelPagina.vue'),
                meta: { permiso: 'dashboard.ver' },
            },
            {
                path: 'cuenta',
                name: 'cuenta',
                component: () => import('@/modules/autenticacion/paginas/CuentaPagina.vue'),
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: rutas,
    scrollBehavior: () => ({ top: 0 }),
});

router.beforeEach(async (destino) => {
    const autenticacion = usarAutenticacionStore();
    const requiereAutenticacion = destino.matched.some((ruta) => ruta.meta.requiereAutenticacion);
    const soloInvitados = destino.matched.some((ruta) => ruta.meta.soloInvitados);

    if ((requiereAutenticacion || soloInvitados) && !autenticacion.cargado) {
        if (autenticacion.tuvoSesion) {
            await autenticacion.cargarUsuario();
        } else {
            autenticacion.cargado = true;
        }
    }

    if (requiereAutenticacion && !autenticacion.estaAutenticado) {
        return { name: 'acceso', query: { redireccion: destino.fullPath } };
    }

    if (soloInvitados && autenticacion.estaAutenticado) {
        return autenticacion.usuario.debe_cambiar_contrasena
            ? { name: 'cuenta' }
            : { name: 'panel' };
    }

    if (
        autenticacion.estaAutenticado
        && autenticacion.usuario.debe_cambiar_contrasena
        && destino.name !== 'cuenta'
    ) {
        return { name: 'cuenta' };
    }

    const permiso = destino.meta.permiso;
    if (permiso && !autenticacion.tienePermiso(permiso)) {
        return { name: 'cuenta' };
    }

    return true;
});

export default router;
