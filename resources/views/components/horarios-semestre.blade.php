<ul class="collapsible semestres">
    @php
        $i = 0;
    @endphp
    @foreach ($horariosSemestres as $horarioSemestre)
        @php
            $i = $i + 1;
            $rutaArchivo = public_path().'/storage/horarios/semestre/'.$horarioSemestre->horario_seme_archivo;
            $recursoArchivo = asset('storage/horarios/semestre/'.$horarioSemestre->horario_seme_archivo);       
        @endphp
        @if (file_exists($rutaArchivo))
            @if ($horarioSemestre->semestre_numerico >= 7)
                @php
                    $mencion = '(Mención: '.$horarioSemestre->mencion_nombre.')';
                @endphp
            @else
                @php
                    $mencion = "";
                @endphp
            @endif
            <li data-plegable="#plegable_{{ $i }}" id="plegable_{{ $i }}" class="ver-archivo">
                <input type="hidden" name="recurso_archivo" value="{{ $recursoArchivo }}">
                <div class="collapsible-header"><i class="material-icons">workspace_premium</i>({{ $horarioSemestre->semestre_numerico }}) {{ $horarioSemestre->semestre_ordinal }} semestre {{ $mencion }}</div>
                <div class="collapsible-body">
                    <iframe frameborder="0"></iframe>
                </div>
            </li>
        @endif 
    @endforeach
</ul>