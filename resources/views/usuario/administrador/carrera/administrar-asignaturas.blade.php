<x-layouts.plantilla titulo="Administrar Asignaturas" meta-descripcion="Meta descripción de Administrar Asignaturas" nombre-pagina="administrador-asignaturas">
    <span class="titulo">Administrar Asignaturas</span>
    <x-usuario.administrador.carrera.asignaturas.crear :asignaturas=$asignaturas :asignaturasGeneral=$asignaturasGeneral :semestres=$semestres :menciones=$menciones :mencionId=$mencionId :planesEstudios=$planesEstudios :planEstudiosId=$planEstudiosId />
    <x-usuario.administrador.carrera.asignaturas.buscar :menciones=$menciones :mencionId=$mencionId :planesEstudios=$planesEstudios :planEstudiosId=$planEstudiosId />
    <x-usuario.administrador.carrera.asignaturas.resultado :asignaturas=$asignaturas :menciones=$menciones :mencionId=$mencionId :planesEstudios=$planesEstudios :planEstudiosId=$planEstudiosId/>
    <x-usuario.administrador.carrera.asignaturas.agregar :asignaturasGeneral=$asignaturasGeneral :semestres=$semestres :mencionId=$mencionId :planEstudiosId=$planEstudiosId/>
</x-layouts.plantilla>
