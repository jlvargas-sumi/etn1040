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
    @foreach ($menciones as $i => $mencion)
        <li class="collection-item avatar">
            <i class="material-icons circle fondo-principal-1">{{$iconos[$i]}}</i>
            <span class="title"><strong>Mención:</strong> {{$mencion->mencion_nombre}}</span>
            <p>Ingeniería Electrónica</p>
            @if (!$mencion->mencion_proteccion)
                <a href="#modal-editar-mencion" class="modal-trigger btn-azul editar-mencion" 
                    data-id="{{$mencion->mencion_id}}"
                    data-mencion="{{$mencion->mencion_nombre}}"
                    title="Editar mención">
                    <i class="material-icons">edit</i>
                </a>
                <a href="#modal-eliminar-mencion" class="modal-trigger btn-rojo eliminar-mencion" 
                    data-id="{{$mencion->mencion_id}}"
                    data-mencion="{{$mencion->mencion_nombre}}"
                    title="Editar mención">
                    <i class="material-icons">delete</i>
                </a>
            @endif
        </li>
    @endforeach
</ul>
<x-usuario.administrador.carrera.menciones.editar />
<x-usuario.administrador.carrera.menciones.eliminar />