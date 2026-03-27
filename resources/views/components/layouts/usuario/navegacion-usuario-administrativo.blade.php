@if (session('rolActivoUsuario')->rol_nombre == 'Administrativo')
    <li class="{{ request()->routeIs('administrativo.publicaciones') ? 'active':''}}"><a href="{{ route('administrativo.publicaciones') }}"><span class="contenedor-icono"><i class="material-icons izquierda">library_books</i><span>Publicar</span></span></a></li>    
@endif