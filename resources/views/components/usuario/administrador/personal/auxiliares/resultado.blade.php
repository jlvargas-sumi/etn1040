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
            @foreach ($auxiliares as $i => $auxiliar)
                <tr>
                    <td>{{$i+1}}</td>
                    <td>{{$auxiliar->persona_ci}}</td>
                    <td>{{$auxiliar->estudiante_ru}}</td>
                    <td>{{$auxiliar->persona_primer_apellido}}</td>
                    <td>{{$auxiliar->persona_segundo_apellido}}</td>
                    <td>{{$auxiliar->persona_nombres}}</td>
                    <td>{{$auxiliar->celular_numero}}</td>
                    <td>{{$auxiliar->correo_direccion}}</td>
                    <td>
                        <div class="flex f-nw m0">
                            <a href="#modal-editar-datos-auxiliar" 
                                data-id="{{$auxiliar->auxiliar_id}}"
                                data-ci="{{$auxiliar->persona_ci}}"
                                data-ru="{{$auxiliar->estudiante_ru}}"
                                data-primer_apellido="{{$auxiliar->persona_primer_apellido}}"
                                data-segundo_apellido="{{$auxiliar->persona_segundo_apellido}}"
                                data-nombres="{{$auxiliar->persona_nombres}}"
                                data-celular="{{$auxiliar->celular_numero}}"
                                data-correo="{{$auxiliar->correo_direccion}}"
                                class="modal-trigger btn-celeste editar-datos-auxiliar" 
                                title="Editar datos">
                                <i class="material-icons">edit</i>
                            </a>
                            @if ($auxiliar->auxiliar_estado == 1)
                                <form action="{{route('administrador.auxiliares.inhabilitar')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$auxiliar->auxiliar_id}}" required>
                                    <input type="hidden" name="ci" value="{{$auxiliar->persona_ci}}" required>
                                    <button class="sin-estilo btn-verde" title="Inhabilitar"><i class="material-icons">person</i></button>
                                </form>
                            @else
                                <form action="{{route('administrador.auxiliares.habilitar')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$auxiliar->auxiliar_id}}" required>
                                    <input type="hidden" name="ci" value="{{$auxiliar->persona_ci}}" required>
                                    <button class="sin-estilo btn-gris" title="Habilitar"><i class="material-icons">person_off</i></button>
                                </form>
                            @endif
                            <a href="#modal-eliminar-auxiliar" 
                                data-id="{{$auxiliar->auxiliar_id}}"
                                data-ci="{{$auxiliar->persona_ci}}"
                                data-primer_apellido="{{$auxiliar->persona_primer_apellido}}"
                                data-segundo_apellido="{{$auxiliar->persona_segundo_apellido}}"
                                data-nombres="{{$auxiliar->persona_nombres}}"
                                class="modal-trigger btn-rojo eliminar-auxiliar" 
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
<x-usuario.administrador.personal.auxiliares.editar />
<x-usuario.administrador.personal.auxiliares.eliminar />