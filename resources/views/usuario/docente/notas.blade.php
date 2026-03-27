<x-layouts.plantilla titulo="Notas de Docencia" meta-descripcion="Meta descipción de Notas de Docencia" nombre-pagina="docente-notas">
    <x-usuario.docente.docencias.tipos tipo="Notas" :aperturaId=$aperturaId :periodo=$periodo :gestion=$gestion/>
    <span class="titulo">Notas de Docencia 
        <strong>
            "{{$asignatura->asignatura_sigla}}{{mb_strtoupper($asignatura->apertura_campo, "UTF-8") == "TEORÍA" ? "":" (L)"}}"
        </strong>
        <a href="{{ route('docente.notas.exportar-pdf', [$aperturaId, $periodo, $gestion]) }}" class="btn-small waves-effect waves-light" target="_blank" title="Notas de inscritos PDF">
            <span class="contenedor-icono"><span>Exportar</span><i class="material-icons derecha">picture_as_pdf</i></span>
        </a>
    </span>
    <x-usuario.docente.docencias.notas.resultado 
        :asignatura=$asignatura :aperturas=$aperturas :docente=$docente :inscritosTeoria=$inscritosTeoria :inscritosLaboratorio=$inscritosLaboratorio 
        :aperturaId=$aperturaId :periodo=$periodo :gestion=$gestion/>
</x-layouts.plantilla>