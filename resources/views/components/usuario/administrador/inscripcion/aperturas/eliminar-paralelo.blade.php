<div id="modal-eliminar-paralelo" class="modal">
    <div class="modal-content">
        <span class="subtitulo">Eliminar Paralelo</span>
        <form action="{{route('administrador.aperturas.eliminar-paralelo')}}" method="POST">
            @csrf
            <div class="row">
                <input type="hidden" name="id" required >
                <input type="hidden" name="plan_estudios_id" value="{{$planEstudiosId}}" required >
                <input type="hidden" name="mencion_id" value="{{$mencionId}}" required >
                <input type="hidden" name="periodo" value="{{$periodo}}" required >
                <input type="hidden" name="gestion" value="{{$gestion}}" required >
                <input type="hidden" name="paralelo" required >
                <input type="hidden" name="sigla" required >
                <table>
                    <thead>
                        <tr>
                            <th>Sigla</th>
                            <th>Paralelo</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td id="sigla"></td>
                            <td id="paralelo"></td>
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