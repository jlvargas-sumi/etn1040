<x-layouts.plantilla titulo="Administrar Usuarios" meta-descripcion="Meta descripción de Administrar Usuarios" nombre-pagina="administrador-usuarios">
    <span class="titulo">Administrar Usuarios</span>
    <x-usuario.administrador.personal.usuarios.crear :roles=$roles :categorias="$categorias" :cargos="$cargos"/>
    <x-usuario.administrador.personal.usuarios.resultado :usuarios=$usuarios />
</x-layouts.plantilla>