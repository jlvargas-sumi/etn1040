<x-layouts.plantilla titulo="Administrar Estudiantes" meta-descripcion="Meta descripción de Administrar Estudiantes" nombre-pagina="administrador-estudiantes">
    <span class="titulo">Administrar Estudiantes</span>
    <x-usuario.administrador.personal.estudiantes.resultado :estudiantes=$estudiantes />
    <x-usuario.administrador.personal.estudiantes.agregar />
</x-layouts.plantilla>