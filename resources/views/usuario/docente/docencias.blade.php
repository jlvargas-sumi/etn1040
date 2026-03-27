<x-layouts.plantilla titulo="Docencias" meta-descripcion="Meta descipción de Docencias" nombre-pagina="docente-docencias">
    <span class="titulo">Docencias</span>
    <x-usuario.docente.docencias.buscar :periodo=$periodo :gestion=$gestion/>
    @isset($asignaturas[0])
        <div class="titulo-formal subtitulo">Asignaturas dictadas {{ $periodo }}-{{ $gestion }}</div>
        <x-usuario.docente.docencias.datos-docente :docente="$docente" :periodo="$periodo" :gestion="$gestion"/>
        <x-usuario.docente.docencias.asignaturas :asignaturas="$asignaturas" :periodo="$periodo" :gestion="$gestion"/>
    @else
        <x-layouts.mensaje-contenido tipo-mensaje='advertencia'>Aún no tiene asignaturas habilitadas para el periodo {{ $periodo }}-{{ $gestion }}.</x-layouts.mensaje-contenido>
    @endisset
</x-layouts.plantilla>