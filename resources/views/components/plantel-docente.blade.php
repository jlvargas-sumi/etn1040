<span class="subtitulo">Plantel Docente</span>
<div class="contenido-docentes">
    @foreach ($docentes as $docente)
        <div class="tarjeta-docente">
            <div class="foto">
                @php
                    $rutaFoto = public_path() . '/storage/fotos/docentes/' . $docente->persona_ci . '.png';
                    $fotoActiva = asset('storage/fotos/docentes/' . $docente->persona_ci . '.png');
                    $fotoPredeterminado = asset('storage/fotos/foto_predeterminado.png');
                    
                    if (file_exists($rutaFoto)) {
                        $nombreFoto = $fotoActiva;
                    } else {
                        $nombreFoto = $fotoPredeterminado;
                    }
                @endphp
                <img src="{{ $nombreFoto }}" alt="">
            </div>

            <div class="datos">
                <span>Ing. {{ $docente->persona_nombres }}</span>
                <span>{{ $docente->persona_primer_apellido }} {{ $docente->persona_segundo_apellido }}</span>
            </div>
        </div>
    @endforeach
</div>
