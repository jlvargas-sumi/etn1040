<h4 id="titulo-principal">
        BOLETA DE REGISTRO DE ASIGNATURAS INSCRITAS
</h4>

<table class="sin-borde">
    <tbody>
        <tr>
            <td class="nombre-celda">R.U.:</td>
            <td>{{ $estudiante->estudiante_ru }}</td>
            <td class="nombre-celda">C.I.:</td>
            <td>{{ $estudiante->persona_ci }}</td>
            <td class="nombre-celda">Nombres y Apellidos:</td>
            <td>{{ $estudiante->persona_primer_apellido }} {{ $estudiante->persona_segundo_apellido }} {{ $estudiante->persona_nombres }}</td>
        </tr>
        <tr>
            <td class="nombre-celda">Gestión:</td>
            <td>{{ $gestion }}</td>
            <td class="nombre-celda">Periodo:</td>
            <td>{{ $periodo }}</td>
            <td class="nombre-celda">Carrera:</td>
            <td>INGENIERÍA ELECTRÓNICA</td>
        </tr>
        <tr>
            <td class="nombre-celda">Celular:</td>
            <td>{{ $datosContacto->celular_numero }}</td>
            <td class="nombre-celda">Correo-e:</td>
            <td>{{ $datosContacto->correo_direccion }}</td>
            <td class="nombre-celda">Dirección:</td>
            <td>{{$datosContacto->domicilio_direccion}}</td>
        </tr>
    </tbody>
</table>

<table class="centro">
    <thead class="fondo-gris">
        <tr>
            <th>N°</th>
            <th>Semestre</th>
            <th>Sigla</th>
            <th>Asignatura</th>
            <th>Paralelo</th>
            <th>Fecha de inscripción</th>
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
                @if ($asignatura->apertura_campo == 'Laboratorio')
                    <td>{{ $asignatura->asignatura_sigla }} (L)</td>
                    <td class="izquierda">{{ $asignatura->asignatura_nombre }} ({{ $asignatura->apertura_campo }})</td>
                @else
                    <td>{{ $asignatura->asignatura_sigla }}</td>
                    <td class="izquierda">{{ $asignatura->asignatura_nombre }}</td>
                @endif
                <td>{{ $asignatura->apertura_paralelo }}</td>
                <td>{{ $asignatura->inscripcion_fecha }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="firma">
    <span>FIRMA DEL ESTUDIANTE</span>
    <span>V.B. DIRECTOR DE CARRERA</span>
</div>