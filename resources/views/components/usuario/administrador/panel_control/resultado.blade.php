<div class="tabla-s">
    <table id="tabla">
        <thead>
            <tr>
                <th>N°</th>
                <th>Gestión</th>
                <th>Periodo</th>
                <th>Apertura</th>
                <th>Inscripción</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($panelControl as $i => $_panelControl)
                <tr>
                    <td>{{$i+1}}</td>
                    <td>{{$_panelControl->periodo_gestion}}</td>
                    <td>{{$_panelControl->periodo_nombre}}</td>
                    <td>
                        @if ($_panelControl->panel_control_apertura === 1)
                            <div class="flex f-jcc">
                                <div class="input-field">
                                    <select id="plan-estudio-id" name="plan_estudio_id" disabled required>
                                        @foreach ($planesEstudios as $planEstudios)
                                            <option value="{{$planEstudios->plan_estudio_id}}" {{$planEstudios->plan_estudio_nombre == $_panelControl->plan_estudio_nombre ? "selected":""}}>{{$planEstudios->plan_estudio_nombre}}</option>
                                        @endforeach
                                    </select>
                                    <label for="plan-estudio-id">Plan de Estudio</label>
                                </div>
                                <span><i class="material-icons teal-text">check</i></span>
                            </div>
                        @else
                            <form action="{{route('administrador.panel-control.habilitar-apertura')}}" class="flex f-jcc" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{$_panelControl->panel_control_id}}" required>
                                <input type="hidden" name="gestion" value="{{$_panelControl->periodo_gestion}}" required>
                                <input type="hidden" name="periodo" value="{{$_panelControl->periodo_nombre}}" required>
                                
                                <div class="input-field">
                                    <select id="plan-estudio-id" name="plan_estudio_id" {{$_panelControl->panel_control_inscripcion === 1 ? "disabled":""}} required>
                                        @foreach ($planesEstudios as $planEstudios)
                                            <option value="{{$planEstudios->plan_estudio_id}}" {{$planEstudios->plan_estudio_nombre == $_panelControl->plan_estudio_nombre ? "selected":""}}>{{$planEstudios->plan_estudio_nombre}}</option>
                                        @endforeach
                                    </select>
                                    <label for="plan-estudio-id">Plan de Estudios</label>
                                </div>
                                <button class="sin-estilo btn-rojo" title="Habilitar"><i class="material-icons">check_box_outline_blank</i></button>
                            </form>
                        @endif
                    </td>
                    <td>
                        @if ($_panelControl->panel_control_apertura === 1)
                            @if ($_panelControl->panel_control_inscripcion === 1)
                                <form action="{{route('administrador.panel-control.deshabilitar-inscripcion')}}" class="flex f-jcc" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$_panelControl->panel_control_id}}" required>
                                    <input type="hidden" name="gestion" value="{{$_panelControl->periodo_gestion}}" required>
                                    <input type="hidden" name="periodo" value="{{$_panelControl->periodo_nombre}}" required>
                                    
                                    <button class="sin-estilo btn-verde" title="Deshabilitar"><i class="material-icons fz-xl">toggle_on</i></button>
                                </form>
                            @else
                                <form action="{{route('administrador.panel-control.habilitar-inscripcion')}}" class="flex f-jcc" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$_panelControl->panel_control_id}}" required>
                                    <input type="hidden" name="gestion" value="{{$_panelControl->periodo_gestion}}" required>
                                    <input type="hidden" name="periodo" value="{{$_panelControl->periodo_nombre}}" required>
                                    
                                    <button class="sin-estilo btn-gris" title="Habilitar"><i class="material-icons fz-xl">toggle_off</i></button>
                                </form>
                            @endif
                        @else
                            <span><i class="material-icons grey-text">block</i></span>
                        @endif
                    </td>
                    <td>
                        @if ($_panelControl->panel_control_estado === 1)
                            <span><i class="material-icons btn-verde">radio_button_checked</i></span>
                        @else
                            <form action="{{route('administrador.panel-control.habilitar-periodo')}}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{$_panelControl->panel_control_id}}" required>
                                <input type="hidden" name="gestion" value="{{$_panelControl->periodo_gestion}}" required>
                                <input type="hidden" name="periodo" value="{{$_panelControl->periodo_nombre}}" required>
                                <button class="sin-estilo btn-gris" title="Habilitar"><i class="material-icons">radio_button_unchecked</i></button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>