<x-layouts.plantilla titulo="Ponderaciones Auxiliatura" meta-descripcion="Meta descipción de Ponderaciones de Auxiliatura" nombre-pagina="auxiliar-ponderaciones">
    <x-usuario.auxiliar.auxiliaturas.tipos tipo="Ponderaciones" :aperturaId=$aperturaId :periodo=$periodo :gestion=$gestion/>
    <span class="titulo">Ponderaciones de Auxiliatura 
        <strong>
            "{{$asignatura->asignatura_sigla}}{{mb_strtoupper($asignatura->apertura_campo, "UTF-8") == "TEORÍA" ? "":" (L)"}}"
        </strong>
    </span>
    <x-usuario.auxiliar.auxiliaturas.ponderaciones.resultado :asignatura=$asignatura :aperturas=$aperturas :aperturaId=$aperturaId :periodo=$periodo :gestion=$gestion/>
</x-layouts.plantilla>