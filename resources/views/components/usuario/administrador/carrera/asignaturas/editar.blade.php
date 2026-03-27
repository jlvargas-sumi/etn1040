<div id="modal-editar-asignatura" class="modal">
    <div class="modal-content">
        <span class="subtitulo">Editar datos</span>
        <form action="{{route('administrador.asignaturas.actualizar')}}" method="POST" id="actualizar-asignatura">
            @csrf
            <input type="hidden" name="id" id="id" class="validate" required>
            <input type="hidden" name="mencion_id" id="mencion-id" value="{{$mencionId}}" class="validate" required>
            <div class="tabla-s tabla-borde">
                <table>
                    <thead>
                        <tr>
                            <th colspan="2">Campo</th>
                            <th>Datos Actuales</th>
                            <th>Datos Confirmados</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">Plan de Estudios</td>
                            <td id="plan-estudios-id-actual">
                                <select disabled required>
                                    @foreach ($planesEstudios as $_planEstudios)
                                        @if ($_planEstudios->plan_estudio_id == $planEstudiosId)
                                            <option value="{{$_planEstudios->plan_estudio_id}}" {{$_planEstudios->plan_estudio_id == $planEstudiosId ? "selected":""}}>{{$_planEstudios->plan_estudio_nombre}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select id="plan-estudios-id" name="plan_estudios_id" required>
                                    @foreach ($planesEstudios as $_planEstudios)
                                        @if ($_planEstudios->plan_estudio_id == $planEstudiosId)
                                            <option value="{{$_planEstudios->plan_estudio_id}}" {{$_planEstudios->plan_estudio_id == $planEstudiosId ? "selected":""}}>{{$_planEstudios->plan_estudio_nombre}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Sigla</td>
                            <td id="sigla-actual"></td>
                            <td><input type="text" name="sigla" id="sigla" class="validate" required></td>
                        </tr>
                        <tr>
                            <td colspan="2">Asignatura</td>
                            <td id="asignatura-actual"></td>
                            <td><input type="text" name="asignatura" id="asignatura" class="validate" required></td>
                        </tr>
                        <tr>
                            <td colspan="2">Laboratorio</td>
                            <td id="laboratorio-actual"><i class="material-icons"></i></td>
                            <td>
                                <div>
                                    <p>
                                        <label>
                                            <input type="checkbox" name="laboratorio" />
                                            <span>Laboratorio</span>
                                        </label>
                                    </p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Auxiliatura</td>
                            <td id="auxiliatura-actual"><i class="material-icons"></i></td>
                            <td>
                                <div>
                                    <p>
                                        <label>
                                            <input type="checkbox" name="auxiliatura" />
                                            <span>Auxiliatura</span>
                                        </label>
                                    </p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="center">
                                <button type="submit" class="btn waves-effect waves-light">Actualizar datos</button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat red white-text hover-70">Salir</a>
    </div>
</div>