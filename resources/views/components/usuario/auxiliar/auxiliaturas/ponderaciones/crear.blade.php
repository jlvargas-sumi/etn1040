<div id="modal-crear-ponderacion" class="modal">
    <div class="modal-content">
        <h4 class="center">Crear ponderación para <strong></strong></h4>
        <form action="{{route('auxiliar.ponderaciones.crear')}}" method="POST">
            @csrf
            <input type="hidden" name="id" required>
            <input type="hidden" name="tipo" required>
            <input type="hidden" name="tipo_es" required>
            <input type="hidden" name="apertura_id" value="{{$aperturaId}}" required>
            <input type="hidden" name="periodo" value="{{$periodo}}" required>
            <input type="hidden" name="gestion" value="{{$gestion}}" required>
            <input type="hidden" name="sigla" value="{{$asignatura->asignatura_sigla}}" required>
            <div class="flex f-jcc">
                <div class="input-field">
                    <input type="number" id="ponderacion" name="ponderacion" min="1" max="100" step="0.01" placeholder="25%" class="validate center w-120" required>
                    <label for="ponderacion">Porcentaje</label>
                </div>
                <button class="btn-small">Crear</button>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-ligth red white-text btn-flat">Salir</a>
    </div>
</div>