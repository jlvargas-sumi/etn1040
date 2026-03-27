<x-layouts.plantilla titulo="Auxiliaturas" meta-descripcion="Meta descipción de Auxiliaturas" nombre-pagina="auxiliar-auxiliaturas">
    <span class="titulo">Auxiliaturas</span>
    <x-usuario.auxiliar.auxiliaturas.buscar :periodo=$periodo :gestion=$gestion/>
    @isset($asignaturas[0])
        <div class="titulo-formal subtitulo">Asignaturas dictadas {{ $periodo }}-{{ $gestion }}</div>
        <x-usuario.auxiliar.auxiliaturas.datos-auxiliar :auxiliar="$auxiliar" :periodo="$periodo" :gestion="$gestion"/>
        <x-usuario.auxiliar.auxiliaturas.asignaturas :asignaturas="$asignaturas" :periodo="$periodo" :gestion="$gestion"/>
    @else
        <x-layouts.mensaje-contenido tipo-mensaje='advertencia'>Aún no tiene asignaturas habilitadas para el periodo {{ $periodo }}-{{ $gestion }}.</x-layouts.mensaje-contenido>
    @endisset
</x-layouts.plantilla>