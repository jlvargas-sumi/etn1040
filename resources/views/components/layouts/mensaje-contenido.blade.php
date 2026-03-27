@if ($tipoMensaje == 'exito')
<div id="mensaje" class="mensaje-alerta-exito" role="alerta">
    <span class="contenedor-icono">
        <i class="material-icons izquierda">check_circle</i>
        <span>{{ $slot }}</span>
    </span>
</div>
@endif 
    
@if ($tipoMensaje == 'error')
<div id="mensaje" class="mensaje-alerta-error" role="alerta">
    <span class="contenedor-icono">
        <i class="material-icons izquierda">block</i>
        <span>{{ $slot }}</span>
    </span>
</div>
@endif
     
@if ($tipoMensaje == 'advertencia')
<div id="mensaje" class="mensaje-alerta-advertencia" role="alerta">
    <span class="contenedor-icono">
        <i class="material-icons izquierda">warning</i>
        <span>{{ $slot }}</span>
    </span>
</div>
@endif
     
@if ($tipoMensaje == 'informacion')
<div id="mensaje" class="mensaje-alerta-informacion" role="alerta">
    <span class="contenedor-icono">
        <i class="material-icons izquierda">info</i>
        <span>{{ $slot }}</span>
    </span>
</div>
@endif