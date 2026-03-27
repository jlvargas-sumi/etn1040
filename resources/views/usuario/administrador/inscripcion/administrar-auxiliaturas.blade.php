<x-layouts.plantilla titulo="Administrar Auxiliaturas" meta-descripcion="Meta descripción de Administrar Auxiliaturas" nombre-pagina="administrador-auxiliaturas">
    <span class="titulo">Administrar Auxiliaturas</span>
    <x-usuario.administrador.inscripcion.auxiliaturas.buscar :menciones=$menciones :mencionId=$mencionId :planesEstudios=$planesEstudios :planEstudiosId=$planEstudiosId :periodo=$periodo :gestion=$gestion/>
    <x-usuario.administrador.inscripcion.auxiliaturas.resultado :auxiliaturas=$auxiliaturas :auxiliares=$auxiliares :aulas=$aulas :planEstudiosId=$planEstudiosId :mencionId=$mencionId :periodo=$periodo :gestion=$gestion/>
</x-layouts.plantilla>