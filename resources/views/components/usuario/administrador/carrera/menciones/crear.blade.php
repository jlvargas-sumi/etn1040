<a href="#modal-confirmar-crear-mencion" class="modal-trigger btn-floating btn-medium waves-effect waves-light green modal-confirmar-crear" title="Crear Mención"><i class="material-icons">add</i></a>

<div id="modal-confirmar-crear-mencion" class="modal">
    <div class="modal-content">
        <h4>Crear Mención</h4>
        <form action="{{route('administrador.menciones.crear')}}" method="POST">
            @csrf
            <div class="row">
                <div class="input-field col s6">
                    <input placeholder="Nombre de Mención" id="mencion" name="mencion" type="text" class="validate" required>
                    <label for="mencion">Mención</label>
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