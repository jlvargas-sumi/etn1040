<div class="tabla">
    <table class="centered tabla-formal" id="tabla">
        <thead>
            <tr>
                <th>N°</th>
                <th>Semestre</th>
                <th>Sigla</th>
                <th>Asignatura</th>
                <th>Paralelo</th>
                <th>Acción</th>
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
                    <td>
                        <div class="input-field paralelo">
                            <form action="{{ route('estudiante.inscripciones.registrar-inscripcion')}}" method="POST">
                                @csrf
                                <input type="hidden" name="periodo" value="{{$periodo}}" required>
                                <input type="hidden" name="gestion" value="{{$gestion}}" required>
                                <select id="apertura-id" name="apertura_id" required>
                                    @foreach ($paralelos as $paralelo)
                                        @if ($asignatura->asignatura_id == $paralelo->asignatura_id && $asignatura->apertura_campo == $paralelo->apertura_campo)
                                        <option value="{{ $paralelo->apertura_id }}">{{ $paralelo->apertura_paralelo }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('apertura_id')
                                    <span class="helper-text mensaje-error">{{ $message }}</span>
                                @enderror
                        </div>
                    </td>
                    <td>
                            <input type="hidden" name="asignatura" value="{{ $asignatura->asignatura_sigla }} {{ $asignatura->apertura_campo }}" required>
                            <button class="btn btn-xsmall waves-effect waves-light">Inscribirme</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>   
</div>