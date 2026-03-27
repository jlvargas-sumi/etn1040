<form action="{{ route('administrador.asignaturas.buscar') }}" method="GET" class="flex">
    <div class="input-field">
        <select id="plan-estudios-id" name="plan_estudios_id" required>
            @foreach ($planesEstudios as $_planEstudios)
                <option value="{{$_planEstudios->plan_estudio_id}}" {{$_planEstudios->plan_estudio_id == $planEstudiosId ? "selected":""}}>{{$_planEstudios->plan_estudio_nombre}}</option>
            @endforeach
        </select>
        <label for="plan-estudios-id">Plan de Estudios</label>
    </div>
    <div class="input-field">
        <select id="mencion-id" name="mencion_id" required>
            {{-- <option value="0">General</option> --}}
            @foreach ($menciones as $_mencion)
                <option value="{{ $_mencion->mencion_id }}" {{ $_mencion->mencion_id == $mencionId ? "selected":""}}>{{ $_mencion->mencion_nombre }}</option>
            @endforeach
        </select>
        <label for="mencion-id">Mención</label>
    </div>
    <div class="input-field">
        <button type="submit" class="btn-small waves-effect waves-light"><span class="contenedor-icono"><span>Buscar</span><i class="material-icons derecha">search</i></span></button>
    </div>
</form>