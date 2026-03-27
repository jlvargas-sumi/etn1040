<ul class="collection">
    @foreach ($aulas as $i => $aula)
        <li class="collection-item avatar">
            <i class="material-icons circle fondo-principal-1">door_front</i>
            <span class="title"><strong>Ambiente:</strong> {{$aula->aula_nombre}}</span>
            <p><strong>Capacidad:</strong> {{$aula->aula_capacidad}}</p>
            <a href="#modal-editar-aula" class="modal-trigger btn-azul editar-aula" 
                data-id="{{$aula->aula_id}}"
                data-aula="{{$aula->aula_nombre}}"
                data-capacidad="{{$aula->aula_capacidad}}"
                title="Editar aula">
                <i class="material-icons">edit</i>
            </a>
            <a href="#modal-eliminar-aula" class="modal-trigger btn-rojo eliminar-aula" 
                data-id="{{$aula->aula_id}}"
                data-aula="{{$aula->aula_nombre}}"
                title="Editar aula">
                <i class="material-icons">delete</i>
            </a>
        </li>
    @endforeach
</ul>
<x-usuario.administrador.carrera.aulas.editar />
<x-usuario.administrador.carrera.aulas.eliminar />