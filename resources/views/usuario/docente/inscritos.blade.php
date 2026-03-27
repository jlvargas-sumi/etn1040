<x-layouts.plantilla titulo="Inscritos de Docencia" meta-descripcion="Meta descipción de Inscritos de Docencia" nombre-pagina="docente-inscritos">
    <x-usuario.docente.docencias.tipos tipo="Inscritos" :aperturaId=$aperturaId :periodo=$periodo :gestion=$gestion/>
    <span class="titulo">Inscritos
        <strong>
            "{{$asignatura->asignatura_sigla}}{{mb_strtoupper($asignatura->apertura_campo, "UTF-8") == "TEORÍA" ? "":" (L)"}}"
        </strong>
        <a href="{{ route('docente.inscritos.exportar-pdf', [$aperturaId, $periodo, $gestion]) }}" class="btn-small waves-effect waves-light" target="_blank" title="Lista de inscritos PDF">
            <span class="contenedor-icono"><span>Exportar</span><i class="material-icons derecha">picture_as_pdf</i></span>
        </a>
    </span>
    <x-usuario.docente.docencias.inscritos.resultado 
        :asignatura=$asignatura :docente=$docente :inscritos=$inscritos 
        :aperturaId=$aperturaId :periodo=$periodo :gestion=$gestion/>
</x-layouts.plantilla>