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
            @foreach ($pensumSistemas as $pensumSistemas)
                <tr>
                    <td>{{ $pensumSistemas->semestre_numerico }}</td>
                    <td>{{ $pensumSistemas->asignatura_sigla }}</td>
                    <td>{{ $pensumSistemas->asignatura_nombre }}</td>
                    <td>{{ $pensumSistemas->asignatura_teoria }}</td>
                    <td>{{ $pensumSistemas->asignatura_laboratorio }}</td>
                    <td>{{ $pensumSistemas->vista_prerrequisito_sigla }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>