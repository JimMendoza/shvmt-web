import http from '@/servicios/http';

export function listar(recurso) {
    return http.get(`/admin/${recurso}`);
}

export function crear(recurso, datos) {
    return http.post(`/admin/${recurso}`, datos);
}

export function actualizar(recurso, id, datos) {
    return http.put(`/admin/${recurso}/${id}`, datos);
}

export function eliminar(recurso, id) {
    return http.delete(`/admin/${recurso}/${id}`);
}

export function obtenerMenu() {
    return http.get('/admin/menu');
}

export function asignarRoles(usuarioId, roles) {
    return http.put(`/admin/usuarios/${usuarioId}/roles`, { roles });
}

export function asignarPermisos(rolId, permisos) {
    return http.put(`/admin/roles/${rolId}/permisos`, { permisos });
}
