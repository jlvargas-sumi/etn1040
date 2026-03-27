@guest
    <div class="sesion"><a href="{{ route('iniciar-sesion') }}" class="waves-effect waves-light fondo-principal-1 btn"><span class="contenedor-icono"><i class="white-text material-icons izquierda">account_circle</i><span>Iniciar sesión</span></span></a></div>
@endguest

@auth
    @if(!empty(session('nombreFotoPerfil')))
        @php
            $nombreArchivo = session('nombreFotoPerfil'); // ← String con el nombre del archivo
            $rutaFotoPerfil = public_path().'/storage/fotos/usuarios/'.$nombreArchivo; // ← Usar directamente el string
        @endphp
        @if (file_exists($rutaFotoPerfil))
        <div id="usuario" class="sesion"><button class="waves-effect waves-light fondo-principal-1 btn hover-90"><img src="{{ asset('storage/fotos/usuarios/'.$nombreArchivo) }}" alt=""></button></div>    
        @else
            <div id="usuario" class="sesion"><button class="waves-effect waves-light fondo-principal-1 btn hover-90"><i class="material-icons">account_circle</i></button></div>
        @endif
    @else
        <div id="usuario" class="sesion"><button class="waves-effect waves-light fondo-principal-1 btn hover-90"><i class="material-icons">account_circle</i></button></div>
    @endif  
@endauth