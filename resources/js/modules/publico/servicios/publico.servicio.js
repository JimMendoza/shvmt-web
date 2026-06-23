import http from '@/servicios/http';

export function obtenerConfiguracion() {
    return http.get('/publico/configuracion-sitio');
}

export function obtenerHistoria() {
    return http.get('/publico/historia');
}

export function obtenerMayordomia() {
    return http.get('/publico/mayordomia');
}

export function obtenerPrograma() {
    return http.get('/publico/programa');
}

export function obtenerAlbumes() {
    return http.get('/publico/albumes');
}

export function obtenerAlbum(slug) {
    return http.get(`/publico/albumes/${slug}`);
}

export function obtenerVideos() {
    return http.get('/publico/videos');
}

export function obtenerUbicaciones() {
    return http.get('/publico/ubicaciones');
}

export function obtenerArchivoHistorico() {
    return http.get('/publico/archivo-historico');
}
