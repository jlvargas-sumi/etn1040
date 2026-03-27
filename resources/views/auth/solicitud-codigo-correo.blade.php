<x-layouts.plantilla titulo="Enviar código a correo" meta-descripcion="Enviar código a correo" nombre-pagina="solicitud-codigo-correo">
    <section>
        <div class="formulario-iniciar-sesion row">
            <form action="{{ route('solicitud-codigo-correo.almacenar') }}" method="POST" class="col s10 push-s1 m6 push-m3 l4 push-l4 white">
                <div class="color-secundario-1">Obtener Código</div>
                <p>Se enviará un código de verificación al correo electrónico registrado.</p>
                <div class="divider"></div>
                
                @csrf
                <div class="input-field">
                    <i class="material-icons prefix color-secundario-1">account_circle</i>
                    <input type="text" name="usuario" value="{{ old('usuario') }}" required id="usuario" class="validate">
                    <label for="usuario">Usuario</label>
                    @error('usuario')
                        <small class="helper-text mensaje-error">{{ $message }}</small>
                    @enderror
                </div>
                <div class="input-field">
                    <i class="material-icons prefix color-secundario-1">email</i>
                    <input type="email" name="correo" value="{{ old('correo') }}" required id="correo" class="validate">
                    <label for="correo">Correo</label>
                    <span class="helper-text" data-error="Correo no válido" data-success="Correo válido">Validación de correo</span>
                    @error('correo')
                        <span class="helper-text mensaje-error">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="waves-effect waves-light btn col s12 m12 l12 fondo-principal-1 hover-90 ">Enviar</button>
            </form>
        </div>
    </section>
</x-layouts.plantilla>