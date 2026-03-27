@if (session('rolActivoUsuario')->rol_nombre == 'Administrador')
    <li class="sub-menu-global {{ request()->routeIs(['administrador.usuarios', 'administrador.administrativos', 'administrador.auxiliares', 'administrador.docentes', 'administrador.estudiantes']) ? 'active':''}}"><a href="#"><span class="contenedor-icono"><i class="material-icons izquierda">manage_accounts</i><span>Personal</span><i class="material-icons derecha">arrow_drop_down</i></span></a>
        <ul class="fondo-principal-1">  
            <li class="{{ request()->routeIs('administrador.usuarios') ? 'active':''}}"><a href="{{ route('administrador.usuarios') }}"><span class="contenedor-icono"><i class="material-icons izquierda">groups</i><span>Usuarios</span></span></a></li>
            <li class="{{ request()->routeIs('administrador.administrativos') ? 'active':''}}"><a href="{{ route('administrador.administrativos') }}"><span class="contenedor-icono"><i class="material-icons izquierda">print</i><span>Administrativos</span></span></a></li>
            <li class="{{ request()->routeIs('administrador.auxiliares') ? 'active':''}}"><a href="{{ route('administrador.auxiliares') }}"><span class="contenedor-icono"><i class="material-icons izquierda">local_library</i><span>Auxiliares</span></span></a></li>
            <li class="{{ request()->routeIs('administrador.docentes') ? 'active':''}}"><a href="{{ route('administrador.docentes') }}"><span class="contenedor-icono"><i class="material-icons izquierda">record_voice_over</i><span>Docentes</span></span></a></li>
            <li class="{{ request()->routeIs('administrador.estudiantes') ? 'active':''}}"><a href="{{ route('administrador.estudiantes') }}"><span class="contenedor-icono"><i class="material-icons izquierda">school</i><span>Estudiantes</span></span></a></li>
        </ul>
    </li>
    <li class="sub-menu-global {{ request()->routeIs(['administrador.asignaturas', 'administrador.aulas', 'administrador.horarios', 'administrador.menciones', 'administrador.planes-estudios']) ? 'active':''}}"><a href="#"><span class="contenedor-icono"><i class="material-icons izquierda">location_city</i><span>Carrera</span><i class="material-icons derecha">arrow_drop_down</i></span></a>
        <ul class="fondo-principal-1">  
            <li class="{{ request()->routeIs('administrador.asignaturas') ? 'active':''}}"><a href="{{ route('administrador.asignaturas') }}"><span class="contenedor-icono"><i class="material-icons izquierda">auto_stories</i><span>Asignaturas</span></span></a></li>
            <li class="{{ request()->routeIs('administrador.aulas') ? 'active':''}}"><a href="{{ route('administrador.aulas') }}"><span class="contenedor-icono"><i class="material-icons izquierda">door_front</i><span>Aulas</span></span></a></li>
            {{-- <li class="{{ request()->routeIs('administrador.horarios') ? 'active':''}}"><a href="{{ route('administrador.horarios') }}"><span class="contenedor-icono"><i class="material-icons izquierda">watch_later</i><span>Horarios</span></span></a></li> --}}
            <li class="{{ request()->routeIs('administrador.menciones') ? 'active':''}}"><a href="{{ route('administrador.menciones') }}"><span class="contenedor-icono"><i class="material-icons izquierda">class</i><span>Menciones</span></span></a></li>
            <li class="{{ request()->routeIs('administrador.planes-estudios') ? 'active':''}}"><a href="{{ route('administrador.planes-estudios') }}"><span class="contenedor-icono"><i class="material-icons izquierda">school</i><span>Planes de Estudios</span></span></a></li>
        </ul>
    </li>
    <li class="sub-menu-global {{ request()->routeIs(['administrador.aperturas', 'administrador.auxiliaturas', 'administrador.docencias']) ? 'active':''}}"><a href="#"><span class="contenedor-icono"><i class="material-icons izquierda">rule</i><span>Inscripciones</span><i class="material-icons derecha">arrow_drop_down</i></span></a>
        <ul class="fondo-principal-1">  
            <li class="{{ request()->routeIs('administrador.aperturas') ? 'active':''}}"><a href="{{ route('administrador.aperturas') }}"><span class="contenedor-icono"><i class="material-icons izquierda">ballot</i><span>Aperturas</span></span></a></li>
            <li class="{{ request()->routeIs('administrador.auxiliaturas') ? 'active':''}}"><a href="{{ route('administrador.auxiliaturas') }}"><span class="contenedor-icono"><i class="material-icons izquierda">import_contacts</i><span>Auxiliaturas</span></span></a></li>
            <li class="{{ request()->routeIs('administrador.docencias') ? 'active':''}}"><a href="{{ route('administrador.docencias') }}"><span class="contenedor-icono"><i class="material-icons izquierda">auto_stories</i><span>Docencias</span></span></a></li>
        </ul>
    </li>
    <li class="{{ request()->routeIs('administrador.panel-control') ? 'active':''}}"><a href="{{ route('administrador.panel-control') }}"><span class="contenedor-icono"><i class="material-icons izquierda">admin_panel_settings</i><span>Panel de Control</span></span></a></li>
@endif