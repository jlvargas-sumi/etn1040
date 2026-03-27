<x-layouts.plantilla titulo="Administrar Docencias" meta-descripcion="Meta descripción de Administrar Docencias" nombre-pagina="administrador-docencias">
    <span class="titulo">Administrar Docencias</span>
    <x-usuario.administrador.inscripcion.docencias.buscar :menciones=$menciones :mencionId=$mencionId :planesEstudios=$planesEstudios :planEstudiosId=$planEstudiosId :periodo=$periodo :gestion=$gestion/>
    <x-usuario.administrador.inscripcion.docencias.resultado :docencias=$docencias :docentes=$docentes :aulas=$aulas  :planEstudiosId=$planEstudiosId :mencionId=$mencionId :periodo=$periodo :gestion=$gestion/>
</x-layouts.plantilla>