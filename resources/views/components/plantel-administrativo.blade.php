<span class="subtitulo">Plantel Administrativo</span>
    @php
        $administrativos1 = $administrativos;
        $administrativos2 = $administrativos;
    @endphp
<div class="contenido-administrativos">
    @foreach ($administrativos1 as $administrativo)
        @if ($administrativo->cargo_nombre == "Director")
            <div class="tarjeta-administrativo">
                <div class="foto">
                    @php
                        $rutaFoto = public_path() . '/storage/fotos/administrativos/' . $administrativo->persona_ci . '.png';
                        $fotoActiva = asset('storage/fotos/administrativos/' . $administrativo->persona_ci . '.png');
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
                    <span>Ing. {{ $administrativo->persona_nombres }}</span>
                    <span>{{ $administrativo->persona_primer_apellido }} {{ $administrativo->persona_segundo_apellido }}</span>
                    <span>{{ $administrativo->cargo_nombre }} de Carrera</span>
                </div>
            </div>
        @endif
    @endforeach
</div>
<div class="contenido-administrativos">
    @foreach ($administrativos2 as $administrativo)
        @if ($administrativo->cargo_nombre != "Director")
            <div class="tarjeta-administrativo">
                <div class="foto">
                    @php
                        $rutaFoto = public_path() . '/storage/fotos/administrativos/' . $administrativo->persona_ci . '.png';
                        $fotoActiva = asset('storage/fotos/administrativos/' . $administrativo->persona_ci . '.png');
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
                    <span>{{ $administrativo->persona_nombres }}</span>
                    <span>{{ $administrativo->persona_primer_apellido }} {{ $administrativo->persona_segundo_apellido }}</span>
                    <span>{{ $administrativo->cargo_nombre }}</span>
                </div>
            </div>
        @endif
    @endforeach
</div>
