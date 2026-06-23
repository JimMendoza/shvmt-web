import { defineStore } from 'pinia';
import {
    actualizarContrasena,
    cerrarSesion as solicitarCierreSesion,
    iniciarSesion as solicitarInicioSesion,
    obtenerUsuarioActual,
    prepararCsrf,
} from '@/modules/autenticacion/servicios/autenticacion.servicio';

const CLAVE_SESION = 'shvmt_sesion';

export const usarAutenticacionStore = defineStore('autenticacion', {
    state: () => ({
        usuario: null,
        cargado: false,
    }),

    getters: {
        estaAutenticado: (estado) => Boolean(estado.usuario),
        tienePermiso: (estado) => (codigo) => estado.usuario?.permisos?.includes(codigo) ?? false,
        tuvoSesion: () => localStorage.getItem(CLAVE_SESION) === '1',
    },

    actions: {
        async cargarUsuario() {
            try {
                const { data } = await obtenerUsuarioActual();
                this.usuario = data.data;
            } catch {
                this.usuario = null;
                localStorage.removeItem(CLAVE_SESION);
            } finally {
                this.cargado = true;
            }
        },

        async iniciarSesion(datos) {
            await prepararCsrf();
            const { data } = await solicitarInicioSesion(datos);
            this.usuario = data.usuario;
            this.cargado = true;
            localStorage.setItem(CLAVE_SESION, '1');
        },

        async cambiarContrasena(datos) {
            await actualizarContrasena(datos);
            await this.cargarUsuario();
        },

        async cerrarSesion() {
            try {
                await prepararCsrf();
                await solicitarCierreSesion();
            } finally {
                this.usuario = null;
                this.cargado = true;
                localStorage.removeItem(CLAVE_SESION);
            }
        },
    },
});
