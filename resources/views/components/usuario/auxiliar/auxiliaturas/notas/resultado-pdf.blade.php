<h4 id="titulo-principal">
    NOTAS DE ESTUDIANTES INSCRITOS (AUXILIATURA)
</h4>

<table class="sin-borde">
    <tbody>
        <tr>
            <td class="nombre-celda">Materia:</td>
            <td>{{ $asignatura->asignatura_nombre }}</td>
            <td class="nombre-celda">Auxiliar:</td>
            <td>{{ $auxiliar->persona_primer_apellido }} {{ $auxiliar->persona_segundo_apellido }} {{ $auxiliar->persona_nombres }}</td>
            <td class="nombre-celda">Gestión:</td>
            <td>{{ $gestion }}</td>
        </tr>
        <tr>
            <td class="nombre-celda">Sigla:</td>
            <td>{{ $asignatura->asignatura_sigla }}</td>
            <td class="nombre-celda">C.I.:</td>
            <td>{{ $auxiliar->persona_ci }}</td>
            <td class="nombre-celda">Periodo:</td>
            <td>{{ $periodo }}</td>
        </tr>
    </tbody>
</table>

<table id="tabla">   
    <thead>
        <tr>
            <th>Nro</th>
            <th class="izquierda fondo-gris">Ap. Paterno</th>
            <th class="izquierda fondo-gris">Ap. Materno</th>
            <th class="izquierda fondo-gris">Nombres</th>
            @foreach ($aperturas as $asignatura)
                @php
                    $campo = "P";
                    $ponderacionPrincipal = $asignatura->auxiliatura_ponderacion['ponderacionPrincipal'];
                    $ponderacionSecundaria = $asignatura->auxiliatura_ponderacion['ponderacionSecundaria'];
                @endphp
                @foreach ($asignatura->auxiliatura_ponderacion['ponderacionesPrincipal'] as $i => $ponderacion)
                    <th>{{ $campo }}{{ $i }}</th>
                @endforeach
                <th class="grey darken-1 centro fondo-gris white-text">Total {{ $campo }}</th>
                @foreach ($asignatura->auxiliatura_ponderacion['ponderacionesSecundaria'] as $i => $ponderacion)
                    <th>A{{ $i }}</th>
                @endforeach
                <th class="grey darken-1 centro fondo-gris white-text">Total A</th>
                <th class="grey darken-3 centro fondo-gris white-text">Total</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($inscritosTeoria as $i => $inscrito)
            <tr>
                <td class="centro">{{ $i+1 }}</td>
                <td class="fondo-gris">{{ $inscrito->persona_primer_apellido }}</td>
                <td class="fondo-gris">{{ $inscrito->persona_segundo_apellido }}</td>
                <td class="fondo-gris">{{ $inscrito->persona_nombres }}</td>
                @foreach ($aperturas as $j => $asignatura)
                    @php
                        $campo = mb_strtoupper($asignatura->apertura_campo, "UTF-8") == "TEORÍA" ? "teoria":"laboratorio";
                        $inscripcionId = mb_strtoupper($asignatura->apertura_campo, "UTF-8") == "TEORÍA" ? $inscrito->inscripcion_id:$inscritosLaboratorio[$i]->inscripcion_id;
                        $notas = mb_strtoupper($asignatura->apertura_campo, "UTF-8") == "TEORÍA" ? $inscrito->inscripcion_nota_auxiliatura:$inscritosLaboratorio[$i]->inscripcion_nota_auxiliatura;
                        
                        $totalP = 0;
                        $totalS = 0;
                    @endphp
                    @foreach ($asignatura->auxiliatura_ponderacion['ponderacionesPrincipal'] as $k => $ponderacion)
                        @php
                            $nota = $notas['notaPrincipal'];
                            $nota = $nota == null ? 0:($nota[$k-1] ?? 0);

                            $notaParcial = number_format($nota * $ponderacion / 100, 1);
                            $totalP += $notaParcial;
                            $totalPParcial = number_format($totalP * $ponderacionPrincipal / 100, 1);
                        @endphp
                        <td class="centro">
                            {{ $nota }}
                        </td>
                    @endforeach
                    <td class="centro fondo-gris"><strong>{{ $totalPParcial }}</strong></td> 
                    @foreach ($asignatura->auxiliatura_ponderacion['ponderacionesSecundaria'] as $k => $ponderacion)
                        @php
                            $nota = $notas['notaSecundaria'];
                            $nota = $nota == null ? 0:($nota[$k-1] ?? 0);

                            $notaParcial = number_format($nota * $ponderacion / 100, 1);
                            $totalS += $notaParcial;
                            $totalSParcial = number_format($totalS * $ponderacionSecundaria / 100, 1);
                        @endphp
                        <td class="centro">
                            {{ $nota }}
                        </td>
                    @endforeach
                    <td class="centro fondo-gris"><strong>{{ $totalSParcial }}</strong></td>
                    <td class="centro fondo-gris"><strong>{{ $totalPParcial + $totalSParcial }}</strong></td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
Ponderaciones %
@foreach ($aperturas as $asignatura)
    <table class="ponderaciones">
        <tbody>
            @php
                $campo = "P";
                $ponderacionPrincipal = $asignatura->auxiliatura_ponderacion['ponderacionPrincipal'];
                $ponderacionSecundaria = $asignatura->auxiliatura_ponderacion['ponderacionSecundaria'];
            @endphp
            <tr>
                @foreach ($asignatura->auxiliatura_ponderacion['ponderacionesPrincipal'] as $i => $ponderacion)
                    <th class="centro">{{ $campo }}{{ $i }}</th>
                @endforeach
                <th class="grey darken-1 centro fondo-gris white-text">Total {{ $campo }}</th>
                @foreach ($asignatura->auxiliatura_ponderacion['ponderacionesSecundaria'] as $i => $ponderacion)
                    <th class="centro">A{{ $i }}</th>
                @endforeach
                <th class="grey darken-1 centro fondo-gris white-text">Total A</th>
                <th class="grey darken-3 centro fondo-gris white-text">Total</th>
            </tr>
            <tr>
                @foreach ($asignatura->auxiliatura_ponderacion['ponderacionesPrincipal'] as $i => $ponderacion)
                    <td class="centro">{{ $ponderacion }}</td>
                @endforeach
                <td class="grey darken-1 centro fondo-gris white-text"><strong>{{ $ponderacionPrincipal }}</strong></td>
                @foreach ($asignatura->auxiliatura_ponderacion['ponderacionesSecundaria'] as $i => $ponderacion)
                    <td class="centro">{{ $ponderacion }}</td>
                @endforeach
                <td class="grey darken-1 centro fondo-gris white-text"><strong>{{ $ponderacionSecundaria }}</strong></td>
                <td class="grey darken-3 centro fondo-gris white-text"><strong>100</strong></td>
            </tr>
        </tbody>
    </table>
@endforeach
<div class="firma">
    <span>FIRMA DE AUXILIAR</span>
    <span>V.B. DIRECTOR DE CARRERA</span>
</div>