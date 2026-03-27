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

    $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
    $horaInicio = Carbon::createFromTime(7, 0);
    $horaFin = Carbon::createFromTime(21, 0);
    $intervalo = 15; // minutos
    $horas = [];
    while ($horaInicio < $horaFin) {
        $horaFinIntervalo = $horaInicio->copy()->addMinutes($intervalo)->format('H:i');
        $horas[] = [
            'inicio' => $horaInicio->format('H:i'),
            'fin' => $horaFinIntervalo
        ];
        $horaInicio->addMinutes($intervalo);
    }

    // Agrupar materias por día y hora (cada celda puede tener varias materias)
    $materiasPorDiaHora = [];
    $maxChoquesPorDia = [];
    foreach ($dias as $dia) {
        $maxChoquesPorDia[$dia] = 1;
        foreach ($horas as $h) {
            $materiasPorDiaHora[$dia][$h['inicio']] = [];
        }
    }
    foreach ($horarios as $horario) {
        $diaHorario = ucfirst(strtolower($horario->dia));
        $inicio = Carbon::parse($horario->hora_inicio)->format('H:i');
        $fin = Carbon::parse($horario->hora_fin)->format('H:i');
        foreach ($horas as $h) {
            if ($h['inicio'] >= $inicio && $h['inicio'] < $fin && $diaHorario == ucfirst(strtolower($horario->dia))) {
                $materiasPorDiaHora[$diaHorario][$h['inicio']][] = $horario;
                $maxChoquesPorDia[$diaHorario] = max($maxChoquesPorDia[$diaHorario], count($materiasPorDiaHora[$diaHorario][$h['inicio']]));
            }
        }
    }

    // Para cada materia, calcular en qué intervalo inicia y cuántos intervalos ocupa (para rowspan)
    $rowspanMatrix = [];
    foreach ($dias as $dia) {
        foreach ($horas as $i => $h) {
            foreach ($materiasPorDiaHora[$dia][$h['inicio']] as $idx => $materia) {
                $inicio = Carbon::parse($materia->hora_inicio)->format('H:i');
                $fin = Carbon::parse($materia->hora_fin)->format('H:i');
                $startIndex = array_search($inicio, array_column($horas, 'inicio'));
                $endIndex = array_search($fin, array_column($horas, 'inicio'));
                if ($startIndex === false) $startIndex = 0;
                if ($endIndex === false) $endIndex = count($horas);
                $rowspanMatrix[$dia][$inicio][$idx] = $endIndex - $startIndex;
            }
        }
    }

    // Control de materias ya impresas para rowspan
    $printed = [];
@endphp
<form action="{{route('estudiante.horarios.pdf')}}" method="POST" target="_blank">
@csrf
    <input type="hidden" name="id" value="{{$horarios[0]->periodo_id}}">
    <button type="submit" class="btn-small waves-effect waves-light blue">
        Horarios PDF
        <i class="material-icons right">picture_as_pdf</i>
    </button>
</form>
<div class="tabla-sss">
    <table class="tabla-borde tabla-horarios">
        <thead>
            <tr>
                <th>Hora</th>
                @foreach ($dias as $dia)
                    <th colspan="{{ $maxChoquesPorDia[$dia] }}">{{ $dia }}</th>
                @endforeach
            </tr>
            {{-- <tr>
                <th></th>
                @foreach ($dias as $dia)
                    @for ($i = 0; $i < $maxChoquesPorDia[$dia]; $i++)
                        <th> </th>
                    @endfor
                @endforeach
            </tr> --}}
        </thead>
        <tbody>
            @foreach ($horas as $i => $h)
                <tr>
                    <td class="hora">{{ $h['inicio'] }} - {{ $h['fin'] }}</td>
                    @foreach ($dias as $dia)
                        @for ($col = 0; $col < $maxChoquesPorDia[$dia]; $col++)
                            @php
                                $materias = $materiasPorDiaHora[$dia][$h['inicio']];
                                $materia = $materias[$col] ?? null;
                                $imprimir = true;
                                if ($materia) {
                                    $inicioMateria = Carbon::parse($materia->hora_inicio)->format('H:i');
                                    $idx = array_search($materia, $materiasPorDiaHora[$dia][$inicioMateria]);
                                    if (isset($printed[$dia][$inicioMateria][$idx]) && $printed[$dia][$inicioMateria][$idx] > 0) {
                                        $imprimir = false;
                                        $printed[$dia][$inicioMateria][$idx]--;
                                    } else {
                                        $rowspan = $rowspanMatrix[$dia][$inicioMateria][$idx] ?? 1;
                                        $printed[$dia][$inicioMateria][$idx] = $rowspan - 1;
                                    }
                                }
                            @endphp
                            @if ($materia && $imprimir)
                                <td class="horario" rowspan="{{ $rowspan }}">
                                    <strong>{{ $materia->asignatura_sigla }}</strong><br>
                                    {{ $materia->asignatura_nombre }}<br>
                                    {{-- {{ $materia->clase }}<br> --}}
                                    {{ $materia->profesor }}<br>
                                    Aula: {{ $materia->aula_nombre }}
                                </td>
                            @elseif (!$materia)
                                <td></td>
                            @endif
                        @endfor
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>