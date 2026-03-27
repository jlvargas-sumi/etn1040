<x-layouts.plantilla titulo="Administrar Administrativos" meta-descripcion="Meta descripción de Administrar Administrativos" nombre-pagina="administrador-administrativos">
    <span class="titulo">Administrar Administrativos</span>
    <x-usuario.administrador.personal.administrativos.resultado :administrativos=$administrativos :cargos=$cargos/>
    <x-usuario.administrador.personal.administrativos.agregar :cargos=$cargos/>
</x-layouts.plantilla>