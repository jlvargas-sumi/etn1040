<form action="{{ route('docente.notas.registrar') }}" method="POST">
    @csrf
    <div class="center">
        <strong class="red-text">Al presionar el botón REGISTRAR NOTAS, está validando las notas desplegadas en la tabla</strong>
        <br>
        <button type="submit" class="btn">Registrar Notas</button>
    </div>
    <input type="hidden" name="apertura_id" value="{{ $aperturaId }}" required>
    <input type="hidden" name="periodo" value="{{ $periodo }}" required>
    <input type="hidden" name="gestion" value="{{ $gestion }}" required>
    <input type="hidden" name="sigla" value="{{ $asignatura->asignatura_sigla }}" required>
    <input type="hidden" name="tipo_catedra" value="docencia" required>
    <div class="tabla">
        <table id="tabla">   
            <thead>
                <tr>
                    <th>Nro</th>
                    <th>Ap. Paterno</th>
                    <th>Ap. Materno</th>
                    <th>Nombres</th>
                    @foreach ($aperturas as $asignatura)
                        @php
                            $campo = mb_strtoupper($asignatura->apertura_campo, "UTF-8") == "TEORÍA" ? "E":"L";
                            $ponderacionPrincipal = $asignatura->docencia_ponderacion['ponderacionPrincipal'];
                            $ponderacionSecundaria = $asignatura->docencia_ponderacion['ponderacionSecundaria'];
                        @endphp
                        @foreach ($asignatura->docencia_ponderacion['ponderacionesPrincipal'] as $i => $ponderacion)
                            <th>{{ $campo }}{{ $i }}({{ $ponderacion }}%)</th>
                        @endforeach
                        <th class="grey darken-1 center white-text">Total {{ $campo }}({{ $ponderacionPrincipal }}%)</th>
                        @foreach ($asignatura->docencia_ponderacion['ponderacionesSecundaria'] as $i => $ponderacion)
                            <th>A{{ $i }}({{ $ponderacion }}%)</th>
                        @endforeach
                        <th class="grey darken-1 center white-text">Total A({{ $ponderacionSecundaria }}%)</th>
                        <th class="grey darken-3 center white-text">Total(100%)</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($inscritosTeoria as $i => $inscrito)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $inscrito->persona_primer_apellido }}</td>
                        <td>{{ $inscrito->persona_segundo_apellido }}</td>
                        <td>{{ $inscrito->persona_nombres }}</td>
                        @foreach ($aperturas as $j => $asignatura)
                            @php
                                $campo = mb_strtoupper($asignatura->apertura_campo, "UTF-8") == "TEORÍA" ? "teoria":"laboratorio";
                                $inscripcionId = mb_strtoupper($asignatura->apertura_campo, "UTF-8") == "TEORÍA" ? $inscrito->inscripcion_id:$inscritosLaboratorio[$i]->inscripcion_id;
                                $notas = mb_strtoupper($asignatura->apertura_campo, "UTF-8") == "TEORÍA" ? $inscrito->inscripcion_nota_docencia:$inscritosLaboratorio[$i]->inscripcion_nota_docencia;
                            
                                $totalP = 0;
                                $totalS = 0;
                            @endphp
                            @foreach ($asignatura->docencia_ponderacion['ponderacionesPrincipal'] as $k => $ponderacion)
                                @php
                                    $nota = $notas['notaPrincipal'];
                                    $nota = $nota == null ? 0:($nota[$k-1] ?? 0);

                                    $notaParcial = number_format($nota * $ponderacion / 100, 1);
                                    $totalP += $notaParcial;
                                    $totalPParcial = number_format($totalP * $ponderacionPrincipal / 100, 1);
                                @endphp
                                <td>
                                    <input type="number" 
                                        name="nota_principal_{{ $campo }}[{{ $inscripcionId }}][]" 
                                        value="{{ $nota }}"
                                        class="validate" min="0" max="100" step="1" >
                                </td>
                            @endforeach
                            <td class="center"><strong>{{ $totalP }}({{ $totalPParcial }})</strong></td>
                            @foreach ($asignatura->docencia_ponderacion['ponderacionesSecundaria'] as $k => $ponderacion)
                                @php
                                    $nota = $notas['notaSecundaria'];
                                    $nota = $nota == null ? 0:($nota[$k-1] ?? 0);

                                    $notaParcial = number_format($nota * $ponderacion / 100, 1);
                                    $totalS += $notaParcial;
                                    $totalSParcial = number_format($totalS * $ponderacionSecundaria / 100, 1);
                                @endphp
                                <td>
                                    <input type="number" 
                                        name="nota_secundaria_{{ $campo }}[{{ $inscripcionId }}][]" 
                                        value="{{ $nota }}"
                                        class="validate" min="0" max="100" step="1" >
                                </td>
                            @endforeach
                            <td class="center"><strong>{{ $totalS }}({{ $totalSParcial }})</strong></td>
                            <td class="center"><strong>{{ $totalPParcial + $totalSParcial }}</strong></td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</form>