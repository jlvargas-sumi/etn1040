<form action="{{route('auxiliar.ponderaciones.actualizar-apertura')}}" method="POST" class="flex">
    @csrf
    <input type="hidden" name="id" value={{$auxiliaturaId}} required>
    <input type="hidden" name="campo" value={{$campo}} required>
    <input type="hidden" name="apertura_id" value={{$aperturaId}} required>
    <input type="hidden" name="periodo" value={{$periodo}} required>
    <input type="hidden" name="gestion" value={{$gestion}} required>
    <input type="hidden" name="sigla" value="{{$asignatura->asignatura_sigla}}" required>
    <h5>{{$campo}}</h5>
    <div class="input-field">
        <input type="number" name="ponderacion_principal" value={{$ponderacionPrincipal}} min="0" max="100" placeholder="Placeholder" id="ponderacion-principal-{{$campo[0]}}" type="text" class="validate">
        <label for="ponderacion-principal-{{$campo[0]}}">{{$tipoEs}}(%)</label>
    </div>
    <div class="input-field">
        <input type="number" name="ponderacion_secundaria" value={{$ponderacionSecundaria}} min="0" max="100" placeholder="Placeholder" id="ponderacion-secundaria-{{$campo[0]}}" type="text" class="validate">
        <label for="ponderacion-secundaria-{{$campo[0]}}">Actividades(%)</label>
    </div>
    <button class="btn-small">Guardar</button>
    <strong class="col s12 m-5 center {{ $ponderacionPrincipal+$ponderacionSecundaria == 100 ? "green":"red" }}-text">
        <i class="material-icons">functions</i>Total {{$ponderacionPrincipal+$ponderacionSecundaria}}
        <i class="material-icons">{{ $ponderacionPrincipal+$ponderacionSecundaria == 100 ? "check":"cancel" }}</i>
    </strong>
</form>