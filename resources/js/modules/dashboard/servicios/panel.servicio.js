import http from '@/servicios/http';

export function obtenerResumen() {
    return http.get('/admin/dashboard');
}
