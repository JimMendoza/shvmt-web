import axios from 'axios';
import http from '@/servicios/http';

export async function prepararCsrf() {
    await axios.get('/sanctum/csrf-cookie', { withCredentials: true });
}

export function iniciarSesion(datos) {
    return http.post('/auth/login', datos);
}

export function obtenerUsuarioActual() {
    return http.get('/auth/me');
}

export function actualizarContrasena(datos) {
    return http.patch('/auth/contrasena', datos);
}

export function cerrarSesion() {
    return http.post('/auth/logout');
}
