<div class="titulo-formal subtitulo">Anuncios publicados</div>
<div class="tabla tabla-formal">
    <table id="tabla">
        <thead>
            <tr>
                <th>N°</th>
                <th class="tizquierda">Título</th>
                <th>Fecha</th>
                <th>Archivo</th>
                <th colspan="2">Acción</th>
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
                    <td class="tizquierda">{{ $anuncio->publicacion_titulo }}</td>
                    <td>{{ $anuncio->registrar_publ_fecha }}</td>
                    <td><a href="#modal-{{ $i }}" data-modal="#modal-{{ $i }}" class="ver-archivo waves-effect waves-light btn-small background-main-1 hover-80 modal-trigger"><span class="contenedor-icono"><span>Abrir</span><i class="material-icons derecha">insert_drive_file</i></span></a></td>
                    <td><a href="#modal-editar-{{ $i }}" title="Editar" class="modal-trigger editar"><i class="material-icons color-principal-1">edit</i></a></td>
                    <td><a href="#modal-eliminar-{{ $i }}" title="Eliminar" class="modal-trigger eliminar"><i class="material-icons color-secundario-4">delete</i></a></td>
                </tr>
                    <x-usuario.docente.anuncios.modal-archivo :i="$i" :recurso-archivo="$recursoArchivo" :ruta-archivo="$rutaArchivo" :anuncio="$anuncio" />
                    <x-usuario.docente.anuncios.modal-editar :i="$i" :anuncio="$anuncio" />
                    <x-usuario.docente.anuncios.modal-eliminar :i="$i" :anuncio="$anuncio" />
            @endforeach
        </tbody>
    </table>
</div>