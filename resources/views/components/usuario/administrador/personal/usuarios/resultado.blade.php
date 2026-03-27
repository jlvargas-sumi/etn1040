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
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $i => $usuario)
                <tr>
                    <td>{{$i+1}}</td>
                    <td>{{$usuario->persona_ci}}</td>
                    <td>{{$usuario->persona_primer_apellido}}</td>
                    <td>{{$usuario->persona_segundo_apellido}}</td>
                    <td>{{$usuario->persona_nombres}}</td>
                    <td>{{$usuario->celular_numero}}</td>
                    <td>{{$usuario->correo_direccion}}</td>
                    <td>
                        <div class="flex f-nw m0">
                            <a href="#modal-editar-datos-usuario" 
                                data-id="{{$usuario->usuario_id}}"
                                data-ci="{{$usuario->persona_ci}}"
                                data-primer_apellido="{{$usuario->persona_primer_apellido}}"
                                data-segundo_apellido="{{$usuario->persona_segundo_apellido}}"
                                data-nombres="{{$usuario->persona_nombres}}"
                                data-celular="{{$usuario->celular_numero}}"
                                data-correo="{{$usuario->correo_direccion}}"
                                class="modal-trigger btn-celeste editar-datos-usuario" 
                                title="Editar datos">
                                <i class="material-icons">edit</i>
                            </a>
                            @if ($usuario->usuario_estado == 1)
                                <form action="{{route('administrador.usuarios.inhabilitar')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$usuario->usuario_id}}" required>
                                    <input type="hidden" name="ci" value="{{$usuario->persona_ci}}" required>
                                    <button class="sin-estilo btn-verde" title="Inhabilitar"><i class="material-icons">person</i></button>
                                </form>
                            @else
                                <form action="{{route('administrador.usuarios.habilitar')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$usuario->usuario_id}}" required>
                                    <input type="hidden" name="ci" value="{{$usuario->persona_ci}}" required>
                                    <button class="sin-estilo btn-gris" title="Habilitar"><i class="material-icons">person_off</i></button>
                                </form>
                            @endif
                            <a href="#modal-reiniciar-clave" 
                                data-id="{{$usuario->usuario_id}}"
                                data-ci="{{$usuario->persona_ci}}"
                                data-primer_apellido="{{$usuario->persona_primer_apellido}}"
                                data-segundo_apellido="{{$usuario->persona_segundo_apellido}}"
                                data-nombres="{{$usuario->persona_nombres}}"
                                class="modal-trigger btn-azul reiniciar-clave" 
                                title="Reiniciar Clave">
                                <i class="material-icons">lock_reset</i>
                            </a>
                            <a href="#modal-eliminar-usuario" 
                                data-id="{{$usuario->usuario_id}}"
                                data-ci="{{$usuario->persona_ci}}"
                                data-primer_apellido="{{$usuario->persona_primer_apellido}}"
                                data-segundo_apellido="{{$usuario->persona_segundo_apellido}}"
                                data-nombres="{{$usuario->persona_nombres}}"
                                class="modal-trigger btn-rojo eliminar-usuario" 
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
<x-usuario.administrador.personal.usuarios.editar />
<x-usuario.administrador.personal.usuarios.eliminar />
<x-usuario.administrador.personal.usuarios.reiniciar-clave />