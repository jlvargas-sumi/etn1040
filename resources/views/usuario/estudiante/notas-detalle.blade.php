<x-layouts.plantilla titulo="Detalle de Notas" meta-descripcion="Meta descipción de detalle de Notas" 
    nombre-pagina="estudiante-notas-detalle">
    <span class="titulo">Detalle de Notas Académicas 
        <strong>
            "{{$asignatura->asignatura_sigla}}{{mb_strtoupper($asignatura->apertura_campo[0], "UTF-8") == "T" ? "":" (L)"}}"
        </strong>
    </span>
    <a href="{{route('estudiante.notas', [$periodo, $gestion])}}" class="waves-effect waves-light btn-azul m-5 p-5 col s12" title="Volver a Asignaturas"><i class="material-icons left">keyboard_backspace</i>Volver</a>
    <x-usuario.estudiante.notas.detalle 
        :aperturas=$aperturas :inscritoTeoria=$inscritoTeoria :inscritoLaboratorio=$inscritoLaboratorio 
        :aperturaId=$aperturaId :periodo=$periodo :gestion=$gestion/>
</x-layouts.plantilla>