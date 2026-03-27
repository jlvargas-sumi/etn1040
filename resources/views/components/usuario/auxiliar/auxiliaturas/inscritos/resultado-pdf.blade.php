<h4 id="titulo-principal">
    LISTA DE ESTUDIANTES INSCRITOS (AUXILIATURA)
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

<table class="centro">
    <thead class="fondo-gris">
        <tr>
            <th>Nro</th>
            <th>Ap. Paterno</th>
            <th>Ap. Materno</th>
            <th>Nombres</th>
            <th>Correo</th>
            <th>Celular</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($inscritos as $i => $inscrito)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $inscrito->persona_primer_apellido }}</td>
                <td>{{ $inscrito->persona_segundo_apellido }}</td>
                <td>{{ $inscrito->persona_nombres }}</td>
                <td>{{ $inscrito->correo_direccion }}</td>
                <td>{{ $inscrito->celular_numero }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="firma">
    <span>FIRMA DE AUXILIAR</span>
    <span>V.B. DIRECTOR DE CARRERA</span>
</div>