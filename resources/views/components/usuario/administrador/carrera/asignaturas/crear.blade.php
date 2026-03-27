<a href="#modal-crear-asignatura" title="Crear Asignatura" class="modal-trigger btn-floating btn-medium waves-effect waves-light green modal-crear-asignatura"><i class="material-icons">add</i></a>

<div id="modal-crear-asignatura" class="modal">
    <div class="modal-content">
        <h4>Crear Asignatura</h4>
        <form action="{{route('administrador.asignaturas.crear')}}" method="POST" id="crear-asignatura">
            @csrf
            <input type="hidden" name="mencion_id" value="{{$mencionId}}" required>
            <div class="row">
                <div class="input-field col s6 m3">
                    <select id="plan-estudios-id" name="plan_estudios_id" required>
                        @foreach ($planesEstudios as $_planEstudios)
                            @if ($_planEstudios->plan_estudio_id == $planEstudiosId)
                                <option value="{{$_planEstudios->plan_estudio_id}}" {{$_planEstudios->plan_estudio_id == $planEstudiosId ? "selected":""}}>{{$_planEstudios->plan_estudio_nombre}}</option>
                            @endif
                        @endforeach
                    </select>
                    <label for="plan-estudios-id">Plan de Estudio</label>
                </div>
                <div class="input-field col s6 m3">
                    <input type="text" name="sigla" placeholder="ETN 601" required>
                    <label>Sigla</label>
                </div>
                <div class="input-field col s12 m6">
                    <input type="text" name="asignatura" placeholder="SISTEMAS DIGITALES I" required>
                    <label>Asignatura</label>
                </div>
                @foreach ($menciones as $_mencion)
                    <div class="col s12">
                        <p>
                            <label>
                                <input type="checkbox" class="seleccionar-mencion" id="mencion-{{$_mencion->mencion_id}}" name="menciones_id[{{$_mencion->mencion_id}}]" />
                                <span>Mención {{$_mencion->mencion_nombre}}</span>
                            </label>
                        </p>
                        <div class="col s3">
                            <label for="semestre-{{$_mencion->mencion_id}}">Semestre</label>
                            <select id="semestre-{{$_mencion->mencion_id}}" name="semestres_id[{{$_mencion->mencion_id}}]" class="browser-default" disabled required>
                                @foreach ($semestres as $semestre)
                                    <option value="{{$semestre->semestre_id}}">{{$semestre->semestre_numerico}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-field col s5 comentario-prerrequisito">
                            <input type="text" name="comentarios_prerrequisito[{{$_mencion->mencion_id}}]" id="comentario-prerrequisito-{{$_mencion->mencion_id}}" placeholder="Aprobar 5 materias" class="validate" disabled required >
                            <label>Prerrequisito</label>
                        </div>
                        <div class="col s5">
                            <label for="asignatura-id-prerrequisito-{{$_mencion->mencion_id}}">Prerrequisito</label>
                            <select id="asignatura-id-prerrequisito-{{$_mencion->mencion_id}}" class="browser-default" name="asignaturas_id_prerrequisito[{{$_mencion->mencion_id}}]" disabled required>
                                @foreach ($asignaturasGeneral as $asignatura)
                                    <option value="{{$asignatura->asignatura_id}}">(Sem. {{$asignatura->semestre_numerico}}) {{$asignatura->asignatura_sigla}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-field col s4">
                            <p>
                                <label>
                                    <input type="checkbox" class="prerrequisito validate" id="prerrequisito-{{$_mencion->mencion_id}}" name="prerrequisitos[{{$_mencion->mencion_id}}]" disabled/>
                                    <span>Solo texto</span>
                                </label>
                            </p>
                        </div>
                    </div>
                @endforeach
                <div class="input-field col s12 flex f-jcc opcion-prerrequisito">
                    <div>
                        <p>
                            <label>
                                <input type="checkbox" name="laboratorio" />
                                <span>Laboratorio</span>
                            </label>
                        </p>
                    </div>
                    <div>
                        <p>
                            <label>
                                <input type="checkbox" name="auxiliatura" />
                                <span>Auxiliatura</span>
                            </label>
                        </p>
                    </div>
                </div>
                <div class="row col s12">
                    <button type="submit" class="col s6 push-s3 btn waves-effect waves-light">Crear</button>
                </div>
              </div>
          </form>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-red btn-small red">Salir</a>
    </div>
</div>
