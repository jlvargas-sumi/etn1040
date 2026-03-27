<div class="row">
    <span class="subtitulo">Agregar</span>
    <div class="col s12">
      <form action="{{route('administrador.docentes.agregar')}}" method="POST">
        @csrf
        <div class="row">
            <div class="input-field col s5 m3">
                <i class="material-icons prefix">chrome_reader_mode</i>
                <input id="agregar-ci" type="text" name="ci" value="{{ old('ci')}}" placeholder="123456789" required class="validate">
                <label for="agregar-ci">C.I.</label>
                @error('ci')
                    <span class="helper-text mensaje-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-field col">
                <a href="#modal-verificar-personal" class="sin-estilo modal-trigger" id="verificar-personal"><span class="contenedor-icono"><i class="material-icons grey-text hover-70">verified</i></span></a>
            </div>
            <div class="input-field col s5 m3">
                <select name="grado" id="grado" class="validate" required>
                    <option value="ING.">ING.</option>
                    <option value="LIC.">LIC.</option>
                </select>
                <label>Grado</label>
                @error('grado')
                    <span class="helper-text mensaje-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-field col s8 m3">
                <select name="categoria_id" id="categoria-id" class="validate" required>
                    @foreach ($categorias as $categoria)
                        <option value="{{$categoria->categoria_id}}">{{$categoria->categoria_nombre}}</option>
                    @endforeach
                </select>
                <label>Categoría</label>
                @error('categoria_id')
                    <span class="helper-text mensaje-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-field col">
                <button type="submit" class="btn waves-effect waves-light">Agregar</button>
            </div>
          </div>
      </form>
    </div>
</div>

<div id="modal-verificar-personal" class="modal">
    <div class="modal-content">
        <h4>Datos del personal</h4>
        <table>
            <thead>
                <tr>
                    <th>C.I.</th>
                    <th>A.P.</th>
                    <th>A.M.</th>
                    <th>Nombres</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td id="ci"></td>
                    <td id="primer-apellido"></td>
                    <td id="segundo-apellido"></td>
                    <td id="nombres"></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat red white-text hover-70">Salir</a>
    </div>
</div>