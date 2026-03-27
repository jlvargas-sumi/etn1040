<div class="tabla">
    <table class="centered tabla-formal">
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
                    @if ($asignatura->apertura_campo[0] == 'L')
                        <td>{{ $asignatura->asignatura_sigla }} (L)</td>
                        <td>{{ $asignatura->asignatura_nombre }} ({{ $asignatura->apertura_campo }})</td>
                    @else
                        <td>{{ $asignatura->asignatura_sigla }}</td>
                        <td>{{ $asignatura->asignatura_nombre }}</td>
                    @endif
                    <td>{{ $asignatura->apertura_paralelo }}</td>
                    <td>
                        <a href="{{route('auxiliar.ponderaciones', [$asignatura->apertura_id, $periodo, $gestion])}}" class="sin-estilo btn-azul p-5 waves-effect waves-light">
                            <span class="contenedor-icono"><span>Administrar</span><i class="material-icons derecha">engineering</i></span>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>