<div id="modal-eliminar-{{ $i }}" class="modal modal-eliminar">
    <div class="modal-content center-align">
        <span class="subtitulo">¿Esta seguro de eliminar la publicación <span class="color-secundario-4">"{{ $publicacion->publicacion_titulo }}"</span>?</span>
        <form action="{{ route('administrativo.publicaciones.eliminar') }}" method="POST" id="form-eliminar-anuncio">
            @csrf
            <input type="hidden" name="tipo" value="{{ $tipo }}">
            <input type="hidden" name="publicacion_id" value="{{ $publicacion->publicacion_id }}" required>
            <input type="hidden" name="titulo" value="{{ $publicacion->publicacion_titulo }}" required>
            <button type="submit" id="eliminar-anuncio" class="btn fondo-principal-1 hover-80">Eliminar</button>
            <a href="#!" class="modal-close btn waves-effect waves-green fondo-secundario-4 hover-80">Cancelar</a>
        </form>
    </div>
</div>