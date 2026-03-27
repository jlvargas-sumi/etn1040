<x-layouts.plantilla titulo="Notas Académicas" meta-descripcion="Meta descripción de Notas"
    nombre-pagina="estudiante-notas">
    <span class="titulo">Notas Académicas - Ingeniería Electrónica</span>

    <x-usuario.estudiante.notas.buscar :periodo=$periodo :gestion=$gestion/>
    @isset($notas[0])
        <x-usuario.estudiante.notas.datos-estudiante :estudiante="$estudiante" :periodo="$periodo" :gestion="$gestion"/>
        <x-usuario.estudiante.notas.mostrar-notas :notas="$notas" :periodo="$periodo" :gestion="$gestion"/>
    @else
        <x-layouts.mensaje-contenido tipo-mensaje='advertencia'>Aún no tiene asignaturas inscritas para el periodo {{ $periodo }}-{{ $gestion }}.</x-layouts.mensaje-contenido>
    @endisset
</x-layouts.plantilla>
