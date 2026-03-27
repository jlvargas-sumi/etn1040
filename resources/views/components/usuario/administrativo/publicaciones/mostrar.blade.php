<div class="titulo-formal subtitulo">Publicaciones de {{ $tipo }}s</div>
<div class="tabla">
    <table id="tabla">
        <thead>
            <tr>
                <th>N°</th>
                @if ($tipo == "Anuncio")
                    <th>Tipo</th>
                @else
                    <th>Número</th>
                @endif
                <th class="tizquierda">Título</th>
                <th>Fecha</th>
                <th>Archivo</th>
                <th colspan="2">Acción</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($publicaciones as $i =>  $publicacion)
                @php
                    $rutaArchivo = public_path().'/storage/publicaciones/'.strtolower($tipo).'s/'.$publicacion->publicacion_archivo;
                    $recursoArchivo = asset('storage/publicaciones/'.strtolower($tipo).'s/'.$publicacion->publicacion_archivo);       
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    @if ($tipo == "Anuncio")
                        <td>{{ $publicacion->publicacion_tipo }}</td>
                    @else
                        <td>{{ $publicacion->publicacion_numero }}</td>
                    @endif
                    <td class="tizquierda">{{ $publicacion->publicacion_titulo }}</td>
                    <td>{{ $publicacion->registrar_publ_fecha }}</td>
                    <td><a href="#modal-{{ $i }}" data-modal="#modal-{{ $i }}" class="ver-archivo waves-effect waves-light btn-small background-main-1 hover-80 modal-trigger"><span class="contenedor-icono"><span>Abrir</span><i class="material-icons derecha">insert_drive_file</i></span></a></td>
                    <td><a href="#modal-editar-{{ $i }}" title="Editar" class="modal-trigger editar"><i class="material-icons color-principal-1">edit</i></a></td>
                    <td><a href="#modal-eliminar-{{ $i }}" title="Eliminar" class="modal-trigger eliminar"><i class="material-icons color-secundario-4">delete</i></a></td>
                </tr>
                    <x-usuario.administrativo.publicaciones.modal-archivo :i="$i" :recurso-archivo="$recursoArchivo" :ruta-archivo="$rutaArchivo" :publicacion="$publicacion" />
                    <x-usuario.administrativo.publicaciones.modal-editar :tipo=$tipo :i="$i" :publicacion="$publicacion" />
                    <x-usuario.administrativo.publicaciones.modal-eliminar :tipo=$tipo :i="$i" :publicacion="$publicacion" />
            @endforeach
        </tbody>
    </table>
</div>