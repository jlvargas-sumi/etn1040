<div class="tabla-s">
    <table id="tabla">
        <thead>
            <th>N°</th>
            <th>Semestre</th>
            <th>Asignatura</th>
            <th>Paralelo</th>
        </thead>
        <tbody>
            @foreach ($auxiliaturas as $i => $auxiliatura)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $auxiliatura['semestre'] }}</td>
                    <td>{{ $auxiliatura['asignatura'] }} {{mb_strtoupper($auxiliatura['campo'], "UTF-8") == "LABORATORIO" ? "(".strtoupper($auxiliatura['campo']).")":""}}
                        <br><strong>{{ $auxiliatura['sigla'] }} {{mb_strtoupper($auxiliatura['campo'], "UTF-8") == "LABORATORIO" ? "(L)":""}}</strong>
                        <br><strong class="red-text">{{ $auxiliatura['auxiliatura'] == 0 ? "Sin auxiliatura":"" }}</strong>
                    </td>
                    <td>
                        <ul class="collection">
                            @foreach ($auxiliatura['paralelos'] as $paralelo)
                                <li class="collection-item flex">
                                    <div class="input-field w-50">
                                        <input type="text" value="{{ $paralelo['paralelo'] }}" class="center" disabled>
                                        <label>Paralelo</label>
                                    </div>
                                    <ul class="collection">
                                        @foreach ($paralelo['grupos'] as $i => $grupo)
                                        <form action="{{ route('administrador.auxiliaturas.actualizar') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="plan_estudios_id" value="{{$planEstudiosId}}" required >
                                            <input type="hidden" name="mencion_id" value="{{$mencionId}}" required >
                                            <input type="hidden" name="periodo" value="{{$periodo}}" required >
                                            <input type="hidden" name="gestion" value="{{$gestion}}" required >
                                            <input type="hidden" name="sigla" value="{{ $auxiliatura['sigla'] }} {{$auxiliatura['campo'] == 'Laboratorio' ? "(L)":""}}" required >
                                            <input type="hidden" name="paralelo" value="{{ $paralelo['paralelo'] }}" required>
                                            <input type="hidden" name="grupo" value="{{ $grupo['grupo'] }}" required>
                                            <input type="hidden" name="apertura_id" value="{{ $grupo['aperturaId'] }}" required>

                                            <li class="collection-item flex">
                                                    <div class="input-field">
                                                        <span class="center">Grupo_{{ $grupo['grupo'] }}</span>
                                                        <div class="flex">
                                                            @if ($i != 0)
                                                                <a href="#modal-editar-grupo" title="Editar grupo" class="btn-celeste modal-editar-grupo modal-trigger" 
                                                                    data-id="{{ $paralelo['aperturaId']}}" 
                                                                    data-grupo="{{ $grupo['grupo']}}" 
                                                                    data-paralelo="{{ $paralelo['paralelo']}}" 
                                                                    data-sigla="{{ $auxiliatura['sigla'] }} {{$auxiliatura['campo'] == 'Laboratorio' ? "(L)":""}}" 
                                                                    >
                                                                    <span class="contenedor-icono"><i class="material-icons">edit</i></span></a>
                                                                <a href="#modal-eliminar-grupo" title="Eliminar grupo" class="btn-rojo modal-eliminar-grupo modal-trigger" 
                                                                    data-id="{{ $paralelo['aperturaId']}}" 
                                                                    data-grupo="{{ $grupo['grupo']}}" 
                                                                    data-paralelo="{{ $paralelo['paralelo']}}" 
                                                                    data-sigla="{{ $auxiliatura['sigla'] }} {{$auxiliatura['campo'] == 'Laboratorio' ? "(L)":""}}" 
                                                                    >
                                                                    <span class="contenedor-icono"><i class="material-icons">delete</i></span></a>
                                                            @endif
                                                            @if (count($paralelo['grupos']) == $i+1)
                                                                <a href="#modal-crear-grupo" title="Crear grupo" class="btn-verde modal-crear-grupo modal-trigger" 
                                                                    data-id="{{ $paralelo['aperturaId']}}" 
                                                                    data-paralelo="{{ $paralelo['paralelo']}}" 
                                                                    data-sigla="{{ $auxiliatura['sigla'] }} {{$auxiliatura['campo'] == 'Laboratorio' ? "(L)":""}}" 
                                                                    >
                                                                    <span class="contenedor-icono"><i class="material-icons">add_circle</i></span>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label>Auxiliar</label>
                                                        <select name="auxiliar_id" class="browser-default w-100">
                                                            <option value="" selected>Ninguno</option>
                                                            @foreach ($auxiliares as $auxiliar)
                                                                <option value="{{ $auxiliar->auxiliar_id }}" {{ $auxiliar->auxiliar_id == $grupo['auxiliarId'] ? "selected":"" }}>{{ $auxiliar->persona_nombres }} {{ $auxiliar->persona_primer_apellido }} {{ $auxiliar->persona_segundo_apellido }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <ul class="collection">
                                                        @foreach ($grupo['clases'] as $i => $clase)
                                                            <li class="collection-item flex">
                                                                <div class="input-field">
                                                                    <input type="hidden" name="clases[]" value="{{ $clase['clase'] }}" min="1" max="10" step="1" class="center" required>
                                                                    {{-- <input type="number" value="{{ $clase['clase'] }}" class="center" disabled>
                                                                    <label>Clase</label> --}}
                                                                </div>
                                                                <div>
                                                                    {{-- <input type="text" name="dias[]" id="dia-{{ $i }}" value="{{ $clase['dia'] }}" placeholder="Lunes"> --}}
                                                                    <label for="dia-{{ $i }}">Día</label>
                                                                    <select name="dias[]" id="dia-{{ $i }}" class="browser-default w-100">
                                                                        <option value="" selected>Ninguno</option>
                                                                        <option value="Lunes" {{ $clase['dia'] == "Lunes" ? "selected":"" }}>Lunes</option>
                                                                        <option value="Martes" {{ $clase['dia'] == "Martes" ? "selected":"" }}>Martes</option>
                                                                        <option value="Miércoles" {{ $clase['dia'] == "Miércoles" ? "selected":"" }}>Miércoles</option>
                                                                        <option value="Jueves" {{ $clase['dia'] == "Jueves" ? "selected":"" }}>Jueves</option>
                                                                        <option value="Viernes" {{ $clase['dia'] == "Viernes" ? "selected":"" }}>Viernes</option>
                                                                        <option value="Sábado" {{ $clase['dia'] == "Sábado" ? "selected":"" }}>Sábado</option>
                                                                    </select>
                                                                </div>
                                                                <div class="input-field">
                                                                    <input type="time" name="horas_inicio[]" id="hora-inicio-{{ $i }}" value="{{ $clase['horaInicio'] }}">
                                                                    <label for="hora-inicio-{{ $i }}">Inicio</label>
                                                                </div>
                                                                <div class="input-field">
                                                                    <input type="time" name="horas_fin[]" id="hora-fin" value="{{ $clase['horaFin'] }}">
                                                                    <label for="hora-fin">Fin</label>
                                                                </div>
                                                                <div>
                                                                    <label>Aula</label>
                                                                    <select name="aulas_id[]" class="browser-default w-100">
                                                                        <option value="" selected>Ninguno</option>
                                                                        @foreach ($aulas as $aula)
                                                                            <option value="{{ $aula->aula_id }}" {{ $aula->aula_id == $clase['aulaId'] ? "selected":"" }}>{{ $aula->aula_nombre }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                    <button type="submit" class="sin-estilo btn-verde" title="Guardar"><i class="material-icons">save</i></button>
                                                </li>
                                            </form>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<x-usuario.administrador.inscripcion.auxiliaturas.crear-grupo :planEstudiosId=$planEstudiosId :mencionId=$mencionId :periodo=$periodo :gestion=$gestion />
<x-usuario.administrador.inscripcion.auxiliaturas.editar-grupo :planEstudiosId=$planEstudiosId :mencionId=$mencionId :periodo=$periodo :gestion=$gestion />
<x-usuario.administrador.inscripcion.auxiliaturas.eliminar-grupo :planEstudiosId=$planEstudiosId :mencionId=$mencionId :periodo=$periodo :gestion=$gestion />