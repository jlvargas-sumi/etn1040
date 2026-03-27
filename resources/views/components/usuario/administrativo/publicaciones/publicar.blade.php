<div class="titulo-formal subtitulo">Publicar {{ $tipo }}</div>
<form action="{{ route('administrativo.publicaciones.publicar') }}" method="POST" enctype="multipart/form-data" class="datos-formales">
    @csrf
    <input type="hidden" name="tipo" value="{{ $tipo }}">
    <div class="row">
        @if ($tipo == 'Comunicado' || $tipo == 'Convocatoria')
            <div class="input-field col s12 m4 l4">
                <i class="material-icons prefix">title</i>
                <input type="text" name="numero" placeholder="Comu-010-2026" required id="numero" class="validate">
                <label for="numero">Número</label>
                @error('numero')
                    <span class="helper-text mensaje-error">{{ $message }}</span>
                @enderror
            </div>
        @else
            <div class="input-field col s12 m4 l4">
                <i class="material-icons prefix">title</i>
                <select name="tipo_anuncio" required>
                    <option value="Pasantía">Pasantía</option>
                    <option value="Invitación">Invitación</option>
                    <option value="Otros">Otros</option>
                </select>
                <label >Tipo Anuncio</label>
                @error('tipo_anuncio')
                    <span class="helper-text mensaje-error">{{ $message }}</span>
                @enderror
            </div>
        @endif
        <div class="input-field col s12 m8 l8">
            <i class="material-icons prefix">auto_stories</i>
            <input type="text" name="titulo" placeholder="Convocatoria/Comunicado para docentes" required id="titulo" class="validate">
            <label for="titulo">Título</label>
            @error('titulo')
                <span class="helper-text mensaje-error">{{ $message }}</span>
            @enderror
        </div>
        <div class="file-field input-field col s12 m12 l12">
            <div class="btn hover-80">
                <span>Seleccionar archivo</span>
                <input type="file" name="archivo" required>
            </div>
            <div class="file-path-wrapper">
                <input type="text" name="nombre" placeholder="Arrastrar y soltar" required class="file-path validate">
                @error('archivo')
                    <span class="helper-text mensaje-error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="file-path-wrapper col s12 m12 l12">
            <button type="submit" class="btn waves-effect waves-light fondo-principal-1 hover-80 col s12 m4 push-m4  l4 push-l4">Publicar</button>
        </div>
    </div>
</form>
