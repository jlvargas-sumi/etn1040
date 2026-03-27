<form action="{{route('docente.ponderaciones.actualizar')}}" method="POST">
    @csrf
    <input type="hidden" name="id" value={{$docenciaId}} required>
    <input type="hidden" name="tipo" value={{$tipo}} required>
    <input type="hidden" name="tipo_es" value={{$tipoEs}} required>
    <input type="hidden" name="apertura_id" value={{$aperturaId}} required>
    <input type="hidden" name="periodo" value={{$periodo}} required>
    <input type="hidden" name="gestion" value={{$gestion}} required>
    <input type="hidden" name="sigla" value="{{$asignatura->asignatura_sigla}}" required>
    <div>
        <ul class="collection with-header">
            <li class="collection-header">
                <h5>{{$tipoEs}} 100%
                    <a class="waves-effect waves-light btn-floating green hover-70 modal-trigger col s12 crear-ponderacion" 
                        title="Crear ponderación"
                        data-tipo={{$tipo}}
                        data-tipo_es={{$tipoEs}}
                        data-id={{$docenciaId}}
                        href="#modal-crear-ponderacion">
                        <i class="material-icons">add</i>
                    </a>
                </h5>
            </li>
            @php
                $cnt = 0;
                $total = 0;
            @endphp
            @foreach ($ponderaciones as $i => $ponderacion)
                @php
                    $cnt++;
                    $total = $total + $ponderacion;
                @endphp
                <li class="collection-item flex">{{$i}}
                    <input type="number" name="ponderaciones[]" value={{ $ponderacion }} min="1" max="100" step="0.01" placeholder="70%" class="validate center" required>
                    @if (($cnt == count($ponderaciones))&&($cnt>1))
                        <a class="btn-rojo eliminar-ponderacion modal-trigger" 
                            title="Eliminar ponderación"
                            data-tipo={{$tipo}}
                            data-tipo_es={{$tipoEs}}
                            data-id={{$docenciaId}}
                            data-indice={{$i}}
                            data-ponderacion={{$ponderacion}}
                            href="#modal-eliminar-ponderacion">
                            <span class="contenedor-icono"><i class="material-icons">delete</i></span>
                        </a>    
                    @endif
                </li>
            @endforeach
            <li class="collection-item row">
                <button class="btn col s12">Guardar</button>
                <strong class="col s12 m-5 center {{ $total == 100 ? "green":"red" }}-text">
                    <i class="material-icons">functions</i>Total {{$total}}
                    <i class="material-icons">{{ $total == 100 ? "check":"cancel" }}</i>
                </strong>
            </li>
        </ul>
    </div>
</form>