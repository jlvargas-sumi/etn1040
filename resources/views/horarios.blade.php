<x-layouts.plantilla titulo="Horarios" meta-descripcion="Meta descripción de Horarios" nombre-pagina="horarios">
    <span class="titulo">Horarios</span>
    <x-buscar-horarios/>
    <x-horarios-semestre :horariosSemestres="$horariosSemestres"/>
    <x-horarios-aula :horariosAulas="$horariosAulas"/>
</x-layouts.plantilla>
