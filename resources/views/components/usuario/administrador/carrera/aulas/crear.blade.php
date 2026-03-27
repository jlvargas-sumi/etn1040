<a href="#modal-confirmar-crear-aula" class="modal-trigger btn-floating btn-medium waves-effect waves-light green modal-confirmar-crear"><i class="material-icons">add</i></a>

<div id="modal-confirmar-crear-aula" class="modal">
    <div class="modal-content">
        <h4>Crear Aula</h4>
        <form action="{{route('administrador.aulas.crear')}}" method="POST">
            @csrf
            <div class="row">
                <div class="input-field col s4">
                    <input placeholder="Nombre de Aula" id="aula" name="aula" type="text" class="validate" required>
                    <label for="aula">Aula</label>
                </div>
                <div class="input-field col s4">
                    <input placeholder="100" id="capacidad" name="capacidad" type="number" min="1" max="500" step="1" class="validate" required>
                    <label for="capacidad">Capacidad</label>
                </div>
                <div>
                    <button type="submit" class="push-s3 btn waves-effect waves-light">Crear</button>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-red btn-small red">Salir</a>
    </div>
</div>