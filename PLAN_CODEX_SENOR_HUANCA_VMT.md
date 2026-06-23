# PLAN_CODEX.md
# Proyecto: Sitio Oficial de la Festividad del Señor de Huanca VMT

## 1. Objetivo general

Crear una aplicación web monolítica para la Festividad del Señor de Huanca en Villa María del Triunfo.

El sistema debe tener dos partes principales:

1. Sitio público:
   - Página principal con diseño visual de alto nivel.
   - Historia de la festividad.
   - Mayordomía principal.
   - Programa oficial.
   - Galería de fotos.
   - Videos.
   - Comunicados.
   - Ubicación.
   - Archivo histórico.

2. Panel administrativo:
   - Login.
   - Dashboard.
   - CRUD de contenido.
   - Subida de fotos.
   - Registro de videos.
   - Gestión del programa.
   - Gestión de comunicados.
   - Gestión de historia y mayordomía.
   - Gestión de usuarios administradores.

El proyecto debe ser monolítico usando Laravel como backend y Vue 3 + PrimeVue como frontend, con PostgreSQL como base de datos.

---

## 2. Stack tecnológico

### Backend

- PHP 8.3 o superior.
- Laravel 11 o superior.
- PostgreSQL.
- Laravel Sanctum para autenticación.
- Laravel Storage para archivos.
- Eloquent ORM.
- Migrations, seeders y factories.

### Frontend

- Vue 3.
- PrimeVue.
- PrimeVue en modo styled con preset Aura personalizado para el panel administrativo.
- Pinia.
- Vue Router.
- Axios.
- Vite.
- PrimeIcons.
- CSS/SCSS propio para el sitio público.
- Layout público y layout administrativo.

### Arquitectura

- Arquitectura general: monolito Laravel.
- Backend: MVC de Laravel con API REST interna.
- Frontend: SPA con Vue 3 integrada dentro del mismo proyecto.
- Laravel entrega una única vista base y Vue Router controla las páginas sin recargas completas.
- Las APIs internas se exponen desde Laravel en `/api`.
- El panel administrativo se maneja dentro de la misma SPA, bajo `/admin`.
- Eloquent se usa directamente desde controladores delgados para los CRUD simples.
- No se implementa Repository Pattern porque no aporta valor para el alcance del proyecto.
- Usar FormRequest para validación, API Resources para respuestas y Services solo cuando exista lógica reutilizable o compleja.
- El frontend se organiza por funcionalidad usando pages, components, composables, services y stores.

### Esquemas PostgreSQL

```txt
public: control de migraciones de Laravel
sistema: sesiones, caché, colas y tablas técnicas
seguridad: usuarios, recuperación de contraseña, roles y permisos
contenido: configuración, historia, mayordomía, comunicados, ubicaciones, colaboradores y archivo histórico
programa: días y actividades del programa
galeria: álbumes y fotos
multimedia: videos
```

La tabla `public.migrations` permanecerá en `public` para que una instalación nueva pueda crear automáticamente los demás esquemas. No se crearán tablas de negocio en `public`.

Patrones principales:

```txt
Backend: MVC, Active Record, Form Request, API Resource, Middleware/Gates y RBAC
Frontend: SPA, Feature-Based, Component-Based, Store Pattern, Service Layer y Composables
```

### Convención de idioma para el código

- Los nombres propios del proyecto se escribirán en español: archivos, clases, funciones, variables, módulos, tablas y columnas de negocio.
- Las tablas usarán español, plural y `snake_case`, por ejemplo `usuarios`, `permisos`, `dias_programa` y `actividades_programa`.
- Se conservarán los nombres exigidos o establecidos por Laravel, Vue, PrimeVue y sus librerías.
- Los métodos convencionales de controladores resource seguirán como `index`, `store`, `show`, `update` y `destroy`.
- También se conservarán convenciones técnicas como `id`, `created_at`, `updated_at` y `remember_token`.
- No se traducirán nombres de paquetes, APIs externas ni contratos del framework.

---

## 3. Nombre sugerido del proyecto

Nombre técnico:

```txt
senor-huanca-vmt
```

Nombre visual:

```txt
Festividad del Señor de Huanca VMT
```

Dominio principal definido:

```txt
senordehuancavmt.pe
```

Es corto, identifica directamente la festividad, incluye VMT y usa el dominio territorial de Perú. Si también se adquiere `senordehuancavmt.com`, deberá redirigir al dominio principal `.pe`.

---

## 4. Instalación inicial del proyecto

Crear proyecto Laravel:

```bash
composer create-project laravel/laravel senor-huanca-vmt
cd senor-huanca-vmt
```

Instalar dependencias frontend:

```bash
npm install
npm install vue@latest vue-router@latest pinia axios primevue @primeuix/themes primeicons
```

Instalar Laravel Sanctum:

```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

Configurar PostgreSQL en `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=senor_huanca_vmt
DB_USERNAME=postgres
DB_PASSWORD=tu_password
```

Ejecutar migraciones:

```bash
php artisan migrate
```

---

## 5. Estructura general de carpetas

### Estructura backend

```txt
app/
  Http/
    Controllers/
      SpaController.php
      Api/
        Auth/
          AuthController.php
        Publico/
          SiteController.php
          HistoryController.php
          MayordomiaController.php
          ProgramController.php
          AlbumController.php
          VideoController.php
          AnnouncementController.php
          LocationController.php
          CollaboratorController.php
          HistoricalArchiveController.php
        Admin/
          Dashboard/
            DashboardController.php
          Seguridad/
            UserController.php
            RoleController.php
            PermissionController.php
            RolePermissionController.php
            UserRoleController.php
          Contenido/
            SiteSettingController.php
            HistorySectionController.php
            MayordomiaController.php
            AnnouncementController.php
            LocationController.php
            CollaboratorController.php
            HistoricalEntryController.php
          Programa/
            ProgramDayController.php
            ProgramActivityController.php
          Galeria/
            AlbumController.php
            PhotoController.php
          Multimedia/
            VideoController.php
    Requests/
      Auth/
      Seguridad/
      Contenido/
      Programa/
      Galeria/
      Multimedia/
    Resources/
      Publico/
      Seguridad/
      Contenido/
      Programa/
      Galeria/
      Multimedia/
  Models/
    Seguridad/
      User.php
      Role.php
      Permission.php
    Contenido/
      SiteSetting.php
      HistorySection.php
      Mayordomia.php
      Announcement.php
      Location.php
      Collaborator.php
      HistoricalEntry.php
    Programa/
      ProgramDay.php
      ProgramActivity.php
    Galeria/
      Album.php
      Photo.php
    Multimedia/
      Video.php
  Services/
    Images/
      ImageService.php
    Seo/
      SeoMetadataService.php
    Dashboard/
      DashboardService.php

routes/
  api.php
  web.php
  api/
    auth.php
    public.php
    admin.php
```

`routes/api.php` cargará los archivos de rutas de `routes/api/`. Las migraciones y seeders permanecerán en sus carpetas estándar de Laravel porque son archivos de infraestructura ordenados cronológicamente.

### Estructura frontend

```txt
resources/
  js/
    app.js
    router/
      index.js
    plugins/
      primevue.js
      axios.js
    layouts/
      PublicLayout.vue
      AdminLayout.vue
      AuthLayout.vue
    modules/
      auth/
      dashboard/
      site/
      history/
      mayordomia/
      program/
      gallery/
      videos/
      announcements/
      locations/
      collaborators/
      historical-archive/
      security/
        users/
        roles/
        permissions/
    shared/
      components/
        public/
          HeroSection.vue
          ProgramTimeline.vue
          PhotoGallery.vue
          VideoCard.vue
          AnnouncementCard.vue
          LocationMap.vue
        admin/
          AdminDataTable.vue
          ConfirmDialog.vue
          ImageUploader.vue
          FormSection.vue
          StatusChip.vue
      composables/
      services/
      utils/
      styles/
```

Cada módulo funcional puede contener únicamente las carpetas que necesite:

```txt
pages/
components/
composables/
services/
store/
```

No se crearán carpetas vacías ni se separará cada método en un archivo. Los métodos permanecerán dentro de su controlador, modelo, composable, store o servicio según su responsabilidad.

---

## 6. Diseño visual general

El sitio público debe verse como una producción cultural/religiosa de alto nivel.

### Estilo

- Elegante.
- Devocional.
- Cinematográfico.
- Inspirado en tradición andina y religiosa.
- No debe parecer una plantilla genérica.

### Paleta sugerida

```txt
Dorado: #C9A227
Guinda: #6E1B2F
Rojo oscuro: #8B1E3F
Crema: #F8F1E4
Blanco cálido: #FFFDF7
Negro suave: #15110D
Gris texto: #4B4B4B
```

### Uso visual

- Fondos oscuros en secciones principales.
- Detalles dorados.
- Fotos grandes.
- Tarjetas con bordes suaves.
- Animaciones sutiles.
- Tipografía elegante para títulos.
- Buena experiencia móvil.

El panel administrativo usará PrimeVue de forma directa y funcional. El sitio público tendrá componentes y estilos propios para evitar apariencia de plantilla administrativa.

No se instalará Vuetify ni se mezclarán dos librerías de componentes. Tampoco se requiere Tailwind CSS en la primera versión.

---

## 7. Rutas públicas

Rutas frontend públicas con Vue Router:

```txt
/
 /historia
 /mayordomia
 /programa
 /galeria
 /galeria/:slug
 /videos
 /ubicacion
 /archivo-historico
 /contacto
```

Rutas administrativas:

```txt
/admin/login
/admin/dashboard
/admin/configuracion
/admin/historia
/admin/mayordomia
/admin/programa
/admin/galeria
/admin/videos
/admin/comunicados
/admin/ubicaciones
/admin/colaboradores
/admin/archivo-historico
/admin/usuarios
/admin/roles
/admin/permisos
```

---

## 8. Rutas API Laravel

Archivos:

```txt
routes/api.php
routes/api/auth.php
routes/api/public.php
routes/api/admin.php
```

### Rutas públicas

```php
Route::get('/site-settings', [SiteController::class, 'index']);
Route::get('/history-sections', [HistoryController::class, 'index']);
Route::get('/mayordomia', [MayordomiaController::class, 'show']);
Route::get('/program-days', [ProgramController::class, 'index']);
Route::get('/albums', [AlbumController::class, 'index']);
Route::get('/albums/{slug}', [AlbumController::class, 'show']);
Route::get('/videos', [VideoController::class, 'index']);
Route::get('/announcements', [AnnouncementController::class, 'index']);
Route::get('/locations', [LocationController::class, 'index']);
Route::get('/collaborators', [CollaboratorController::class, 'index']);
Route::get('/historical-entries', [HistoricalArchiveController::class, 'index']);
```

### Rutas de autenticación

```php
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/auth/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
```

### Rutas protegidas

```php
Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::apiResource('/site-settings', SiteSettingController::class);
    Route::apiResource('/history-sections', HistorySectionController::class);
    Route::apiResource('/mayordomia', MayordomiaController::class);
    Route::apiResource('/program-days', ProgramDayController::class);
    Route::apiResource('/program-activities', ProgramActivityController::class);
    Route::apiResource('/albums', AlbumController::class);
    Route::apiResource('/photos', PhotoController::class);
    Route::apiResource('/videos', VideoController::class);
    Route::apiResource('/announcements', AnnouncementController::class);
    Route::apiResource('/locations', LocationController::class);
    Route::apiResource('/collaborators', CollaboratorController::class);
    Route::apiResource('/historical-entries', HistoricalEntryController::class);
    Route::apiResource('/users', UserController::class);
    Route::apiResource('/roles', RoleController::class);
    Route::apiResource('/permissions', PermissionController::class)->only(['index']);
    Route::put('/roles/{role}/permissions', [RolePermissionController::class, 'sync']);
    Route::put('/users/{user}/roles', [UserRoleController::class, 'sync']);
});
```

### Ruta web de la SPA

Archivo:

```txt
routes/web.php
```

`SpaController` devolverá la vista base de Vue. Antes de renderizarla resolverá los metadatos generales o los metadatos del álbum, video o comunicado publicado identificado por la URL. La vista Blade imprimirá title, description y Open Graph, y luego montará la SPA.

---

## 9. Modelos principales

### User

Campos:

```txt
id
nombre
correo
contrasena
activo
debe_cambiar_contrasena
created_at
updated_at
```

Relaciones:

```txt
User belongsToMany Role
Role belongsToMany User
Role belongsToMany Permission
Permission belongsToMany Role
```

La seguridad se implementa con RBAC simplificado. No se crearán personas, dependencias ni una tabla genérica de estados.

Tablas necesarias:

```txt
seguridad.usuarios
seguridad.roles
seguridad.permisos
seguridad.rol_usuario
seguridad.permiso_rol
```

Roles iniciales sugeridos:

```txt
admin
editor
photographer
```

Los permisos se identifican mediante códigos, por ejemplo:

```txt
usuarios.ver
usuarios.crear
usuarios.editar
roles.ver
roles.crear
roles.editar
roles.asignar_permisos
programa.ver
programa.crear
programa.editar
galeria.ver
galeria.crear
galeria.editar
```

---

### SiteSetting

Sirve para datos generales del sitio.

Campos:

```txt
id
site_name
site_subtitle
main_year
main_date
hero_title
hero_subtitle
hero_image
hero_video
logo
primary_color
secondary_color
contact_phone
contact_email
facebook_url
youtube_url
tiktok_url
instagram_url
created_at
updated_at
```

---

### HistorySection

Sirve para contar la historia local.

Campos:

```txt
id
title
subtitle
content
image
sort_order
is_published
created_at
updated_at
```

---

### Mayordomia

Sirve para los datos de la mayordomía principal.

Campos:

```txt
id
year
title
family_name
main_mayordoma_name
message
image
is_current
is_published
created_at
updated_at
```

---

### ProgramDay

Agrupa actividades por día.

Campos:

```txt
id
title
description
date
sort_order
is_published
created_at
updated_at
```

---

### ProgramActivity

Actividades del programa.

Campos:

```txt
id
program_day_id
title
description
start_time
end_time
location_name
address
map_url
map_embed_url
responsible
sort_order
is_published
created_at
updated_at
```

---

### Album

Campos:

```txt
id
title
slug
description
year
cover_photo_id
sort_order
is_published
created_at
updated_at
```

---

### Photo

Campos:

```txt
id
album_id
title
description
file_path
thumbnail_path
medium_path
sort_order
is_published
created_at
updated_at
```

---

### Video

Campos:

```txt
id
title
slug
description
video_url
embed_url
thumbnail
category
year
sort_order
is_featured
is_published
created_at
updated_at
```

Categorías sugeridas:

```txt
teaser
invitacion
documental
misa
procesion
pasacalle
resumen
archivo
```

---

### Announcement

Campos:

```txt
id
title
slug
content
image
is_featured
is_published
published_at
created_at
updated_at
```

---

### Location

Campos:

```txt
id
title
description
address
map_url
map_embed_url
type
sort_order
is_published
created_at
updated_at
```

Tipos sugeridos:

```txt
iglesia
local
concentracion
ruta
referencia
```

---

### Collaborator

Campos:

```txt
id
name
description
type
image
sort_order
is_published
created_at
updated_at
```

Tipos sugeridos:

```txt
familia
padrino
alferado
devoto
banda
orquesta
institucion
colaborador
```

---

### HistoricalEntry

Sirve para archivo histórico por año.

Campos:

```txt
id
year
title
description
mayordomos
cover_image
sort_order
is_published
created_at
updated_at
```

---

## 10. Migraciones

Crear migraciones para todos los modelos anteriores.

Comandos sugeridos:

```bash
php artisan make:model SiteSetting -m
php artisan make:model HistorySection -m
php artisan make:model Mayordomia -m
php artisan make:model ProgramDay -m
php artisan make:model ProgramActivity -m
php artisan make:model Album -m
php artisan make:model Photo -m
php artisan make:model Video -m
php artisan make:model Announcement -m
php artisan make:model Location -m
php artisan make:model Collaborator -m
php artisan make:model HistoricalEntry -m
php artisan make:model Role -m
php artisan make:model Permission -m
```

Relaciones:

```txt
ProgramDay hasMany ProgramActivity
ProgramActivity belongsTo ProgramDay

Album hasMany Photo
Photo belongsTo Album

Album belongsTo Photo as cover_photo opcional

Usuario belongsToMany Rol mediante seguridad.rol_usuario
Rol belongsToMany Usuario mediante seguridad.rol_usuario
Rol belongsToMany Permiso mediante seguridad.permiso_rol
Permiso belongsToMany Rol mediante seguridad.permiso_rol

HistoricalEntry no se relacionará con álbumes en la primera versión
```

---

## 11. Seeders iniciales

Crear seeders para:

```txt
AdminUserSeeder
RolePermissionSeeder
SiteSettingSeeder
HomeContentSeeder
ProgramSeeder
GallerySeeder
VideoSeeder
AnnouncementSeeder
LocationSeeder
```

Usuario admin inicial:

```txt
Nombre: Administrador
Email: admin@senordehuancavmt.pe
Password: cambiar123456
Rol: admin
```

Después del primer login, se debe cambiar la contraseña.

Contenido provisional para desarrollo:

```txt
Nombre: Festividad del Señor de Huanca VMT
Subtítulo: Fe, tradición y comunidad
Hero: Festividad del Señor de Huanca
Mensaje principal: Una tradición de fe que une a Villa María del Triunfo
Año principal: año actual
Fecha principal: pendiente de confirmación
Ubicación general: Villa María del Triunfo, Lima, Perú
Teléfono provisional: +51 999 999 999
Correo provisional: contacto@senordehuancavmt.pe
Redes sociales: vacías hasta contar con enlaces oficiales
Logo e imágenes: recursos provisionales claramente reemplazables
```

Los seeders usarán este contenido para que el sitio funcione visualmente desde el inicio. Todos estos valores podrán editarse desde el panel administrativo.

---

## 12. Autenticación

Usar Laravel Sanctum.

Flujo:

1. Usuario entra a `/admin/login`.
2. Vue envía email y password a `/api/auth/login`.
3. Laravel valida credenciales.
4. Si es correcto, inicia una sesión segura mediante cookie.
5. Pinia guarda el estado del usuario.
6. Vue Router protege rutas admin.
7. Cada request admin usa Axios con credenciales y protección CSRF.
8. Logout invalida la sesión.

Store sugerido:

```txt
auth.store.js
```

Estado:

```js
user: null
isAuthenticated: false
loading: false
```

Acciones:

```js
login(credentials)
logout()
fetchMe()
```

---

## 13. Panel administrativo

### Dashboard

Debe mostrar:

```txt
Total de álbumes
Total de fotos
Total de videos
Total de comunicados
Próximas actividades
Contenido destacado
Últimas fotos subidas
```

---

### Gestión de configuración

Permite editar:

```txt
Nombre del sitio
Subtítulo
Año principal
Fecha principal
Texto de portada
Imagen de portada
Video de portada
Logo
Redes sociales
Teléfono
Correo
Colores principales
```

---

### Gestión de historia

CRUD de secciones de historia:

```txt
Crear sección
Editar sección
Eliminar sección
Publicar/despublicar
Ordenar secciones
Subir imagen
```

---

### Gestión de mayordomía

Permite editar:

```txt
Año
Nombre de mayordoma principal
Familia
Mensaje
Imagen
Estado actual
Publicado/no publicado
```

---

### Gestión de programa

Debe permitir:

```txt
Crear días del programa
Crear actividades dentro de cada día
Ordenar actividades
Editar horarios
Editar lugares
Agregar enlaces de Google Maps
Agregar URL embebible de Google Maps
Publicar/despublicar actividades
```

Vista admin recomendada:

```txt
Accordion por día
Dentro de cada día, tabla de actividades
Botón agregar actividad
Botón ordenar
```

---

### Gestión de galería

Debe permitir:

```txt
Crear álbum
Editar álbum
Subir portada
Subir múltiples fotos
Ordenar fotos
Editar título/descripción de foto
Publicar/despublicar foto
Eliminar foto
```

Importante:

- Validar tamaño máximo de imagen.
- Validar formato jpg, jpeg, png, webp.
- Generar miniaturas.
- Guardar rutas en base de datos.

---

### Gestión de videos

Debe permitir:

```txt
Crear video
Editar video
Eliminar video
Publicar/despublicar
Marcar como destacado
Asignar categoría
Asignar año
Guardar URL de YouTube
Generar y guardar URL embebible de YouTube
Guardar miniatura
```

No subir videos pesados al servidor en la primera versión.
No se guardará HTML de iframe; se guardarán URLs y el frontend construirá el iframe.

---

### Gestión de comunicados

Debe permitir:

```txt
Crear comunicado
Editar comunicado
Eliminar comunicado
Publicar/despublicar
Marcar como destacado
Agregar imagen
Fecha de publicación
```

---

### Gestión de ubicaciones

Debe permitir:

```txt
Crear punto de ubicación
Editar dirección
Agregar URL de Google Maps
Agregar URL embebible de Google Maps
Definir tipo de lugar
Ordenar
Publicar/despublicar
```

---

### Gestión de colaboradores

Debe permitir:

```txt
Crear colaborador
Editar colaborador
Agregar imagen/logo
Definir tipo
Ordenar
Publicar/despublicar
```

---

### Gestión de archivo histórico

Debe permitir:

```txt
Crear entrada por año
Editar mayordomos de ese año
Agregar descripción
Agregar imagen de portada
Publicar/despublicar
Ordenar
```

---

### Gestión de usuarios

Solo admin puede:

```txt
Crear usuario
Editar usuario
Desactivar usuario
Cambiar rol
Resetear contraseña
```

### Gestión de roles y permisos

Solo admin puede:

```txt
Crear y editar roles
Activar o desactivar roles
Asignar permisos a roles
Asignar roles a usuarios
Consultar permisos disponibles
```

Los permisos se crean inicialmente mediante seeder. No se requiere crear permisos libremente desde la interfaz en la primera versión.

---

## 14. Frontend público

### HomePage

Debe contener:

1. Hero principal.
2. Mensaje de bienvenida.
3. Sección de mayordomía actual.
4. Próximas actividades del programa.
5. Galería destacada.
6. Videos destacados.
7. Comunicados recientes.
8. Ubicación principal.
9. Botón flotante de WhatsApp.

---

### HistoryPage

Debe mostrar:

- Título principal.
- Introducción.
- Secciones de historia en orden.
- Imágenes.
- Línea de tiempo opcional.
- Enfoque local de Villa María del Triunfo.

---

### MayordomiaPage

Debe mostrar:

- Año.
- Nombre de mayordoma principal.
- Familia.
- Mensaje.
- Foto oficial.
- Colaboradores relacionados.
- Agradecimiento.

---

### ProgramPage

Debe mostrar:

- Días del programa.
- Actividades ordenadas por hora.
- Lugar.
- Mapa embebido de Google Maps si existe.
- Botón para abrir la ubicación en Google Maps.
- Botón para compartir por WhatsApp.

---

### GalleryPage

Debe mostrar:

- Listado de álbumes.
- Portada del álbum.
- Año.
- Descripción.
- Link a detalle.

---

### AlbumDetailPage

Debe mostrar:

- Fotos en grid.
- Vista lightbox.
- Título y descripción.
- Navegación entre fotos.
- Diseño responsive.

---

### VideosPage

Debe mostrar:

- Videos destacados.
- Videos por categoría.
- Cards con miniatura.
- Reproducción mediante iframe embebido de YouTube.

---

### LocationPage

Debe mostrar:

- Lugares importantes.
- Mapas embebidos de Google Maps.
- Botones a Google Maps.
- Referencias.
- Ruta del pasacalle si aplica.

---

### HistoricalArchivePage

Debe mostrar:

- Entradas por año.
- Mayordomos.
- Breve resumen.
- Imagen de portada.

La relación entre archivo histórico y álbumes queda fuera de la primera versión.

---

### ContactPage

Debe mostrar:

- Teléfono y correo configurados.
- Redes sociales.
- Botón de WhatsApp.
- Información de contacto estática.

No incluirá formulario de envío de mensajes en la primera versión.

---

## 15. Pinia stores

Stores ubicados dentro de su módulo:

```txt
modules/autenticacion/store/autenticacion.store.js
modules/site/store/site.store.js
modules/program/store/program.store.js
modules/gallery/store/gallery.store.js
modules/videos/store/video.store.js
modules/announcements/store/announcement.store.js
modules/dashboard/store/dashboard.store.js
modules/security/users/store/user.store.js
modules/security/roles/store/role.store.js
```

Crear un store únicamente cuando el módulo necesite estado compartido, caché o coordinación entre componentes. Una página simple puede consumir su service desde un composable sin agregar un store.

### site.store.js

Responsable de:

```txt
Cargar configuración general
```

### program.store.js

Responsable de:

```txt
Cargar días del programa
Cargar actividades
```

### gallery.store.js

Responsable de:

```txt
Cargar álbumes
Cargar detalle de álbum
```

### video.store.js

Responsable de:

```txt
Cargar videos
Cargar videos destacados
```

### announcement.store.js

Responsable de:

```txt
Cargar comunicados
Cargar destacados
```

### dashboard.store.js

Responsable de:

```txt
Cargar estadísticas del dashboard
Estados globales del admin
```

---

## 16. Componentes visuales sugeridos

Públicos:

```txt
HeroSection.vue
SectionTitle.vue
ProgramTimeline.vue
MayordomiaCard.vue
PhotoGallery.vue
VideoCard.vue
AnnouncementCard.vue
LocationCard.vue
WhatsappButton.vue
FooterSection.vue
```

Admin:

```txt
AdminDataTable.vue
AdminFormDialog.vue
ConfirmDialog.vue
ImageUploader.vue
StatusChip.vue
SortOrderInput.vue
PublishSwitch.vue
```

---

## 17. Reglas de UI/UX

### Sitio público

- Mobile first.
- Carga rápida.
- Imágenes optimizadas.
- Botones grandes.
- Textos legibles.
- Secciones emocionales.
- Fotos protagonistas.
- No saturar de efectos.
- Mantener diseño elegante.

### Admin

- Claridad antes que belleza.
- Tablas limpias.
- Formularios ordenados.
- Mensajes de éxito/error.
- Confirmación antes de eliminar.
- Previsualización de imágenes.
- Estados publicado/borrador visibles.

---

## 18. Manejo de imágenes

Primera versión:

- Subir imágenes a `storage/app/public`.
- Crear enlace:

```bash
php artisan storage:link
```

Guardar rutas públicas en la base de datos.

Validaciones:

```txt
Formatos: jpg, jpeg, png, webp
Peso máximo sugerido: 5 MB
```

Generar:

```txt
thumbnail
medium
```

Guardar la imagen original y generar una miniatura y una versión mediana.

Servicio sugerido:

```txt
app/Services/ImageService.php
```

Responsabilidades:

```txt
Validar archivo
Guardar archivo
Generar nombre único
Crear miniatura
Eliminar archivos antiguos
```

---

## 19. Manejo de videos

Primera versión:

- No subir videos directamente.
- Registrar URL de YouTube.
- Convertirla a una URL embebible de YouTube.
- Guardar miniatura opcional.
- No guardar código HTML de iframe proporcionado por el usuario.

Campos importantes:

```txt
video_url
embed_url
thumbnail
category
is_featured
is_published
```

---

## 20. Seguridad

Implementar:

```txt
Autenticación con Sanctum
Middleware auth:sanctum
Sesiones y cookies seguras para la SPA monolítica
Validaciones con FormRequest
Protección CSRF
RBAC con usuarios, roles y permisos
Gates o middleware can para validar permisos en backend
Validación de archivos
Límite de tamaño de subida
Contenido administrable en texto simple con saltos de línea, sin HTML enriquecido
No exponer rutas admin sin auth
No confiar en permisos del frontend
```

No se implementarán personas, dependencias, estados genéricos ni menús administrables en base de datos. El menú administrativo se define en Vue y se filtra según los permisos del usuario autenticado.

---

## 21. SEO y compartido en redes

Agregar:

```txt
Title dinámico
Meta description
Open Graph image
Open Graph title
Open Graph description
Favicon
Logo
URLs amigables
Slugs para álbumes, videos y comunicados
```

Laravel generará en la respuesta HTML inicial los metadatos de la URL solicitada. Para álbumes, videos y comunicados consultará el contenido publicado por slug antes de montar la SPA. Vue seguirá controlando la navegación y el contenido visual.

No se dependerá únicamente de cambios de meta tags ejecutados en el navegador, porque los lectores de enlaces de WhatsApp y Facebook necesitan recibir Open Graph desde el servidor.

Cuando se comparta en WhatsApp o Facebook debe verse bien:

```txt
Imagen
Título
Descripción
URL
```

---

## 22. Fases de desarrollo para Codex

### Fase 1: Base del proyecto

Objetivo:

- Laravel instalado.
- Vue configurado.
- PrimeVue configurado.
- Pinia configurado.
- Vue Router configurado.
- PostgreSQL conectado.
- Layout público.
- Layout admin.
- Ruta home funcionando.
- Ruta admin login funcionando.

Tareas:

```txt
1. Configurar Laravel con Vite y Vue 3.
2. Configurar PrimeVue, PrimeIcons y el tema administrativo.
3. Configurar Pinia.
4. Configurar Vue Router.
5. Crear layouts principales.
6. Crear páginas placeholder.
7. Crear conexión a PostgreSQL.
```

---

### Fase 2: Autenticación

Estado: completada el 22 de junio de 2026.

Objetivo:

- Login admin funcional.
- Logout.
- Protección de rutas admin.
- Usuario autenticado en Pinia.
- Roles y permisos disponibles en la sesión autenticada.

Tareas:

```txt
1. Instalar y configurar Sanctum.
2. Crear AuthController.
3. Crear endpoints login/logout/me.
4. Crear autenticacion.store.js.
5. Crear AccesoPagina.vue y CuentaPagina.vue.
6. Crear guard de rutas admin.
7. Crear usuario admin inicial con seeder.
8. Crear modelos y tablas de roles, permisos y pivotes.
9. Configurar Gates o middleware can para permisos.
```

---

### Fase 3: Modelos y migraciones

Objetivo:

- Crear toda la base estructural.

Tareas:

```txt
1. Crear modelos.
2. Crear migraciones.
3. Crear relaciones.
4. Crear seeders iniciales.
5. Ejecutar migraciones.
6. Probar consultas básicas.
7. Verificar relaciones User-Role-Permission.
```

---

### Fase 4: APIs públicas

Objetivo:

- El sitio público debe poder leer contenido publicado.

Tareas:

```txt
1. Crear controladores públicos.
2. Crear endpoints públicos.
3. Filtrar por is_published.
4. Ordenar por sort_order.
5. Crear Resources si es necesario.
6. Probar endpoints con datos seed.
```

---

### Fase 5: CRUD admin

Objetivo:

- Administrar contenido desde panel.

Tareas:

```txt
1. Crear controladores admin.
2. Crear CRUD para historia.
3. Crear CRUD para mayordomía.
4. Crear CRUD para programa.
5. Crear CRUD para álbumes.
6. Crear CRUD para fotos.
7. Crear CRUD para videos.
8. Crear CRUD para comunicados.
9. Crear CRUD para ubicaciones.
10. Crear CRUD para colaboradores.
11. Crear CRUD para archivo histórico.
12. Crear CRUD para usuarios y roles.
13. Crear asignación de roles a usuarios y permisos a roles.
```

---

### Fase 6: Admin UI

Objetivo:

- Panel administrativo usable con PrimeVue.

Tareas:

```txt
1. Crear AdminLayout.
2. Crear menú lateral.
3. Crear DashboardPage.
4. Crear tablas CRUD.
5. Crear formularios.
6. Crear dialogs.
7. Crear confirmación de eliminación.
8. Crear subida de imágenes.
9. Crear switches de publicado/no publicado.
10. Crear ordenamiento básico.
```

---

### Fase 7: Sitio público visual

Objetivo:

- Sitio público bonito y de nivel producción.

Tareas:

```txt
1. Crear HomePage final.
2. Crear HeroSection.
3. Crear página Historia.
4. Crear página Mayordomía.
5. Crear página Programa.
6. Crear página Galería.
7. Crear detalle de álbum.
8. Crear página Videos.
9. Crear página Ubicación.
10. Crear Archivo Histórico.
11. Crear Footer.
12. Crear botón WhatsApp.
```

---

### Fase 8: Optimización

Objetivo:

- Mejorar carga, SEO y experiencia.

Tareas:

```txt
1. Optimizar imágenes.
2. Agregar lazy loading.
3. Agregar meta tags.
4. Agregar Open Graph generado por Laravel para rutas compartibles.
5. Mejorar responsive.
6. Revisar Lighthouse.
7. Validar mobile.
8. Validar errores 404.
```

---

### Fase 9: Deploy

Objetivo:

- Publicar el sistema.

Tareas:

```txt
1. Configurar servidor.
2. Configurar PostgreSQL.
3. Configurar .env producción.
4. Ejecutar composer install --no-dev.
5. Ejecutar npm run build.
6. Ejecutar php artisan migrate --force.
7. Ejecutar php artisan storage:link.
8. Configurar permisos storage/bootstrap/cache.
9. Configurar dominio.
10. Configurar SSL.
```

---

## 23. Prompts sugeridos para usar con Codex

### Prompt 1: Crear base Laravel + Vue

```txt
Configura este proyecto Laravel como una aplicación monolítica con Vue 3, PrimeVue, PrimeIcons, Pinia y Vue Router. Usa Vite. Configura un tema de PrimeVue para el panel y estilos propios para el sitio público. Organiza Laravel por módulos dentro de Controllers, Requests, Resources, Models y Services. Organiza Vue por funcionalidades dentro de resources/js/modules, dejando en shared únicamente componentes, composables, services y utilidades realmente compartidos. Divide las rutas API en auth.php, public.php y admin.php cargadas desde routes/api.php. No crees carpetas vacías ni separes métodos individuales en archivos. Crea rutas y páginas placeholder sin implementar aún la lógica de negocio.
```

---

### Prompt 2: Configurar autenticación

```txt
Implementa autenticación de administrador usando Laravel Sanctum con sesiones y cookies para esta SPA monolítica. Crea AutenticacionController con iniciarSesion, cerrarSesion, usuarioActual y cambiarContrasena. Implementa RBAC simplificado con Usuario, Rol, Permiso, seguridad.rol_usuario y seguridad.permiso_rol, sin personas ni dependencias. Crea un seeder para roles, permisos y un usuario admin inicial. En Vue crea autenticacion.store.js con Pinia, AccesoPagina.vue, CuentaPagina.vue y protección de rutas por autenticación y permisos.
```

---

### Prompt 3: Crear modelos y migraciones

```txt
Crea los modelos, migraciones y relaciones para: User, Role, Permission, SiteSetting, HistorySection, Mayordomia, ProgramDay, ProgramActivity, Album, Photo, Video, Announcement, Location, Collaborator y HistoricalEntry. Incluye las tablas pivote role_user y permission_role. Usa PostgreSQL. Agrega campos is_published, sort_order y timestamps donde corresponda. Define relaciones Eloquent correctas.
```

---

### Prompt 4: Crear APIs públicas

```txt
Crea endpoints públicos para leer configuración del sitio, historia, mayordomía actual, programa publicado, álbumes publicados, detalle de álbum, videos publicados, comunicados publicados, ubicaciones, colaboradores y archivo histórico. Los endpoints deben devolver solo contenido publicado y ordenado por sort_order.
```

---

### Prompt 5: Crear CRUD admin

```txt
Crea controladores API protegidos por auth:sanctum para administrar SiteSetting, HistorySection, Mayordomia, ProgramDay, ProgramActivity, Album, Photo, Video, Announcement, Location, Collaborator, HistoricalEntry, User y Role. Agrega endpoints para asignar roles a usuarios y permisos a roles. Protege cada operación con middleware can. Usa Eloquent directamente, FormRequest para validación y API Resources para respuestas. No agregues repositorios.
```

---

### Prompt 6: Crear panel administrativo con PrimeVue

```txt
Crea el panel administrativo en Vue 3 con PrimeVue. Implementa AdminLayout con sidebar, topbar y rutas internas. Cada funcionalidad debe vivir en su módulo y contener solo los pages, components, composables, services y store que necesite. Crea CRUD para historia, mayordomía, programa, álbumes, fotos, videos, comunicados, ubicaciones, colaboradores, archivo histórico, usuarios y roles. Incluye asignación de roles y permisos. Define el menú en Vue y filtra sus opciones con los permisos del usuario. Usa DataTable, Dialog, formularios, FileUpload, ToggleSwitch, Toast y ConfirmDialog de PrimeVue cuando correspondan.
```

---

### Prompt 7: Crear sitio público visual

```txt
Diseña el sitio público de la Festividad del Señor de Huanca VMT con estilo elegante, religioso, andino y cinematográfico. Usa Vue 3 con componentes y CSS propios; utiliza PrimeVue solo en elementos donde aporte funcionalidad. El sitio público no debe parecer un panel administrativo ni una plantilla genérica. Crea HomePage, HistoryPage, MayordomiaPage, ProgramPage, GalleryPage, AlbumDetailPage, VideosPage, LocationPage y HistoricalArchivePage.
```

---

### Prompt 8: Implementar subida de imágenes

```txt
Implementa subida de imágenes para álbumes, fotos, comunicados, historia, mayordomía y configuración del sitio. Usa Laravel Storage en disco public. Valida formatos jpg, jpeg, png y webp y un tamaño máximo de 5 MB. Guarda la imagen original y genera una miniatura y una versión mediana. Guarda sus rutas en base de datos. Crea un ImageService para centralizar guardado, versiones y eliminación de imágenes.
```

---

### Prompt 9: Mejorar SEO y compartir en redes

```txt
Implementa SpaController para que Laravel genere en el HTML inicial title, description, Open Graph title, Open Graph image y Open Graph description. Resuelve metadatos dinámicos para álbumes, videos y comunicados publicados mediante su slug antes de montar la SPA Vue. Agrega favicon y logo configurable desde SiteSetting.
```

---

### Prompt 10: Preparar deploy

```txt
Prepara el proyecto para producción. Revisa .env.example, comandos de build, storage:link, migraciones, seeders, permisos de storage y bootstrap/cache. Agrega instrucciones en README.md para desplegar en un VPS con PostgreSQL.
```

---

## 24. Criterios de aceptación

El proyecto se considera funcional cuando:

```txt
1. El sitio público carga correctamente.
2. El administrador puede iniciar sesión.
3. El administrador puede editar información general.
4. El administrador puede crear programa oficial.
5. El administrador puede crear álbumes.
6. El administrador puede subir fotos.
7. El administrador puede registrar videos.
8. El administrador puede publicar comunicados.
9. El visitante puede ver historia, programa, fotos, videos y ubicación.
10. El sitio es responsive.
11. El sitio se ve bien en celular.
12. Las rutas admin están protegidas.
13. Los permisos se validan en backend mediante Gates o middleware can.
14. El administrador puede asignar roles y permisos.
15. El contenido no publicado no aparece en la web pública.
16. Las imágenes se guardan correctamente.
17. El proyecto puede compilarse con npm run build.
18. El proyecto puede ejecutarse con php artisan serve.
```

---

## 25. Orden recomendado de trabajo

No desarrollar todo a la vez. Seguir este orden:

```txt
1. Base Laravel + Vue + PrimeVue.
2. Rutas y layouts.
3. Autenticación.
4. Base de datos.
5. APIs públicas.
6. CRUD admin.
7. Panel admin.
8. Sitio público.
9. Subida de imágenes.
10. Optimización.
11. Deploy.
```

---

## 26. Nota importante de alcance

Este proyecto no debe verse como una página simple. Debe verse como una plataforma oficial y memoria digital de la festividad.

El diseño público debe transmitir:

```txt
Fe
Tradición
Comunidad
Respeto
Historia
Familia
Devoción
Producción visual
```

El panel administrativo debe ser simple, claro y mantenible.

---

## 27. Decisiones técnicas cerradas

```txt
Arquitectura general: monolito Laravel
Backend: MVC con API REST, Eloquent directo y sin Repository Pattern
Frontend: SPA Vue 3 con PrimeVue, Pinia, Vue Router y Axios
Organización: módulos funcionales con namespaces en backend y feature-based modules en frontend
Base de datos: PostgreSQL separado en esquemas por dominio; public solo conserva migrations
UI administrativa: PrimeVue con preset Aura personalizado
UI pública: componentes y CSS/SCSS propios
Dominio principal: senordehuancavmt.pe
Autenticación: Sanctum con sesiones, cookies y CSRF
Autorización: RBAC con usuarios, roles y permisos
Roles iniciales: admin, editor y photographer
SEO social: metadatos iniciales y Open Graph generados por Laravel
Contenido: texto simple con saltos de línea, sin editor HTML enriquecido
Videos: YouTube mediante URL y reproducción embebida
Mapas: Google Maps mediante URL normal y URL embebible, sin API
Contacto: información estática, redes y WhatsApp, sin formulario
Imágenes: original, thumbnail y medium, máximo 5 MB
Archivo histórico: sin relación con álbumes en la primera versión
```

Fin del plan.
