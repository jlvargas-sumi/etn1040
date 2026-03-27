<div id="modal-crear-grupo" class="modal">
    <div class="modal-content">
        <h4>Crear grupo para <strong></strong></h4>
        <form action="{{route('administrador.auxiliaturas.crear-grupo')}}" method="POST">
            @csrf
            <div class="row">
                <input type="hidden" name="id" required >
                <input type="hidden" name="plan_estudios_id" value="{{$planEstudiosId}}" required >
                <input type="hidden" name="mencion_id" value="{{$mencionId}}" required >
                <input type="hidden" name="periodo" value="{{$periodo}}" required >
                <input type="hidden" name="gestion" value="{{$gestion}}" required >
                <input type="hidden" name="sigla" required >
                <div class="input-field col s6">
                    <input type="number" name="grupo" value="2" min="2" max="10" class="validate" required>
                    <label for="inscripcion">Grupo</label>
                </div>
                <div class="row col s6">
                    <button type="submit" class="col s6 push-s3 btn waves-effect waves-light">Crear</button>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-red btn-small red">Salir</a>
    </div>
</div>