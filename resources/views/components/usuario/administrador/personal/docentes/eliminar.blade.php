<div id="modal-eliminar-docente" class="modal">
    <div class="modal-content">
        <span class="subtitulo">Eliminar Docente</span>
        <form action="{{route('administrador.docentes.eliminar')}}" method="POST">
            @csrf
            <input type="hidden" name="id" class="validate" required>
            <input type="hidden" name="ci" class="validate" required>
            <table>
                <thead>
                    <tr>
                        <th>C.I.</th>
                        <th>A.P.</th>
                        <th>A.M.</th>
                        <th>Nombres</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td id="ci"></td>
                        <td id="primer-apellido"></td>
                        <td id="segundo-apellido"></td>
                        <td id="nombres"></td>
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