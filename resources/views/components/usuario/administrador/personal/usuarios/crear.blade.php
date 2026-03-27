<a href="#modal-confirmar-crear-usuario" class="modal-trigger btn-floating btn-medium waves-effect waves-light green modal-confirmar-crear-usuario" title="Crear Usuario"><i class="material-icons">person_add</i></a>

<div id="modal-confirmar-crear-usuario" class="modal">
    <div class="modal-content">
        <h4>Crear Usuario</h4>
        <form action="{{route('administrador.usuarios.crear')}}" method="POST">
            @csrf
            <div class="row">
                <h6>Datos Personales</h6>
                <div class="input-field col s6 m3">
                    <input placeholder="Primer Ap." id="primer-apellido" name="primer_apellido" type="text" class="validate">
                    <label for="primer-apellido">Primer Apellido</label>
                </div>
                <div class="input-field col s6 m3">
                    <input placeholder="Segundo Ap." id="segundo-apellido" name="segundo_apellido" type="text" class="validate">
                    <label for="segundo-apellido">Segundo Apellido</label>
                </div>
                <div class="input-field col s6 m3">
                    <input placeholder="Nombres" id="nombres" name="nombres" type="text" class="validate" required>
                    <label for="nombres">Nombres</label>
                </div>
                <div class="input-field col s6 m3">
                    <input placeholder="6000000" id="ci" name="ci" type="text" class="validate" required>
                    <label for="ci">C.I.</label>
                </div>
                <h6>Datos de Contacto</h6>
                <div class="input-field col s6">
                    <input placeholder="75800000" id="celular" name="celular" type="number" min="60000000" max="79999999" step="1" class="validate" required>
                    <label for="celular">Celular</label>
                </div>
                <div class="input-field col s6">
                    <input placeholder="sts@sts.com.bo" id="correo" name="correo" type="email" class="validate" required>
                    <label for="correo">Correo</label>
                </div>
                <h6>Datos de Usuario</h6>
                <div class="input-field col s5">
                    <select name="rol_id" id="seleccionar-rol">
                        @foreach ($roles as $rol)
                            @if ($rol->rol_id != 3)
                                <option value="{{$rol->rol_id}}">{{$rol->rol_nombre}}</option>
                            @endif
                        @endforeach
                    </select>
                    <label for="seleccionar-rol">Rol</label>
                </div>
                <div class="input-field col s4" id="_ru">
                    <input placeholder="1000000" id="ru" name="ru" type="number" min="1000000" max="9999999" step="1" class="validate" required/>
                    <label for="ru">R.U.</label>
                </div>
                <div class="input-field col s3" id="_auxiliar">
                    <select name="auxiliar" id="auxiliar">
                            <option value="NO">NO</option>
                            <option value="SI">SI</option>
                    </select>
                    <label for="auxiliar">Auxiliar</label>
                </div>
                <div class="input-field col s3" id="_grado">
                    <select name="grado" id="grado">
                            <option value="ING.">ING.</option>
                            <option value="LIC.">LIC.</option>
                    </select>
                    <label for="grado">Grado</label>
                </div>
                <div class="input-field col s4" id="categoria">
                    <select name="categoria_id" id="categoria-id">
                        @foreach ($categorias as $categoria)
                            <option value="{{$categoria->categoria_id}}">{{$categoria->categoria_nombre}}</option>
                        @endforeach
                    </select>
                    <label for="categoria-id">Categoría</label>
                </div>
                <div class="input-field col s7" id="cargo">
                    <select name="cargo_id" id="cargo-id">
                        @foreach ($cargos as $cargo)
                            <option value="{{$cargo->cargo_id}}">{{$cargo->cargo_nombre}}</option>
                        @endforeach
                    </select>
                    <label for="cargo">Cargo</label>
                </div>
                <div class="row col s12">
                    <button type="submit" class="col s6 push-s3 btn waves-effect waves-light">Crear</button>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-red btn-small red">Salir</a>
    </div>
</div>