<div class="tabla">
    <table class="centered tabla-formal">
        <thead>
            <tr>
                <th>N°</th>
                <th>Semestre</th>
                <th>Sigla</th>
                <th>Asignatura</th>
                <th>Paralelo</th>
                <th>Fecha de inscripción</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 0;
            @endphp
            @foreach ($asignaturas as $asignatura)
                @php
                    $i++;
                @endphp
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $asignatura->semestre_numerico }}</td>
                    <td>{{ $asignatura->asignatura_sigla }} {{$asignatura->apertura_campo == 'Laboratorio' ? "(L)":""}}</td>
                    <td>{{ $asignatura->asignatura_nombre }} {{$asignatura->apertura_campo == 'Laboratorio' ? "(".strtoupper($asignatura->apertura_campo).")":""}}</td>
                    <td>{{ $asignatura->apertura_paralelo }}</td>
                    <td>{{ $asignatura->inscripcion_fecha }}</td>
                    <td>
                        @if ($estadoInscripcion == 1)
                            <a href="#inscripciones-eliminar" title="Eliminar" class="modal-trigger eliminar-inscripcion" data-sigla="{{$asignatura->asignatura_sigla}} {{$asignatura->apertura_campo == 'Laboratorio' ? "(L)":""}}" data-id="{{$asignatura->inscripcion_id}}">
                                <i class="material-icons btn-rojo">delete</i>
                            </a>
                        @else
                            <span class="mensaje-error">Cerrado</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="7">
                    <form action="{{route('estudiante.inscripciones.boleta-pdf')}}" method="POST" target="_blank">
                    @csrf
                        <input type="hidden" name="id" value="{{$asignaturas[0]->periodo_id}}">
                        <button type="submit" class="btn-small waves-effect waves-light blue">
                            Boleta de Inscripción
                            <i class="material-icons right">picture_as_pdf</i>
                        </button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div id="inscripciones-eliminar" class="modal">
    <div class="modal-content center">
        <h4>Eliminar materia inscrita: <strong></strong></h4>
        <form action="{{route('estudiante.inscripciones.eliminar')}}" method="POST">
            @csrf
            <input type="hidden" name="id" required>
            <div>
                <button type="submit" class="btn-small waves-effect waves-light teal">Eliminar</button>
                <button type="reset" class="btn-small modal-close waves-effect waves-light red">Cancelar</button>
            </div>
        </form>
    </div>
</div>