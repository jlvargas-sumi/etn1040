<span class="subtitulo">Plantel Auxiliar</span>
<div class="contenido-auxiliares">
    @foreach ($auxiliares as $auxiliar)
        <div class="tarjeta-auxiliar">
            <div class="foto">
                @php
                    $rutaFoto = public_path() . '/storage/fotos/auxiliares/' . $auxiliar->persona_ci . '.png';
                    $fotoActiva = asset('storage/fotos/auxiliares/' . $auxiliar->persona_ci . '.png');
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
                <span>Univ. {{ $auxiliar->persona_nombres }}</span>
                <span>{{ $auxiliar->persona_primer_apellido }} {{ $auxiliar->persona_segundo_apellido }}</span>
            </div>
        </div>
    @endforeach
</div>
