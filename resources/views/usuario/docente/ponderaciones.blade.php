<x-layouts.plantilla titulo="Ponderaciones Docencia" meta-descripcion="Meta descipción de Ponderaciones de Docencia" nombre-pagina="docente-ponderaciones">
    <x-usuario.docente.docencias.tipos tipo="Ponderaciones" :aperturaId=$aperturaId :periodo=$periodo :gestion=$gestion/>
    <span class="titulo">Ponderaciones de Docencia 
        <strong>
            "{{$asignatura->asignatura_sigla}}{{mb_strtoupper($asignatura->apertura_campo, "UTF-8") == "TEORÍA" ? "":" (L)"}}"
        </strong>
    </span>
    <x-usuario.docente.docencias.ponderaciones.resultado :asignatura=$asignatura :aperturas=$aperturas :aperturaId=$aperturaId :periodo=$periodo :gestion=$gestion/>
</x-layouts.plantilla>