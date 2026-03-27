<li class="{{ request()->routeIs('inicio') ? 'active':''}}"><a href="{{ route('inicio') }}"><span class="contenedor-icono"><i class="material-icons izquierda">home</i><span>Inicio</span></span></a></li>
<li class="{{ request()->routeIs('nosotros') ? 'active':''}}"><a href="{{ route('nosotros') }}"><span class="contenedor-icono"><i class="material-icons izquierda">group</i><span>Nosotros</span></span></a></li>
<li class="sub-menu-global {{ request()->routeIs(['anuncios', 'comunicados', 'convocatorias']) ? 'active':''}}"><a href="#"><span class="contenedor-icono"><i class="material-icons izquierda">campaign</i><span>Publicaciones</span><i class="material-icons derecha">arrow_drop_down</i></span></a>
    <ul class="fondo-principal-1">  
        {{-- <li class="{{ request()->routeIs('comunicados') ? 'active':''}}"><a href="{{ route('comunicados') }}"><span class="contenedor-icono"><i class="material-icons izquierda">local_library</i><span>Auxiliares</span></span></a></li> --}}
        <li class="{{ request()->routeIs('comunicados') ? 'active':''}}"><a href="{{ route('comunicados') }}"><span class="contenedor-icono"><i class="material-icons izquierda">speaker_notes</i><span>Comunicados</span></span></a></li>
        <li class="{{ request()->routeIs('convocatorias') ? 'active':''}}"><a href="{{ route('convocatorias') }}"><span class="contenedor-icono"><i class="material-icons izquierda">badge</i><span>Convocatorias</span></span></a></li>
        {{-- <li class="{{ request()->routeIs('comunicados') ? 'active':''}}"><a href="{{ route('comunicados') }}"><span class="contenedor-icono"><i class="material-icons izquierda">record_voice_over</i><span>Docentes</span></span></a></li> --}}
        <li class="{{ request()->routeIs('anuncios') ? 'active':''}}"><a href="{{ route('anuncios') }}"><span class="contenedor-icono"><i class="material-icons izquierda">device_unknown</i><span>Otros Anuncios</span></span></a></li>
    </ul>
</li>
<li class="{{ request()->routeIs('pensum') ? 'active':''}}"><a href="{{ route('pensum') }}"><span class="contenedor-icono"><i class="material-icons izquierda">school</i><span>Pensum</span></span></a></li>
<li class="{{ request()->routeIs('horarios') ? 'active':''}}"><a href="{{ route('horarios') }}"><span class="contenedor-icono"><i class="material-icons izquierda">watch_later</i><span>Horarios</span></span></a></li>
{{-- <li class="{{ request()->routeIs('pruebas') ? 'active':''}}"><a href="{{ route('pruebas') }}"><span class="contenedor-icono"><i class="material-icons izquierda">bug_report</i><span>Pruebas</span></span></a></li> --}}