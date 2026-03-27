<div class="tabla">
    <table id="tabla">
        <thead>
            <tr>
                <th>N°</th>
                <th>Convocatoria</th>
                <th class="tizquierda">Título</th>
                <th>Fecha</th>
                <th>Archivo</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($convocatorias as $i => $convocatoria)
                @php
                    $rutaArchivo = public_path().'/storage/publicaciones/convocatorias/'.$convocatoria->publicacion_archivo;
                    $recursoArchivo = asset('storage/publicaciones/convocatorias/'.$convocatoria->publicacion_archivo);       
                @endphp
                <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $convocatoria->publicacion_numero }}</td>
                <td class="tizquierda">{{ $convocatoria->publicacion_titulo }}</td>
                <td>{{ $convocatoria->registrar_publ_fecha }}</td>
                <td>
                    <a href="#modal-{{ $i }}" data-modal="#modal-{{ $i }}" class="ver-archivo waves-effect waves-light btn-small background-main-1 hover-80 modal-trigger"><span class="contenedor-icono"><span>Abrir</span><i class="material-icons derecha">insert_drive_file</i></span></a>
                </td>
                <div id="modal-{{ $i }}" class="modal modal-pdf">
                    <div class="modal-footer">
                        <input type="hidden" name="recurso_archivo" value="{{ $recursoArchivo }}">
                        <a href="#!" class="modal-close"><i class="material-icons medium color-secundario-4 hover-80">cancel</i></a>
                    </div>
                    <div class="modal-content">
                        <h4>{{ $convocatoria->publicacion_titulo }}</h4>
                        <p>Convocatoria {{ $convocatoria->publicacion_numero}}</p>
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