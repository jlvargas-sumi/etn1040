<div id="modal-crear-laboratorio" class="modal">
    <div class="modal-content">
        <h4>Crear laboratorio para <strong></strong></h4>
        <form action="{{route('administrador.aperturas.crear-laboratorio')}}" method="POST">
            @csrf
            <div class="row">
                <input type="hidden" name="id" required >
                <input type="hidden" name="plan_estudios_id" value="{{$planEstudiosId}}" required >
                <input type="hidden" name="mencion_id" value="{{$mencionId}}" required >
                <input type="hidden" name="periodo" value="{{$periodo}}" required >
                <input type="hidden" name="gestion" value="{{$gestion}}" required >
                <input type="hidden" name="sigla" required >
                <h6>Datos Asignatura</h6>
                <div class="input-field col s6">
                    <input type="text" name="laboratorio" placeholder="B" value="A" disabled >
                    <label for="inscripcion">Paralelo</label>
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