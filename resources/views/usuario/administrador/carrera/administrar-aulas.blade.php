<x-layouts.plantilla titulo="Administrar Aulas" meta-descripcion="Meta descripción de Administrar Aulas" nombre-pagina="administrador-aulas">
    <span class="titulo">Administrar aulas</span>
    <x-usuario.administrador.carrera.aulas.crear />
    <x-usuario.administrador.carrera.aulas.resultado :aulas=$aulas />
</x-layouts.plantilla>
