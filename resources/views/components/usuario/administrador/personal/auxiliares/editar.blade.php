<div id="modal-editar-datos-auxiliar" class="modal">
    <div class="modal-content">
        <span class="subtitulo">Editar datos</span>
        <form action="{{route('administrador.auxiliares.actualizar')}}" method="POST">
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
                            <td>C.I.</td>
                            <td id="ci-actual"></td>
                            <td><input type="text" name="ci" id="ci" class="validate" required></td>
                        </tr>
                        <tr>
                            <td>R.U.</td>
                            <td id="ru-actual"></td>
                            <td><input type="number" name="ru" id="ru" min="1000000" max="9999999" step="1" class="validate" required></td>
                        </tr>
                        <tr>
                            <td>Primer Ap.</td>
                            <td id="primer-apellido-actual"></td>
                            <td><input type="text" name="primer_apellido" id="primer-apellido" class="validate"></td>
                        </tr>
                        <tr>
                            <td>Segundo Ap.</td>
                            <td id="segundo-apellido-actual"></td>
                            <td><input type="text" name="segundo_apellido" id="segundo-apellido" class="validate"></td>
                        </tr>
                        <tr>
                            <td>Nombres</td>
                            <td id="nombres-actual"></td>
                            <td><input type="text" name="nombres" id="nombres" class="validate" required></td>
                        </tr>
                        <tr>
                            <td>Celular</td>
                            <td id="celular-actual"></td>
                            <td><input type="number" name="celular" min="6000000" max="79999999" step="1" id="celular" class="validate" required></td>
                        </tr>
                        <tr>
                            <td>Correo-e</td>
                            <td id="correo-actual"></td>
                            <td><input type="email" name="correo" id="correo" class="validate" required></td>
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