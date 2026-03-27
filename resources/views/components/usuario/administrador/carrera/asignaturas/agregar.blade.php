<div class="row">
    <span class="subtitulo">Agregar</span>
    <div class="col s12">
        <form action="{{route('administrador.asignaturas.agregar')}}" method="POST" id="agregar-asignatura">
            @csrf
            <input type="hidden" name="plan_estudios_id" value="{{$planEstudiosId}}" required>
            <input type="hidden" name="mencion_id" value="{{$mencionId}}" required>
            <div class="col s12">
                <div class="col s7 m3">
                    <label for="asignatura">Asignatura</label>
                    <select id="asignatura" class="browser-default" name="asignatura_id" required>
                        @foreach ($asignaturasGeneral as $asignatura)
                            <option value="{{$asignatura->asignatura_id}}">(Sem. {{$asignatura->semestre_numerico}}) {{$asignatura->asignatura_sigla}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col s5 m2">
                    <label for="semestre">Semestre</label>
                    <select id="semestre" name="semestre_id" class="browser-default" required>
                        @foreach ($semestres as $semestre)
                            <option value="{{$semestre->semestre_id}}">{{$semestre->semestre_numerico}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-field col s7 m3 comentario-prerrequisito">
                    <input type="text" name="comentario_prerrequisito" id="comentario-prerrequisito" placeholder="Aprobar 5 materias" class="validate" disabled  >
                    <label>Prerrequisito</label>
                </div>
                <div class="col s7 m3">
                    <label for="asignatura-id-prerrequisito">Prerrequisito</label>
                    <select id="asignatura-id-prerrequisito" class="browser-default" name="asignatura_id_prerrequisito"  required>
                        @foreach ($asignaturasGeneral as $asignatura)
                            <option value="{{$asignatura->asignatura_id}}">(Sem. {{$asignatura->semestre_numerico}}) {{$asignatura->asignatura_sigla}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-field col s5 m2">
                    <p>
                        <label>
                            <input type="checkbox" class="prerrequisito validate" id="prerrequisito" name="prerrequisito" />
                            <span>Solo texto</span>
                        </label>
                    </p>
                </div>
                <div class="input-field col s12 m2">
                    <button type="submit" class="btn waves-effect waves-light">Agregar</button>
                </div>
            </div>
        </form>
    </div>
</div>