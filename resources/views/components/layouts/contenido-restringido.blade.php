@if ((session('rolActivoUsuario')->rol_nombre ==  $rol))
    {{ $slot }}
@endif