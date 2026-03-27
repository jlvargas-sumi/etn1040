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
                <th>Grado</th>
                <th>Categoría</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($docentes as $i => $docente)
                <tr>
                    <td>{{$i+1}}</td>
                    <td>{{$docente->persona_ci}}</td>
                    <td>{{$docente->persona_primer_apellido}}</td>
                    <td>{{$docente->persona_segundo_apellido}}</td>
                    <td>{{$docente->persona_nombres}}</td>
                    <td>{{$docente->celular_numero}}</td>
                    <td>{{$docente->correo_direccion}}</td>
                    <td>{{$docente->docente_grado}}</td>
                    <td>{{$docente->categoria_nombre}}</td>
                    <td>
                        <div class="flex f-nw m0">
                            <a href="#modal-editar-datos-docente" 
                                data-id="{{$docente->docente_id}}"
                                data-ci="{{$docente->persona_ci}}"
                                data-primer_apellido="{{$docente->persona_primer_apellido}}"
                                data-segundo_apellido="{{$docente->persona_segundo_apellido}}"
                                data-nombres="{{$docente->persona_nombres}}"
                                data-celular="{{$docente->celular_numero}}"
                                data-correo="{{$docente->correo_direccion}}"
                                data-grado="{{$docente->docente_grado}}"
                                data-categoria="{{$docente->categoria_nombre}}"
                                data-categoria_id="{{$docente->categoria_id}}"
                                class="modal-trigger btn-celeste editar-datos-docente" 
                                title="Editar datos">
                                <i class="material-icons">edit</i>
                            </a>
                            @if ($docente->docente_estado == 1)
                                <form action="{{route('administrador.docentes.inhabilitar')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$docente->docente_id}}" required>
                                    <input type="hidden" name="ci" value="{{$docente->persona_ci}}" required>
                                    <button class="sin-estilo btn-verde" title="Inhabilitar"><i class="material-icons">person</i></button>
                                </form>
                            @else
                                <form action="{{route('administrador.docentes.habilitar')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$docente->docente_id}}" required>
                                    <input type="hidden" name="ci" value="{{$docente->persona_ci}}" required>
                                    <button class="sin-estilo btn-gris" title="Habilitar"><i class="material-icons">person_off</i></button>
                                </form>
                            @endif
                            <a href="#modal-eliminar-docente" 
                                data-id="{{$docente->docente_id}}"
                                data-ci="{{$docente->persona_ci}}"
                                data-primer_apellido="{{$docente->persona_primer_apellido}}"
                                data-segundo_apellido="{{$docente->persona_segundo_apellido}}"
                                data-nombres="{{$docente->persona_nombres}}"
                                class="modal-trigger btn-rojo eliminar-docente" 
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
<x-usuario.administrador.personal.docentes.editar :categorias=$categorias />
<x-usuario.administrador.personal.docentes.eliminar />