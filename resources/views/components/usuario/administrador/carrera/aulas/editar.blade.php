<div id="modal-editar-aula" class="modal">
    <div class="modal-content">
        <span class="subtitulo">Editar datos</span>
        <form action="{{route('administrador.aulas.actualizar')}}" method="POST">
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
                            <td>Aula</td>
                            <td id="aula-actual"></td>
                            <td><input type="text" name="aula" id="aula" class="validate" required></td>
                        </tr>
                        <tr>
                            <td>Capacidad</td>
                            <td id="capacidad-actual"></td>
                            <td><input type="number" name="capacidad" min="1" max="500" step="1" id="capacidad" class="validate" required></td>
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