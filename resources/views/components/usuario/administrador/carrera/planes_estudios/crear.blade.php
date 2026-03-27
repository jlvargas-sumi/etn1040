<a href="#modal-confirmar-crear-plan-estudio" class="modal-trigger btn-floating btn-medium waves-effect waves-light green modal-confirmar-crear" title="Crear Plan de Estudio"><i class="material-icons">add</i></a>

<div id="modal-confirmar-crear-plan-estudio" class="modal">
    <div class="modal-content">
        <h4>Crear Plan de Estudio</h4>
        <form action="{{route('administrador.planes-estudios.crear')}}" method="POST">
            @csrf
            <div class="row">
                <div class="input-field col s6">
                    <input placeholder="Nombre de Plan de Estudio" id="plan-estudio" name="plan_estudio" type="text" class="validate" required>
                    <label for="plan-estudio">Plan de Estudio</label>
                </div>
                <div class="row col s6">
                    <button type="submit" class="btn waves-effect waves-light">Crear</button>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-red btn-small red">Salir</a>
    </div>
</div>