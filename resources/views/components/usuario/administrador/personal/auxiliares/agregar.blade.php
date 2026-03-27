<div class="row">
    <span class="subtitulo">Agregar</span>
    <div class="col s12">
      <form action="{{route('administrador.auxiliares.agregar')}}" method="POST">
        @csrf
        <div class="row">
            <div class="input-field col s5 m3">
                <i class="material-icons prefix">call_to_action</i>
                <input id="agregar-ru" type="number" name="ru" value="{{ old('ru')}}" min="1000000" max="9999999" step="1" placeholder="123456789" required class="validate">
                <label for="agregar-ru">R.U.</label>
                @error('ru')
                    <span class="helper-text mensaje-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-field col">
                <a href="#modal-verificar-estudiante" class="sin-estilo modal-trigger" id="verificar-estudiante"><span class="contenedor-icono"><i class="material-icons grey-text hover-70">verified</i></span></a>
            </div>
            <div class="input-field col">
                <button type="submit" class="btn waves-effect waves-light">Agregar</button>
            </div>
          </div>
      </form>
    </div>
</div>

<div id="modal-verificar-estudiante" class="modal">
    <div class="modal-content">
        <h4>Datos del estudiante</h4>
        <table>
            <thead>
                <tr>
                    <th>R.U.</th>
                    <th>C.I.</th>
                    <th>A.P.</th>
                    <th>A.M.</th>
                    <th>Nombres</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td id="ru"></td>
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