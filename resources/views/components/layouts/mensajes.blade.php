@if ($mensaje = Session::get('exito'))
<div id="mensaje" class="mensaje-alerta-exito" role="alerta">
    <span class="contenedor-icono">
        <i class="material-icons izquierda">check_circle</i>
        <span>{{ $mensaje }}</span>
    </span>
</div>
@endif 
    
@if ($mensaje = Session::get('error'))
<div id="mensaje" class="mensaje-alerta-error" role="alerta">
    <span class="contenedor-icono">
        <i class="material-icons izquierda">block</i>
        <span>{{ $mensaje }}</span>
    </span>
</div>
@endif
     
@if ($mensaje = Session::get('advertencia'))
<div id="mensaje" class="mensaje-alerta-advertencia" role="alerta">
    <span class="contenedor-icono">
        <i class="material-icons izquierda">warning</i>
        <span>{{ $mensaje }}</span>
    </span>
</div>
@endif
     
@if ($mensaje = Session::get('informacion'))
<div id="mensaje" class="mensaje-alerta-informacion" role="alerta">
    <span class="contenedor-icono">
        <i class="material-icons izquierda">info</i>
        <span>{{ $mensaje }}</span>
    </span>
</div>
@endif
    
@if ($errors->any())
<div id="mensaje" class="mensaje-alerta-cualquiera" role="alerta">
    <span class="contenedor-icono">
        <i class="material-icons izquierda">block</i>
        <span>Por favor vuelva a llenar el formulario subsanando los errores que se indica.</span>
    </span>
</div>
@endif