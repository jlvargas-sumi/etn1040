@php   
    $fotoPerfilPredeterminado = asset('storage/fotos/Foto_predeterminado.jpg');
    if (!empty(session('nombreFotoPerfil'))) {
        $nombreArchivo = session('nombreFotoPerfil'); // ← Ya es string, no objeto
        $rutaFotoPerfil = public_path().'/storage/fotos/usuarios/'.$nombreArchivo;
        $recursoFotoPerfil = asset('storage/fotos/usuarios/'.$nombreArchivo);
                        
        if (file_exists($rutaFotoPerfil)) {
            $nombreFotoPerfil = $recursoFotoPerfil;
        } else {
            $nombreFotoPerfil = $fotoPerfilPredeterminado;
        }
    } else {
        $nombreFotoPerfil = $fotoPerfilPredeterminado;
    } 
@endphp

<div id="foto-perfil">
    <span>Subir Foto</span>
    <img src="{{ $nombreFotoPerfil }}" alt="Subir foto de perfil">
</div>
<div class="contenedor-modal row">
    <div id="subir-foto-perfil" class="col s10 m8 l8 ">
        <span>Subir Foto</span>
        <i class="material-icons color-secundario-4 hover-80">cancel</i>
        <form action="{{ route('perfil.subir-foto') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="file-field input-field">
                <div class="btn hover-80">
                    <span>Seleccionar</span>
                    <input type="file" name="foto" required>
                </div>
                <div class="file-path-wrapper">
                    <input type="text" name="nombre" placeholder="Arrastrar y soltar" required class="file-path validate">
                    @error('foto')
                        <span class="helper-text mensaje-error">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn-small waves-effect waves-light fondo-principal-1 hover-80 col s4 push-s2 m4 push-m2 l4 push-l2">Subir</button>
                <button type="reset" class="btn-small waves-effect waves-light fondo-principal-4 hover-80 col s4 push-s2 m4 push-m2 l4 push-l2">Reiniciar</button>
            </div>
        </form>
    </div>
</div>