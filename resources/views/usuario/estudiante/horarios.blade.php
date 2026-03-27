<x-layouts.plantilla titulo="Inscripción de Mis Horarios" meta-descripcion="Meta descripción de Mis Horarios" nombre-pagina="estudiante-horarios">
    <span class="titulo">Mis Horarios</span>
    <x-usuario.estudiante.horarios.buscar :periodo=$periodo :gestion=$gestion/>
    @isset($horarios[0])
        <x-usuario.estudiante.horarios.datos-estudiante :estudiante="$estudiante" :periodo="$periodo" :gestion="$gestion"/>
        <x-usuario.estudiante.horarios.mostrar-horarios :horarios="$horarios" :periodo="$periodo" :gestion="$gestion"/>
    @else
        <x-layouts.mensaje-contenido tipo-mensaje='advertencia'>Aún no tiene horarios establecidos para el periodo {{ $periodo }}-{{ $gestion }}.</x-layouts.mensaje-contenido>
    @endisset
</x-layouts.plantilla>