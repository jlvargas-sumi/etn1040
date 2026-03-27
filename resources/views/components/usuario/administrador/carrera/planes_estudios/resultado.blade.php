@php
    $iconos = [
        'memory',
        'terminal',
        'cell_tower',
        'devices_other',
        'devices_other',
        'devices_other',
        'devices_other',
    ];
@endphp
<ul class="collection">
    @foreach ($planesEstudios as $i => $planEstudios)
        <li class="collection-item avatar">
            <i class="material-icons circle fondo-principal-1">{{$iconos[$i]}}</i>
            <span class="title"><strong>Plan de Estudio:</strong> {{$planEstudios->plan_estudio_nombre}}</span>
            <p>Ingeniería Electrónica</p>
            @if (!$planEstudios->plan_estudio_proteccion)
                <a href="#modal-editar-plan-estudio" class="modal-trigger btn-azul editar-plan-estudio" 
                    data-id="{{$planEstudios->plan_estudio_id}}"
                    data-plan_estudio="{{$planEstudios->plan_estudio_nombre}}"
                    title="Editar Plan de Estudio">
                    <i class="material-icons">edit</i>
                </a>
                <a href="#modal-eliminar-plan-estudio" class="modal-trigger btn-rojo eliminar-plan-estudio" 
                    data-id="{{$planEstudios->plan_estudio_id}}"
                    data-plan_estudio="{{$planEstudios->plan_estudio_nombre}}"
                    title="Editar Plan de Estudio">
                    <i class="material-icons">delete</i>
                </a>
            @endif
        </li>
    @endforeach
</ul>
<x-usuario.administrador.carrera.planes_estudios.editar />
<x-usuario.administrador.carrera.planes_estudios.eliminar />