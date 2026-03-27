<div class="tabla">
    <table id="tabla">
        <thead>
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
</div>