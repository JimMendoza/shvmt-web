# Festividad del Señor de Huanca VMT

Aplicación monolítica Laravel con frontend SPA en Vue 3 para el sitio público y su panel administrativo.

## Tecnologías

- Laravel 13
- PHP 8.3
- Vue 3
- PrimeVue
- Pinia
- Vue Router
- PostgreSQL
- Vite

## Preparación local

```bash
composer install
npm install
php artisan key:generate
npm run build
```

Configurar la conexión PostgreSQL en `.env` y ejecutar:

```bash
php artisan migrate
php artisan serve
```

Rutas disponibles en la fase 1:

```txt
/
/admin/login
/admin/dashboard
/api/estado
```

El acceso y la protección del panel se implementarán en la fase 2.
