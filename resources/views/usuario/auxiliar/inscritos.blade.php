<x-layouts.plantilla titulo="Inscritos de Auxiliatura" meta-descripcion="Meta descipción de Inscritos de Auxiliatura" nombre-pagina="auxiliar-inscritos">
    <x-usuario.auxiliar.auxiliaturas.tipos tipo="Inscritos" :aperturaId=$aperturaId :periodo=$periodo :gestion=$gestion/>
    <span class="titulo">Inscritos
        <strong>
            "{{$asignatura->asignatura_sigla}}{{mb_strtoupper($asignatura->apertura_campo, "UTF-8") == "TEORÍA" ? "":" (L)"}}"
        </strong>
        <a href="{{ route('auxiliar.inscritos.exportar-pdf', [$aperturaId, $periodo, $gestion]) }}" class="btn-small waves-effect waves-light" target="_blank" title="Lista de inscritos PDF">
            <span class="contenedor-icono"><span>Exportar</span><i class="material-icons derecha">picture_as_pdf</i></span>
        </a>
    </span>
    <x-usuario.auxiliar.auxiliaturas.inscritos.resultado 
        :asignatura=$asignatura :auxiliar=$auxiliar :inscritos=$inscritos 
        :aperturaId=$aperturaId :periodo=$periodo :gestion=$gestion/>
</x-layouts.plantilla>