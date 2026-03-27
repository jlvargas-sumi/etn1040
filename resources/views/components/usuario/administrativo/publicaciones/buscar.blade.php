<form action="{{ route('administrativo.publicaciones.buscar') }}" method="POST" class="flex">
    @csrf
    <input type="hidden" name="tipo" value="{{ $tipo }}">
    @if ($tipo == "Comunicado" || $tipo == "Convocatoria")
        <div class="input-field">
            <select id="seleccionar-parametro" name="seleccionar_parametro">
                <option value="" disabled selected>Seleccione un parámetro</option>
                <option value="numero">Número</option>
                <option value="descripcion">Descripción</option>
                <option value="fecha">Fecha</option>
            </select>
            <label>Buscar por</label>
            @error('seleccionar_parametro')
                <span class="helper-text mensaje-error">{{ $message }}</span>
            @enderror
        </div>
    @else
        <div class="input-field">
            <select id="seleccionar-parametro" name="seleccionar_parametro">
                <option value="" disabled selected>Seleccione un parámetro</option>
                <option value="tipo">Tipo</option>
                <option value="descripcion">Descripción</option>
                <option value="fecha">Fecha</option>
            </select>
            <label>Buscar por</label>
            @error('seleccionar_parametro')
                <span class="helper-text mensaje-error">{{ $message }}</span>
            @enderror
        </div>
    @endif
    <div class="input-field">
        <input type="text" name="valor_parametro" value="{{ old('valor_parametro')}}" placeholder="Seleccione parámetro" required id="valor-parametro" class="validate">
        <label for="valor_parametro" class="valor-parametro">Parámetro</label>
        @error('valor_parametro')
            <span class="helper-text mensaje-error">{{ $message }}</span>
        @enderror
    </div>
    <div class="input-field">
        <button type="submit" class="btn-small waves-effect waves-light"><span class="contenedor-icono"><span>Buscar</span><i class="material-icons derecha">search</i></span></button>
    </div>
</form>