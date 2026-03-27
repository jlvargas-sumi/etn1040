<x-usuario.estudiante.notas.datos-estudiante :estudiante="$inscritoTeoria" :periodo="$periodo" :gestion="$gestion"/>
@foreach ($aperturas as $asignatura)
    @php
        $campo = mb_strtoupper($asignatura->apertura_campo, "UTF-8") == "TEORÍA" ? "E":"L";
        $campo = $asignatura->catedra == "Docencia" ? $campo:"P";
        $ponderacionPrincipal = $asignatura->ponderacion['ponderacionPrincipal'];
        $ponderacionSecundaria = $asignatura->ponderacion['ponderacionSecundaria'];
    @endphp
    <div class="tabla">
        <table><span class="subtitulo">{{ $asignatura->apertura_campo }} ({{ $asignatura->grado }} {{ $asignatura->persona_nombres }} {{ $asignatura->persona_primer_apellido }} {{ $asignatura->persona_segundo_apellido }})</span>
            <thead>
                <tr>
                    @foreach ($asignatura->ponderacion['ponderacionesPrincipal'] as $i => $ponderacion)
                        <th>{{ $campo }}{{ $i }}<span>({{ $ponderacion }}%)</span></th>
                    @endforeach
                        <th class="grey darken-1 center white-text">Total {{ $campo }}({{ $ponderacionPrincipal }}%)</th>
                    @foreach ($asignatura->ponderacion['ponderacionesSecundaria'] as $i => $ponderacion)
                        <th>A{{ $i }}<span>({{ $ponderacion }}%)</span></th>
                    @endforeach
                    <th class="grey darken-1 center white-text">Total A({{ $ponderacionSecundaria }}%)</th>
                    <th class="grey darken-3 center white-text">Total(100%)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @php
                        $notas = mb_strtoupper($asignatura->apertura_campo[0], "UTF-8") == "T" ? $inscritoTeoria->inscripcion_nota_docencia:$inscritoLaboratorio->inscripcion_nota_docencia;
                        $notasAux = mb_strtoupper($asignatura->apertura_campo[0], "UTF-8") == "T" ? $inscritoTeoria->inscripcion_nota_auxiliatura:$inscritoLaboratorio->inscripcion_nota_auxiliatura;
                        $notas = $asignatura->catedra == "Docencia" ? $notas:$notasAux;
                        $totalP = 0;
                        $totalS = 0;
                    @endphp
                    @foreach ($asignatura->ponderacion['ponderacionesPrincipal'] as $k => $ponderacion)
                        @php
                            $nota = $notas['notaPrincipal'];
                            $nota = $nota == null ? 0:($nota[$k-1] ?? 0);
                            $notaParcial = number_format($nota * $ponderacion / 100, 1);
                            $totalP += $notaParcial;
                            $totalPParcial = number_format($totalP * $ponderacionPrincipal / 100, 1);
                        @endphp
                        <td>{{ $nota }}({{ $notaParcial }})</td>
                    @endforeach
                        <td class="center"><strong>{{ $totalP }}({{ $totalPParcial }})</strong></td>                    
                    @foreach ($asignatura->ponderacion['ponderacionesSecundaria'] as $k => $ponderacion)
                        @php
                            $nota = $notas['notaSecundaria'];
                            $nota = $nota == null ? 0:($nota[$k-1] ?? 0);
                            $notaParcial = number_format($nota * $ponderacion / 100, 1);
                            $totalS += $notaParcial;
                            $totalSParcial = number_format($totalS * $ponderacionSecundaria / 100, 1);
                        @endphp
                        <td>{{ $nota }}({{ $notaParcial }})</td>
                    @endforeach
                    <td class="center"><strong>{{ $totalS }}({{ $totalSParcial }})</strong></td>
                    <td class="center"><strong>{{ $totalPParcial + $totalSParcial }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div class="tabla">
@endforeach
