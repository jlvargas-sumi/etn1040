<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="{{ $metaDescripcion ?? 'Por Defecto Meta Descripcion'}}">
    <title>{{ $titulo ?? ''}}</title>
    @vite(['resources/css/app.css'])
    @vite(['resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('imagenes/logo_ventana.png') }}">
</head>
<body>
    <div @guest {{ "id=contenedor-principal" }} @endguest>
        <aside class="fondo-aside">
            <x-layouts.logo/>
            <x-layouts.navegacion-usuario-autenticado/>
        </aside>
        <header class="fondo-header">
            <x-layouts.logo/>
            <x-layouts.menu/>
            <x-layouts.navegacion/>
            <x-layouts.sesion/>
            <x-layouts.navegacion-usuario/>
        </header>
        <div id="contenido-principal" class="{{ $nombrePagina }} fondo-principal-3">
            <x-layouts.mensajes/>
            @if (Auth::check() && is_null(Auth::user()->usuario_estado))
                <x-usuarios.actualizar-clave/>
            @else
                {{ $slot }} 
            @endif
            <x-layouts.boton-flotante/>
        </div>

        <x-layouts.footer/>
    </div> 
</body>
</html>
