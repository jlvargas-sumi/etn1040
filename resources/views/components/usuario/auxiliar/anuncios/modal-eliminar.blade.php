<div id="modal-eliminar-{{ $i }}" class="modal modal-eliminar">
    <div class="modal-content center-align">
        <span class="subtitulo">¿Esta seguro de eliminar el anuncio <span class="color-secundario-4">"{{ $anuncio->publicacion_titulo }}"</span>?</span>
        <form action="{{ route('auxiliar.anuncios.eliminar') }}" method="POST" id="form-eliminar-anuncio">
            @csrf
            <input type="hidden" name="publicacion_id" value="{{ $anuncio->publicacion_id }}" required>
            <input type="hidden" name="descripcion" value="{{ $anuncio->publicacion_titulo }}" required>
            <button type="submit" id="eliminar-anuncio" class="btn fondo-principal-1 hover-80">Eliminar</button>
            <a href="#!" class="modal-close btn waves-effect waves-green fondo-secundario-4 hover-80">Cancelar</a>
        </form>
    </div>
</div>