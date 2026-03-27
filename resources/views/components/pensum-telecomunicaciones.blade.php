<div class="tabla">
    <table>
        <thead>
            <tr>
                <th>Semestre</th>
                <th>Sigla</th>
                <th>Asignatura</th>
                <th>Teoría</th>
                <th>Laboratorio</th>
                <th>Prerrequisito</th>
            </tr>
        </thead>
            
        <tbody>
            @foreach ($pensumTelecomunicaciones as $pensumTelecomunicaciones)
                <tr>
                    <td>{{ $pensumTelecomunicaciones->semestre_numerico }}</td>
                    <td>{{ $pensumTelecomunicaciones->asignatura_sigla }}</td>
                    <td>{{ $pensumTelecomunicaciones->asignatura_nombre }}</td>
                    <td>{{ $pensumTelecomunicaciones->asignatura_teoria }}</td>
                    <td>{{ $pensumTelecomunicaciones->asignatura_laboratorio }}</td>
                    <td>{{ $pensumTelecomunicaciones->vista_prerrequisito_sigla }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>