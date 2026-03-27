{{-- @dump($horarios) --}}
@if (count($horarios) > 0)
    <div class="tabla">
        <table id="tabla">
            <thead class="table-light text-center align-middle">
                <tr>
                    <th>Asignatura</th>
                    <th>Clase</th>
                    <th>Teoría/Lab.</th>
                    <th>Paralelo</th>
                    <th>Doc./Aux.</th>
                    <th>Día</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                    <th>Aula</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($horarios as $horario)
                    <tr class="text-center align-middle">
                        <td>{{ $horario->asignatura_sigla }} - {{ $horario->asignatura_nombre }}</td>
                        <td>{{ $horario->clase }}</td>
                        <td>{{ $horario->apertura_campo }}</td>
                        <td>{{ $horario->apertura_paralelo }}</td>
                        <td>{{ $horario->profesor }}</td>
                        <td>{{ $horario->dia }}</td>
                        <td>{{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') }}</td>
                        <td>{{ $horario->aula_nombre }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@php
    use Carbon\Carbon;

    $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
    $horaInicio = Carbon::createFromTime(7, 0);
    $horaFin = Carbon::createFromTime(21, 0);
    $intervalo = 15; // minutos
    $horas = [];
    while ($horaInicio <= $horaFin) {
        $horas[] = $horaInicio->format('H:i');
        $horaInicio->addMinutes($intervalo);
    }

    // Preprocesar los horarios para cada día y hora
    $horariosPorDiaHora = [];
    foreach ($dias as $dia) {
        foreach ($horas as $hora) {
            $horariosPorDiaHora[$dia][$hora] = null;
        }
    }
    foreach ($horarios as $horario) {
        $diaHorario = ucfirst(strtolower($horario->dia));
        $inicio = Carbon::parse($horario->hora_inicio)->format('H:i');
        $fin = Carbon::parse($horario->hora_fin)->format('H:i');
        $startIndex = array_search($inicio, $horas);
        $endIndex = array_search($fin, $horas);
        if ($startIndex !== false && $endIndex !== false) {
            for ($i = $startIndex; $i < $endIndex; $i++) {
                $horariosPorDiaHora[$diaHorario][$horas[$i]] = [
                    'horario' => $horario,
                    'start' => $inicio,
                    'rowspan' => $endIndex - $startIndex,
                    'isFirst' => $i == $startIndex
                ];
            }
        }
    }
@endphp

<div class="tabla-sss">
    <table class="table table-bordered text-center align-middle">
        <thead>
            <tr>
                <th>Hora</th>
                @foreach ($dias as $dia)
                    <th>{{ $dia }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($horas as $i => $hora)
                @php
                $horaFinIntervalo = isset($horas[$i + 1]) ? $horas[$i + 1] : \Carbon\Carbon::createFromFormat('H:i', $hora)->addMinutes(15)->format('H:i');
            @endphp
                <tr>
                    <td>{{ $hora }} - {{ $horaFinIntervalo }}</td>
                    @foreach ($dias as $dia)
                        @php
                            $cell = $horariosPorDiaHora[$dia][$hora] ?? null;
                        @endphp
                        @if ($cell && $cell['isFirst'])
                            <td rowspan="{{ $cell['rowspan'] }}">
                                <strong>{{ $cell['horario']->asignatura_sigla }}</strong><br>
                                {{ $cell['horario']->asignatura_nombre }}<br>
                                {{ $cell['horario']->clase }}<br>
                                {{ $cell['horario']->profesor }}<br>
                                Aula: {{ $cell['horario']->aula_nombre }}
                            </td>
                        @elseif ($cell && !$cell['isFirst'])
                            {{-- No renderizar celda, ya que está combinada --}}
                        @else
                            <td></td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>