<x-layouts.plantilla titulo="Administrar Aperturas" meta-descripcion="Meta descripción de Administrar Aperturas" nombre-pagina="administrador-aperturas">
    <span class="titulo">Administrar Aperturas</span>
    <x-usuario.administrador.inscripcion.aperturas.buscar :menciones=$menciones :mencionId=$mencionId :planesEstudios=$planesEstudios :planEstudiosId=$planEstudiosId :periodo=$periodo :gestion=$gestion/>
    <x-usuario.administrador.inscripcion.aperturas.resultado :aperturas=$aperturas :planEstudiosId=$planEstudiosId :mencionId=$mencionId :periodo=$periodo :gestion=$gestion/>
</x-layouts.plantilla>