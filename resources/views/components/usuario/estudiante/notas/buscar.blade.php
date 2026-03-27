<form action="{{ route('estudiante.notas.buscar') }}" method="POST" class="flex">
    @csrf
    <div class="input-field">
        <select id="periodo" name="periodo" required>
            <option value="1" {{$periodo == "1" ? "selected":""}}>1</option>
            <option value="2" {{$periodo == "2" ? "selected":""}}>2</option>
            <option value="Invierno" {{$periodo == "Invierno" ? "selected":""}}>Invierno</option>
            <option value="Verano" {{$periodo == "Verano" ? "selected":""}}>Verano</option>
        </select>
        <label>Periodo</label>
        @error('periodo')
            <span class="helper-text mensaje-error">{{ $message }}</span>
        @enderror
    </div>
    <div class="input-field">
        <input type="number" name="gestion" value="{{ $gestion, old('gestion')}}" max="{{ date('Y') }}" min="1990" step="1" placeholder="{{ date('Y') }}" required id="gestion" class="validate">
        <label for="gestion" class="gestion">Gestión</label>
        @error('gestion')
            <span class="helper-text mensaje-error">{{ $message }}</span>
        @enderror
    </div>
    <div class="input-field">
        <button type="submit" class="btn-small waves-effect waves-light"><span class="contenedor-icono"><span>Buscar</span><i class="material-icons derecha">search</i></span></button>
    </div>
</form>