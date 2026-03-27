<x-layouts.plantilla titulo="Administrar Usuarios" meta-descripcion="Meta descripción de Administrar Usuarios" nombre-pagina="administrador-usuarios">
    <span class="titulo">Administrar Usuarios</span>
    <x-usuario.administrador.usuarios.crear-usuario :roles=$roles :categorias="$categorias" :cargos="$cargos"/>
    <x-usuario.administrador.usuarios.buscar-usuario/>
    @if(!empty($informacionPersonal))
        <ul class="collapsible expandable mostrar-usuario">
            <li class="active">
                <div class="collapsible-header"><i class="material-icons">assignment_ind</i>Datos Personales</div>
                <div class="collapsible-body datos-personales">
                    <x-usuario.administrador.usuarios.datos-personales :informacionPersonal="$informacionPersonal"/>
                </div>
            </li>
            <li class="active">
                <div class="collapsible-header"><i class="material-icons">contacts</i>Datos de Contacto</div>
                <div class="collapsible-body datos-contacto">
                    <x-usuario.administrador.usuarios.datos-contacto :informacionPersonal="$informacionPersonal"/>
                </div>
            </li>
            @if((!empty($administrativo))&&(!empty($docente)))
                <x-usuario.administrador.usuarios.datos-administrativo :administrativo="$administrativo" :cargos="$cargos"/>
                <x-usuario.administrador.usuarios.datos-docente :docente="$docente" :categorias="$categorias" :asignaturasDocente="$asignaturasDocente"/>
            @else
                @if(!empty($administrativo))
                    <x-usuario.administrador.usuarios.datos-administrativo :administrativo="$administrativo" :cargos="$cargos"/>
                @endif
                @if(!empty($docente))
                    <x-usuario.administrador.usuarios.datos-docente :docente="$docente" :categorias="$categorias" :asignaturasDocente="$asignaturasDocente"/>
                @endif
            @endif

            @if(!empty($estudiante))
                @empty($auxiliar)
                    <x-usuario.administrador.usuarios.datos-estudiante :estudiante="$estudiante"/>
                @else
                    <x-usuario.administrador.usuarios.datos-estudiante :estudiante="$estudiante"/>
                    <x-usuario.administrador.usuarios.datos-auxiliar :auxiliar="$auxiliar" :asignaturasAuxiliar="$asignaturasAuxiliar"/>
                @endempty
            @endif
        </ul>
    @endif
</x-layouts.plantilla>