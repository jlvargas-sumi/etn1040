<x-layouts.plantilla titulo="Iniciar Sesión" meta-descripcion="Meta descripción de Iniciar Sesión" nombre-pagina="iniciar-sesion">
    <section>
        <div class="formulario-iniciar-sesion row">
            <form action="{{ route('iniciar-sesion.autenticar') }}" method="POST" class="col s10 push-s1 m6 push-m3 l4 push-l4 white">
                <div class="color-secundario-1">Iniciar Sesión</div>
                <div class="divider"></div>
                @csrf
                <div class="input-field">
                    <i class="material-icons prefix color-secundario-1">account_circle</i>
                    <input type="text" name="usuario" value="{{ old('usuario')}}" required id="usuario" class="validate">
                    <label for="usuario">Usuario</label>
                    @error('usuario')
                        <small class="helper-text mensaje-error">{{ $message }}</small>
                    @enderror
                </div>
                <div class="input-field">
                    <i class="material-icons prefix color-secundario-1">vpn_key</i>
                    <input type="password" name="clave" required id="clave" class="validate">
                    <label for="clave">Contraseña</label>
                    @error('clave')
                        <span class="helper-text mensaje-error">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="waves-effect waves-light btn col s12 m12 l12 fondo-principal-1 hover-90 ">Ingresar</button>
                <div class="col s12 m12 l12"><a href="{{ route('solicitud-codigo-correo') }}" class="hover-color-secundario-4">He olvidado mi Contraseña</a></div>  
            </form>
        </div>
    </section>
</x-layouts.plantilla>