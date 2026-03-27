<div class="tabla">
    <table id="tabla">
        <thead>
            <tr>
                <th>N°</th>
                <th>Semestre</th>
                <th>Sigla</th>
                <th>Nombre</th>
                <th>Teoría</th>
                <th>Laboratorio</th>
                <th>Auxiliatura</th>
                <th>Prerrequisito</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($asignaturas as $i => $asignatura)
                <tr>
                    <td>{{$i+1}}</td>
                    <td>{{$asignatura->semestre_numerico}}</td>
                    <td>{{$asignatura->asignatura_sigla}}</td>
                    <td>{{$asignatura->asignatura_nombre}}</td>
                    <td><i class="material-icons {{$asignatura->asignatura_teoria == 1 ? "teal":"red"}}-text">{{$asignatura->asignatura_teoria == 1 ? "check":"close"}}</i></td>
                    <td><i class="material-icons {{$asignatura->asignatura_laboratorio == 1 ? "teal":"red"}}-text">{{$asignatura->asignatura_laboratorio == 1 ? "check":"close"}}</i></td>
                    <td><i class="material-icons {{$asignatura->asignatura_auxiliatura == 1 ? "teal":"red"}}-text">{{$asignatura->asignatura_auxiliatura == 1 ? "check":"close"}}</i></td>
                    <td>{{empty($asignatura->vista_asignatura_sigla) ? $asignatura->vista_comentario:$asignatura->vista_asignatura_sigla}}</td>
                    <td class="flex f-jcc">
                        @if (!$asignatura->asignatura_proteccion)
                            <a href="#modal-editar-asignatura" title="Editar Asignatura" class="btn-celeste editar-asignatura modal-trigger" 
                                data-id="{{ $asignatura->asignatura_id }}" 
                                data-sigla="{{ $asignatura->asignatura_sigla }}" 
                                data-asignatura="{{ $asignatura->asignatura_nombre }}"
                                data-laboratorio="{{ $asignatura->asignatura_laboratorio }}"
                                data-auxiliatura="{{ $asignatura->asignatura_auxiliatura }}"
                                >
                                <span class="contenedor-icono"><i class="material-icons">edit</i></span></a>
                            <a href="#modal-eliminar-asignatura" title="Eliminar Asignatura" class="btn-rojo eliminar-asignatura modal-trigger" 
                                data-id="{{ $asignatura->asignatura_id }}" 
                                data-sigla="{{ $asignatura->asignatura_sigla }}"
                                data-asignatura="{{ $asignatura->asignatura_nombre }}" 
                                >
                                <span class="contenedor-icono"><i class="material-icons">delete</i></span></a>
                        @else
                            <span class="contenedor-icono" title="Restringido"><i class="material-icons red-text">block</i></span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<x-usuario.administrador.carrera.asignaturas.editar :mencionId=$mencionId :planEstudiosId=$planEstudiosId :planesEstudios=$planesEstudios />
<x-usuario.administrador.carrera.asignaturas.eliminar :mencionId=$mencionId :planEstudiosId=$planEstudiosId />
