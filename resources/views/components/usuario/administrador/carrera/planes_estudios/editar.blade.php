<div id="modal-editar-plan-estudio" class="modal">
    <div class="modal-content">
        <span class="subtitulo">Editar datos</span>
        <form action="{{route('administrador.planes-estudios.actualizar')}}" method="POST">
            @csrf
            <input type="hidden" name="id" id="id" class="validate" required>
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
                            <td>Plan de Estudio</td>
                            <td id="plan-estudio-actual"></td>
                            <td><input type="text" name="plan_estudio" id="plan-estudio" class="validate" required></td>
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
        </form>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat red white-text hover-70">Salir</a>
    </div>
</div>