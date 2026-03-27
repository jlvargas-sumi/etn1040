<div class="datos-universitarios col s12 m8 push-m2 l8 push-l2">
    <ul>
        <span>Datos Universitarios</span>
        <li><span class="contenedor-icono"><i class="material-icons izquierda">account_balance</i><span>Universidad Mayor de San Andrés</span></span></li>
        <li><span class="contenedor-icono"><i class="material-icons izquierda">location_city</i><span>Facultad de Ingeniería</span></span></li>
        <li><span class="contenedor-icono"><i class="material-icons izquierda">memory</i><span>Ingeniería Electrónica</span></span></li>

        <x-layouts.contenido-restringido rol="Estudiante">
            <li><span class="contenedor-icono"><i class="material-icons izquierda">class</i><span>Mensión Sistemas</span></span></li>
            <li><span class="contenedor-icono"><i class="material-icons izquierda">call_to_action</i><span>R.U.: 1649018</span></span></li>
        </x-layouts.contenido-restringido>

        <x-layouts.contenido-restringido rol="Auxiliar">
            <li><span class="contenedor-icono"><i class="material-icons izquierda">class</i><span>Mensión Sistemas</span></span></li>
            <li><span class="contenedor-icono"><i class="material-icons izquierda">call_to_action</i><span>R.U.: 1649018</span></span></li>
        </x-layouts.contenido-restringido>

        <li><span class="contenedor-icono"><i class="material-icons izquierda">work</i>
                <span>Rol(es).:
                    @php
                        $filas = count(session('rolesUsuario'));
                        $i=1;
                        foreach (session('rolesUsuario') as $rolesUsuario) {
                            echo $rolesUsuario->rol_nombre;
                            if ($filas > 1 && $filas > $i) {
                                echo " / ";
                            }
                            $i = $i+1;
                        }
                    @endphp
                </span>
            </span>
        </li>
    </ul>
</div>