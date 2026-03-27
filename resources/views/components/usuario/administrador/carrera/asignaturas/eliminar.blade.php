<div id="modal-eliminar-asignatura" class="modal">
    <div class="modal-content">
        <span class="subtitulo">Eliminar Asignatura</span>
        <form action="{{route('administrador.asignaturas.eliminar')}}" method="POST">
            @csrf
            <input type="hidden" name="plan_estudios_id" value="{{$planEstudiosId}}" class="validate" required>
            <input type="hidden" name="mencion_id" value="{{$mencionId}}" class="validate" required>
            <input type="hidden" name="id" class="validate" required>
            <input type="hidden" name="sigla" class="validate" required>
            <input type="hidden" name="asignatura" class="validate" required>
            <table>
                <thead>
                    <tr>
                        <th>Sigla</th>
                        <th>Asignatura</th>
                        <th>Aplicar</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td id="sigla"></td>
                        <td id="asignatura"></td>
                        <td>
                            <p>
                                <label>
                                  <input type="checkbox" name="eliminacion_masiva" />
                                  <span>Todas las menciones</span>
                                </label>
                            </p>
                        </td>
                        <td>
                            <button type="submit" class="btn waves-effect waves-light">Eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat red white-text hover-70">Salir</a>
    </div>
</div>