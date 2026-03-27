<div class="datos-contacto col s12 m8 push-m2 l8 push-l2">
    <ul>
        <span>Datos de Contacto</span>
        <li>
            <span class="contenedor-icono"><i class="material-icons izquierda">smartphone</i>
            <span>Celular:</span></span>
            <form action="{{ route('perfil.actualizar-celular') }}" method="POST" id="formulario-actualizar-celular">
                @csrf
                
                <div class="input-field">
                    <input type="hidden" name="celular_actual" value="{{ $informacionPersonal->celular_numero ?? '' }}">
                    <input type="number" name="celular" value="{{ $informacionPersonal->celular_numero ?? '' }}" disabled>
                </div>                            
                <button id="boton-actualizar-celular"><span class="contenedor-icono"><span>Actualizar</span><i class="material-icons derecha">save</i></span></button>
            </form>
            <button id="boton-habilitar-celular"><span class="contenedor-icono"><span>Editar</span><i class="material-icons derecha">edit</i></span></button>
            @error('celular')
                <span class="helper-text mensaje-error">{{ $message }}</span>
            @enderror
        </li>
        <li>
            <span class="contenedor-icono">
            <i class="material-icons izquierda">contact_mail</i><span>Correo:</span></span>
            <form action="{{ route('perfil.actualizar-correo') }}" method="POST" id="formulario-actualizar-correo">
                @csrf
                <div class="input-field">
                    <input type="hidden" name="correo_actual" value="{{ $informacionPersonal->correo_direccion ?? '' }}">
                    <input type="email" name="correo" value="{{ $informacionPersonal->correo_direccion ?? '' }}" disabled required id="correo" class="validate">
                    <span class="helper-text" data-error="Correo no válido" data-success="Correo válido">Validación de correo</span>
                </div>
                <button id="boton-actualizar-correo"><span class="contenedor-icono"><span>Actualizar</span><i class="material-icons derecha">save</i></span></button>
            </form>
            <button id="boton-habilitar-correo"><span class="contenedor-icono"><span>Editar</span><i class="material-icons derecha">edit</i></span></button>
            @error('correo')
                <span class="helper-text mensaje-error">{{ $message }}</span>
            @enderror
        </li>
        <li>
            <span class="contenedor-icono">
            <i class="material-icons izquierda">location_on</i><span>Domicilio:</span></span>
            <form action="{{ route('perfil.actualizar-domicilio') }}" method="POST" id="formulario-actualizar-domicilio">
                @csrf
                <div class="input-field">
                    <input type="hidden" name="domicilio_actual" value="{{ $informacionPersonal->domicilio_direccion ?? '' }}">
                    <input type="text" name="domicilio" value="{{ $informacionPersonal->domicilio_direccion ?? '' }}" disabled required id="domicilio" class="validate">
                </div>
                <button id="boton-actualizar-domicilio"><span class="contenedor-icono"><span>Actualizar</span><i class="material-icons derecha">save</i></span></button>
            </form>
            <button id="boton-habilitar-domicilio"><span class="contenedor-icono"><span>Editar</span><i class="material-icons derecha">edit</i></span></button>
            @error('domicilio')
                <span class="helper-text mensaje-error">{{ $message }}</span>
            @enderror
        </li>
    </ul>
</div>