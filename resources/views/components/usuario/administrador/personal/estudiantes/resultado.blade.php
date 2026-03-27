<div class="tabla">
    <table id="tabla">
        <thead>
            <tr>
                <th>N°</th>
                <th>C.I.</th>
                <th>R.U.</th>
                <th>Apellido P.</th>
                <th>Apellido M.</th>
                <th>Nombres</th>
                <th>Celular</th>
                <th>Correo-e</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($estudiantes as $i => $estudiante)
                <tr>
                    <td>{{$i+1}}</td>
                    <td>{{$estudiante->persona_ci}}</td>
                    <td>{{$estudiante->estudiante_ru}}</td>
                    <td>{{$estudiante->persona_primer_apellido}}</td>
                    <td>{{$estudiante->persona_segundo_apellido}}</td>
                    <td>{{$estudiante->persona_nombres}}</td>
                    <td>{{$estudiante->celular_numero}}</td>
                    <td>{{$estudiante->correo_direccion}}</td>
                    <td>
                        <div class="flex f-nw m0">
                            <a href="#modal-editar-datos-estudiante" 
                                data-id="{{$estudiante->estudiante_id}}"
                                data-ci="{{$estudiante->persona_ci}}"
                                data-ru="{{$estudiante->estudiante_ru}}"
                                data-primer_apellido="{{$estudiante->persona_primer_apellido}}"
                                data-segundo_apellido="{{$estudiante->persona_segundo_apellido}}"
                                data-nombres="{{$estudiante->persona_nombres}}"
                                data-celular="{{$estudiante->celular_numero}}"
                                data-correo="{{$estudiante->correo_direccion}}"
                                class="modal-trigger btn-celeste editar-datos-estudiante" 
                                title="Editar datos">
                                <i class="material-icons">edit</i>
                            </a>
                            @if ($estudiante->estudiante_estado == 1)
                                <form action="{{route('administrador.estudiantes.inhabilitar')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$estudiante->estudiante_id}}" required>
                                    <input type="hidden" name="ci" value="{{$estudiante->persona_ci}}" required>
                                    <button class="sin-estilo btn-verde" title="Inhabilitar"><i class="material-icons">person</i></button>
                                </form>
                            @else
                                <form action="{{route('administrador.estudiantes.habilitar')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$estudiante->estudiante_id}}" required>
                                    <input type="hidden" name="ci" value="{{$estudiante->persona_ci}}" required>
                                    <button class="sin-estilo btn-gris" title="Habilitar"><i class="material-icons">person_off</i></button>
                                </form>
                            @endif
                            <a href="#modal-eliminar-estudiante" 
                                data-id="{{$estudiante->estudiante_id}}"
                                data-ci="{{$estudiante->persona_ci}}"
                                data-primer_apellido="{{$estudiante->persona_primer_apellido}}"
                                data-segundo_apellido="{{$estudiante->persona_segundo_apellido}}"
                                data-nombres="{{$estudiante->persona_nombres}}"
                                class="modal-trigger btn-rojo eliminar-estudiante" 
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
<x-usuario.administrador.personal.estudiantes.editar />
<x-usuario.administrador.personal.estudiantes.eliminar />