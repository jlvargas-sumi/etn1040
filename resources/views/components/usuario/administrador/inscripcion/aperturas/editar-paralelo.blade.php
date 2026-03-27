<div id="modal-editar-paralelo" class="modal">
    <div class="modal-content">
        <span class="subtitulo">Actualizar Paralelo para <strong id="sigla"></strong></span>
        <form action="{{route('administrador.aperturas.actualizar-paralelo')}}" method="POST">
            @csrf
            <div class="row">
                <input type="hidden" name="id" required >
                <input type="hidden" name="plan_estudios_id" value="{{$planEstudiosId}}" required >
                <input type="hidden" name="mencion_id" value="{{$mencionId}}" required >
                <input type="hidden" name="periodo" value="{{$periodo}}" required >
                <input type="hidden" name="gestion" value="{{$gestion}}" required >
                <input type="hidden" name="sigla" required >
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
                                <td>Paralelo</td>
                                <td id="paralelo-actual"></td>
                                <td><input type="text" name="paralelo" id="paralelo" class="validate" required></td>
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