<div class="tabla">
    <table id="tabla">
        <thead>
            <tr>
                <th>N°</th>
                <th>C.I.</th>
                <th>Apellido P.</th>
                <th>Apellido M.</th>
                <th>Nombres</th>
                <th>Celular</th>
                <th>Correo-e</th>
                <th>Cargo</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($administrativos as $i => $administrativo)
                <tr>
                    <td>{{$i+1}}</td>
                    <td>{{$administrativo->persona_ci}}</td>
                    <td>{{$administrativo->persona_primer_apellido}}</td>
                    <td>{{$administrativo->persona_segundo_apellido}}</td>
                    <td>{{$administrativo->persona_nombres}}</td>
                    <td>{{$administrativo->celular_numero}}</td>
                    <td>{{$administrativo->correo_direccion}}</td>
                    <td>{{$administrativo->cargo_nombre}}</td>
                    <td>
                        <div class="flex f-nw m0">
                            <a href="#modal-editar-datos-administrativo" 
                                data-id="{{$administrativo->administrativo_id}}"
                                data-ci="{{$administrativo->persona_ci}}"
                                data-primer_apellido="{{$administrativo->persona_primer_apellido}}"
                                data-segundo_apellido="{{$administrativo->persona_segundo_apellido}}"
                                data-nombres="{{$administrativo->persona_nombres}}"
                                data-celular="{{$administrativo->celular_numero}}"
                                data-correo="{{$administrativo->correo_direccion}}"
                                data-cargo="{{$administrativo->cargo_nombre}}"
                                data-cargo_id="{{$administrativo->cargo_id}}"
                                class="modal-trigger btn-celeste editar-datos-administrativo" 
                                title="Editar datos">
                                <i class="material-icons">edit</i>
                            </a>
                            @if ($administrativo->administrativo_estado == 1)
                                <form action="{{route('administrador.administrativos.inhabilitar')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$administrativo->administrativo_id}}" required>
                                    <input type="hidden" name="ci" value="{{$administrativo->persona_ci}}" required>
                                    <button class="sin-estilo btn-verde" title="Inhabilitar"><i class="material-icons">person</i></button>
                                </form>
                            @else
                                <form action="{{route('administrador.administrativos.habilitar')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$administrativo->administrativo_id}}" required>
                                    <input type="hidden" name="ci" value="{{$administrativo->persona_ci}}" required>
                                    <button class="sin-estilo btn-gris" title="Habilitar"><i class="material-icons">person_off</i></button>
                                </form>
                            @endif
                            <a href="#modal-eliminar-administrativo" 
                                data-id="{{$administrativo->administrativo_id}}"
                                data-ci="{{$administrativo->persona_ci}}"
                                data-primer_apellido="{{$administrativo->persona_primer_apellido}}"
                                data-segundo_apellido="{{$administrativo->persona_segundo_apellido}}"
                                data-nombres="{{$administrativo->persona_nombres}}"
                                class="modal-trigger btn-rojo eliminar-administrativo" 
                                title="Eliminar">
                                <i class="material-icons">delete</i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<x-usuario.administrador.personal.administrativos.editar :cargos=$cargos />
<x-usuario.administrador.personal.administrativos.eliminar />
