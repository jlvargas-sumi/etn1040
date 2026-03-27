<div id="modal-editar-{{ $i }}" class="modal modal-editar">
    <div class="modal-content">
        <div class="titulo-formal subtitulo">Publicar {{ $tipo }}</div>
        <form action="{{ route('administrativo.publicaciones.actualizar') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="tipo" value="{{ $tipo }}">
            <input type="hidden" name="publicacion_id" value="{{ $publicacion->publicacion_id }}" required>
            <div class="row datos-formales">
                @if ($tipo == 'Comunicado' || $tipo == 'Convocatoria')
                    <div class="input-field col s12 m4 l4">
                        <i class="material-icons prefix">title</i>
                        <input type="text" name="actualizar_numero" value="{{ $publicacion->publicacion_numero }}" placeholder="Comu-010-2023" required id="actualizar-numero" class="validate">
                        <label for="actualizar-numero">Número</label>
                        @error('actualizar_numero')
                            <span class="helper-text mensaje-error">{{ $message }}</span>
                        @enderror
                    </div>
                @else
                    <div class="col s12 m4 l4">
                        <label for="actualizar-tipo-anuncio">Tipo Anuncio</label>
                        <select name="actualizar_tipo_anuncio" id="actualizar-tipo-anuncio" class="browser-default" required>
                            <option value="Pasantía">Pasantía</option>
                            <option value="Invitación">Invitación</option>
                            <option value="Otros">Otros</option>
                        </select>
                        @error('actualizar_tipo_anuncio')
                            <span class="helper-text mensaje-error">{{ $message }}</span>
                        @enderror
                    </div>
                @endif
                <div class="input-field col s12 m8 l8">
                    <i class="material-icons prefix">auto_stories</i>
                    <input type="text" name="actualizar_titulo" value="{{ $publicacion->publicacion_titulo }}" placeholder="Comunicado auxiliares 10" required id="titulo" class="validate">
                    <label for="titulo">Título</label>
                    @error('actualizar_titulo')
                        <span class="helper-text mensaje-error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field col s12 m8 l8">
                    <i class="material-icons prefix">insert_drive_file</i>
                    <input type="text" name="archivo_actual" value="{{ $publicacion->publicacion_archivo }}" disabled required id="archivo_actual" class="validate">
                    <label for="archivo_actual">Archivo</label>
                </div>
                <div class="input-field col s12 m4 l4">
                    <span>Subir otro Archivo</span>
                    <div class="switch">
                        <label>
                            No
                            <input type="hidden" name="otro_archivo" value="0">
                            <input type="checkbox" name="otro_archivo" value="1" id="otro-archivo" data-modal="#modal-editar-{{ $i }}">
                            <span class="lever"></span>
                            Si
                        </label>
                    </div>
                </div>
                <div class="file-field input-field col s12 m12 l12 otro-archivo">
                    <div class="btn hover-80">
                        <span>Seleccionar archivo</span>
                        <input type="file" name="actualizar_archivo">
                    </div>
                    <div class="file-path-wrapper">
                        <input type="text" name="actualizar_nombre" placeholder="Arrastrar y soltar" class="file-path validate">
                        @error('actualizar_archivo')
                            <span class="helper-text mensaje-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="file-path-wrapper col s12 m12 l12">
                    <button type="submit" class="btn waves-effect waves-light fondo-principal-1 hover-80 col s12 m4 push-m2  l4 push-l2">Actualizar</button>
                    <a href="#!" class="modal-close btn waves-effect waves-green fondo-secundario-4 hover-80 col s12 m4 push-m2  l4 push-l2">Cancelar</a>
                </div>
            </div>
        </form>  
    </div>
</div>