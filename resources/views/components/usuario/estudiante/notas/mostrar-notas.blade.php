<div class="tabla imprimible">
    <table class="centered tabla-formal">
        <thead>
            <tr>
                <th>N°</th>
                <th>Sigla</th>
                <th>Asignatura</th>
                <th>Paralelo</th>
                <th>Nota Final</th>
                <th>Acción</th>
            </tr>
        </thead>

        <tbody>
            @php
                $i = 0;
            @endphp
            @foreach ($notas as $nota)
                @php
                    $i++;
                @endphp
                <tr>
                    <td>{{ $i }}</td>
                    @if ($nota->apertura_campo[0] == 'L')
                        <td>{{ $nota->asignatura_sigla }} (L)</td>
                        <td>{{ $nota->asignatura_nombre }} ({{ $nota->apertura_campo }})</td>
                    @else
                        <td>{{ $nota->asignatura_sigla }}</td>
                        <td>{{ $nota->asignatura_nombre }}</td>
                    @endif
                    <td>{{ $nota->apertura_paralelo }}</td>
                    <td>{{ $nota->nota_teoria }}</td>
                    <td>
                        <a href="{{route('estudiante.notas.detalle', [$nota->apertura_id, $periodo, $gestion])}}" class="sin-estilo btn-celeste p-5 waves-effect waves-light">
                            <span class="contenedor-icono"><span>Detalles</span><i class="material-icons derecha">view_list</i></span>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>