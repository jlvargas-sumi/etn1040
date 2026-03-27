<div class="actualizar-clave col s12 m8 push-m2 l8 push-l2">
    <ul>
        <span>Actualizar Contraseña</span>
        <li>
            <form action="{{ route('perfil.actualizar-clave') }}" method="POST" id="formulario-actualizar-clave">
                @csrf
                <div class="input-field">
                    <i class="material-icons prefix color-secundario-1">vpn_key</i>
                    <input type="password" name="clave_actual" required id="clave-actual" class="validate">
                    <label for="clave-actual">Contraseña Actual</label>
                    @error('clave_actual')
                        <span class="helper-text mensaje-error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field">
                    <i class="material-icons prefix color-secundario-1">vpn_key</i>
                    <input type="password" name="password" required id="password" class="validate">
                    <label for="password">Nueva Contraseña</label>
                    @error('password')
                        <span class="helper-text mensaje-error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field">
                    <i class="material-icons prefix color-secundario-1">vpn_key</i>
                    <input type="password" name="password_confirmation" required id="password-confirmation" class="validate">
                    <label for="password-confirmation">Confirmar nueva contraseña</label>
                    @error('password_confirmation')
                        <span class="helper-text mensaje-error">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="waves-effect waves-light btn col s12 m12 l12 fondo-principal-1 hover-90 ">Actualizar</button>
            </form>
        </li>
    </ul>
</div>