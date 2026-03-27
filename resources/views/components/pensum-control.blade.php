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
            @foreach ($pensumControl as $pensumControl)
                <tr>
                    <td>{{ $pensumControl->semestre_numerico }}</td>
                    <td>{{ $pensumControl->asignatura_sigla }}</td>
                    <td>{{ $pensumControl->asignatura_nombre }}</td>
                    <td>{{ $pensumControl->asignatura_teoria }}</td>
                    <td>{{ $pensumControl->asignatura_laboratorio }}</td>
                    <td>{{ $pensumControl->vista_prerrequisito_sigla }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>