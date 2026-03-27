<div id="modal-{{ $i }}" class="modal modal-pdf">
    <div class="modal-footer">
        <input type="hidden" name="recurso_archivo" value="{{ $recursoArchivo }}">
        <a href="#!" class="modal-close"><i class="material-icons medium color-secundario-4 hover-80">cancel</i></a>
    </div>
    <div class="modal-content">
        <h4>{{ $publicacion->publicacion_descripcion }}</h4>
        <p>Publicación {{ $publicacion->publicacion_numero }}</p>
        @if (file_exists($rutaArchivo))
            <iframe></iframe>
        @else
            <div class="mensaje-alerta-advertencia">Error interno, si el problema persiste comuníquese con el administrador de Sistemas.</div>
        @endif
    </div>
</div>