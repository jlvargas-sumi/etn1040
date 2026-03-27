<x-layouts.plantilla titulo="Administrar Docentes" meta-descripcion="Meta descripción de Administrar Docentes" nombre-pagina="administrador-docentes">
    <span class="titulo">Administrar Docentes</span>
    <x-usuario.administrador.personal.docentes.resultado :docentes=$docentes :categorias=$categorias />
    <x-usuario.administrador.personal.docentes.agregar :categorias=$categorias />
</x-layouts.plantilla>