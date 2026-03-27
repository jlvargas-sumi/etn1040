<x-layouts.plantilla titulo="Inscripciones" meta-descripcion="Meta descripción de Inscripciones" nombre-pagina="estudiante-inscripciones">
    @if ($estadoInscripcion !== 1)
        <x-layouts.mensaje-contenido tipo-mensaje="advertencia">Periodo de Inscripciones cerrado.</x-layouts.mensaje-contenido>
    @endif
    <span class="titulo">Inscripciones</span><br>
    <x-usuario.estudiante.inscripciones.buscar :periodo=$periodo :gestion=$gestion />
    
    <span class="subtitulo">Asignaturas inscritas</span>
    @isset($asignaturasInscritas[0])
        <x-usuario.estudiante.inscripciones.asignaturas-inscritas :estadoInscripcion=$estadoInscripcion :asignaturas=$asignaturasInscritas/>
    @else
        <x-layouts.mensaje-contenido tipo-mensaje='informacion'>Aún no tiene asignaturas inscritas para el periodo {{ $periodo }}-{{ $gestion }}.</x-layouts.mensaje-contenido>
    @endisset

    @if ($estadoInscripcion === 1)
        <span class="subtitulo">Asignaturas habilitadas</span>
        @isset($asignaturasHabilitadas[0])
            <x-usuario.estudiante.inscripciones.asignaturas-habilitadas :asignaturas=$asignaturasHabilitadas :paralelos=$paralelos :periodo=$periodo :gestion=$gestion/>
        @else
            <x-layouts.mensaje-contenido tipo-mensaje="advertencia">Aún no se tienen asignaturas habilitadas.</x-layouts.mensaje-contenido>
        @endif
    @endif
</x-layouts.plantilla>