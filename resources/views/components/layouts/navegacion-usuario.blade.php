@auth
    <div id="navegacion-usuario" class="navegacion-usuario navegacion-usuario-inactivo">
        @php
            $datosPersona = session('datosPersona');
            $rolActivoUsuario = session('rolActivoUsuario');
        @endphp
        <span>{{ $datosPersona->persona_nombres }} {{ $datosPersona->persona_primer_apellido }} {{ $datosPersona->persona_segundo_apellido}}</span>
        <div class="divider"></div>
        <ul>
            <ul>
                <span>Rol:</span>
                @foreach (session('rolesUsuario') as $rolesUsuario)
                    @if ($rolesUsuario->rol_nombre == $rolActivoUsuario->rol_nombre)
                    <li><span class="{{ ($rolesUsuario->rol_nombre == $rolActivoUsuario->rol_nombre)? 'rol':'' }} contenedor-icono"><span>{{ $rolesUsuario->rol_nombre }}</span><i class="material-icons derecha">check_circle</i></span></li>
                    @else
                        <li><form action="{{ route('cambiar-rol') }}" method="POST">
                            @csrf
                            <input type="hidden" name="rol" value="{{ $rolesUsuario->rol_nombre }}" required>
                            <button type="submit" class="{{ ($rolesUsuario->rol_nombre == $rolActivoUsuario->rol_nombre)? 'rol':'' }}">{{ $rolesUsuario->rol_nombre }}</button>
                        </form></li>
                    @endif
                @endforeach
            </ul>
            <div class="divider"></div>
            <li><a href="{{ route('perfil') }}"><span class="contenedor-icono"><span>Perfil</span><i class="material-icons derecha">admin_panel_settings</i></span></a></li>
            <li>
                <form action="{{ route('cerrar-sesion') }}" method="POST">
                    @csrf
                    <button class="waves-effect waves-light btn-small fondo-principal-4 hover-90" type="submit"><span class="contenedor-icono"><span>Cerrar sesión</span><i class="material-icons derecha">power_settings_new</i></span></button>
                </form>
            </li>
        </ul>
    </div>
@endauth