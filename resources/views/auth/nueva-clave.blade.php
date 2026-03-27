<x-layouts.plantilla titulo="Nueva contraseña" meta-descripcion="Meta descripción de Nueva contraseña" nombre-pagina="nueva-clave">
    <section>
        <div class="formulario-iniciar-sesion row">
            <form action="{{ route('nueva-clave.actualizar') }}" method="POST" class="col s10 push-s1 m4 push-m4 l4 push-l4 white">
                <div class="color-secundario-1">Nueva Contraseña</div>
                <div class="divider"></div>
                @csrf
                <div class="input-field">
                    <i class="material-icons prefix color-secundario-1">security</i>
                    <input type="text" name="codigo" value="{{ old('codigo') }}" required id="codigo" class="validate">
                    <label for="codigo">Código enviado</label>
                    @error('codigo')
                        <span class="helper-text mensaje-error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field">
                    <i class="material-icons prefix color-secundario-1">account_circle</i>
                    <input type="text" name="usuario" value="{{ old('usuario') }}" required id="usuario" class="validate">
                    <label for="usuario">Usuario</label>
                    @error('usuario')
                        <small class="helper-text mensaje-error">{{ $message }}</small>
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
                <button type="submit" class="waves-effect waves-light btn col s12 m12 l12 fondo-principal-1 hover-90 ">Enviar</button>
            </form>
        </div>
    </section>
</x-layouts.plantilla>