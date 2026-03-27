<ul class="collapsible aulas">
    @php
        $i = 0;
    @endphp
    @foreach ($horariosAulas as $horarioAula)
        @php
            $i = $i + 1;
            $rutaArchivo = public_path().'/storage/horarios/aula/'.$horarioAula->horario_aula_archivo;
            $recursoArchivo = asset('storage/horarios/aula/'.$horarioAula->horario_aula_archivo);       
        @endphp
        @if (file_exists($rutaArchivo))
            <li data-plegable="#plegable_{{ $i }}" id="plegable_{{ $i }}" class="ver-archivo">
                <input type="hidden" name="recurso_archivo" value="{{ $recursoArchivo }}">
                <div class="collapsible-header"><i class="material-icons">door_front</i>{{ $horarioAula->aula_nombre }}</div>
                <div class="collapsible-body">
                    <iframe frameborder="0"></iframe>
                </div>
            </li>
        @endif 
    @endforeach
</ul>
