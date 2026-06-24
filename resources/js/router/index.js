import { createRouter, createWebHistory } from 'vue-router';
import DisenoPublico from '@/layouts/DisenoPublico.vue';
import DisenoAdministrativo from '@/layouts/DisenoAdministrativo.vue';
import DisenoAutenticacion from '@/layouts/DisenoAutenticacion.vue';
import { recursosAdmin } from '@/modules/admin/config/recursos';
import { usarAutenticacionStore } from '@/modules/autenticacion/store/autenticacion.store';

const rutasCrudAdmin = Object.entries(recursosAdmin).map(([clave, configuracion]) => ({
    path: clave,
    name: `admin.${clave.replaceAll('/', '.')}`,
    component: () => import('@/modules/admin/paginas/CrudAdminPagina.vue'),
    meta: { permiso: configuracion.permiso },
    props: { recurso: clave },
}));

const rutas = [
    {
        path: '/',
        component: DisenoPublico,
        children: [
            {
                path: '',
                name: 'inicio',
                component: () => import('@/modules/publico/paginas/InicioPublicoPagina.vue'),
            },
            {
                path: 'historia',
                name: 'historia',
                component: () => import('@/modules/publico/paginas/HistoriaPagina.vue'),
            },
            {
                path: 'mayordomia',
                name: 'mayordomia',
                component: () => import('@/modules/publico/paginas/MayordomiaPagina.vue'),
            },
            {
                path: 'programa',
                name: 'programa',
                component: () => import('@/modules/publico/paginas/ProgramaPagina.vue'),
            },
            {
                path: 'galeria',
                name: 'galeria',
                component: () => import('@/modules/publico/paginas/GaleriaPagina.vue'),
            },
            {
                path: 'galeria/:slug',
                name: 'album.detalle',
                component: () => import('@/modules/publico/paginas/AlbumDetallePagina.vue'),
            },
            {
                path: 'videos',
                name: 'videos',
                component: () => import('@/modules/publico/paginas/VideosPagina.vue'),
            },
            {
                path: 'videos/:slug',
                name: 'video.detalle',
                component: () => import('@/modules/publico/paginas/VideoDetallePagina.vue'),
            },
            {
                path: 'ubicacion',
                name: 'ubicacion',
                component: () => import('@/modules/publico/paginas/UbicacionPagina.vue'),
            },
            {
                path: 'archivo-historico',
                name: 'archivo.historico',
                component: () => import('@/modules/publico/paginas/ArchivoHistoricoPagina.vue'),
            },
            {
                path: ':ruta(.*)*',
                name: 'no.encontrado',
                component: () => import('@/modules/publico/paginas/NoEncontradoPagina.vue'),
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
            {
                path: 'seguridad',
                name: 'admin.seguridad',
                component: () => import('@/modules/admin/paginas/SeguridadPagina.vue'),
                meta: { permiso: 'seguridad.usuarios.administrar' },
            },
            ...rutasCrudAdmin,
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
