<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $metadatos['descripcion'] }}">
    <meta name="theme-color" content="#6E1B2F">
    <meta property="og:title" content="{{ $metadatos['titulo'] }}">
    <meta property="og:description" content="{{ $metadatos['descripcion'] }}">
    <meta property="og:type" content="{{ $metadatos['tipo'] }}">
    <meta property="og:url" content="{{ $metadatos['url'] }}">
    @if ($metadatos['imagen'])
        <meta property="og:image" content="{{ url($metadatos['imagen']) }}">
    @endif
    <title>{{ $metadatos['titulo'] }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div id="app"></div>
</body>
</html>
