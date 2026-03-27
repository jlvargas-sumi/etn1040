<div id="modal-eliminar-ponderacion" class="modal">
    <div class="modal-content">
        <h4 class="center">Eliminar ponderación para <strong></strong></h4>
        <form action="{{route('docente.ponderaciones.eliminar')}}" method="POST">
            @csrf
            <div class="row">
                <input type="hidden" name="id" required>
                <input type="hidden" name="indice" required>
                <input type="hidden" name="tipo" required>
                <input type="hidden" name="tipo_es" required>
                <input type="hidden" name="apertura_id" value="{{$aperturaId}}" required>
                <input type="hidden" name="periodo" value="{{$periodo}}" required>
                <input type="hidden" name="gestion" value="{{$gestion}}" required>
                <input type="hidden" name="sigla" value="{{$asignatura->asignatura_sigla}}" required>
                <table>
                    <thead>
                        <tr>
                            <th>Indice</th>
                            <th>Ponderación</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td id="indice"></td>
                            <td id="ponderacion"></td>
                            <td>
                                <button type="submit" class="btn waves-effect waves-light">Eliminar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-red btn-small red">Salir</a>
    </div>
</div>