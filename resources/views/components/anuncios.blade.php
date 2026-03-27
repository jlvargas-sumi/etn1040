<div class="tabla">
    <table id="tabla">
        <thead>
            <tr>
                <th>N°</th>
                <th>Tipo</th>
                <th class="tizquierda">Título</th>
                <th>Fecha</th>
                <th>Archivo</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($anuncios as $i => $anuncio)
                @php
                    $rutaArchivo = public_path().'/storage/publicaciones/anuncios/'.$anuncio->publicacion_archivo;
                    $recursoArchivo = asset('storage/publicaciones/anuncios/'.$anuncio->publicacion_archivo);       
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $anuncio->publicacion_tipo }}</td>
                    <td class="tizquierda">{{ $anuncio->publicacion_titulo }}</td>
                    <td>{{ $anuncio->registrar_publ_fecha }}</td>
                    <td>
                        <a href="#modal-{{ $i }}" data-modal="#modal-{{ $i }}" class="ver-archivo waves-effect waves-light btn-small background-main-1 hover-80 modal-trigger"><span class="contenedor-icono"><span>Abrir</span><i class="material-icons derecha">insert_drive_file</i></span></a>
                    </td>
                    <div id="modal-{{ $i }}" class="modal modal-pdf">
                        <div class="modal-footer">
                            <input type="hidden" name="recurso_archivo" value="{{ $recursoArchivo }}">
                            <a href="#!" class="modal-close"><i class="material-icons medium color-secundario-4 hover-80">cancel</i></a>
                        </div>
                        <div class="modal-content">
                            <h4>{{ $anuncio->publicacion_titulo }}</h4>
                            <p>Anuncio {{ $anuncio->publicacion_numero }}</p>
                            @if (file_exists($rutaArchivo))
                                <iframe></iframe>
                            @else
                                <div class="mensaje-alerta-advertencia">Error interno, si el problema persiste comuníquese con el administrador de Sistemas.</div>
                            @endif
                        </div>
                    </div>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>