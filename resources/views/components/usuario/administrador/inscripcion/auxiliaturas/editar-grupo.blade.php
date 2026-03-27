<div id="modal-editar-grupo" class="modal">
    <div class="modal-content">
        <span class="subtitulo">Actualizar grupo para <strong id="sigla"></strong></span>
        <form action="{{route('administrador.auxiliaturas.actualizar-grupo')}}" method="POST">
            @csrf
            <div class="row">
                <input type="hidden" name="id" required >
                <input type="hidden" name="plan_estudios_id" value="{{$planEstudiosId}}" required >
                <input type="hidden" name="mencion_id" value="{{$mencionId}}" required >
                <input type="hidden" name="periodo" value="{{$periodo}}" required >
                <input type="hidden" name="gestion" value="{{$gestion}}" required >
                <input type="hidden" name="sigla" required >
                <input type="hidden" name="grupo_actual" required >
                <div class="tabla-s">
                    <table>
                        <thead>
                            <tr>
                                <th>Campo</th>
                                <th>Datos Actuales</th>
                                <th>Datos Confirmados</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Grupo</td>
                                <td id="grupo-actual"></td>
                                <td><input type="number" name="grupo" id="grupo" min="2" max="10" step="1" class="validate" required></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="center">
                                    <button type="submit" class="btn waves-effect waves-light">Actualizar datos</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-red btn-small red">Salir</a>
    </div>
</div>