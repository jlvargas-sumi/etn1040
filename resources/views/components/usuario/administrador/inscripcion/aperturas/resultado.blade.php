{{-- @dump($aperturas) --}}
<div class="tabla-s">
    <table id="tabla">
        <thead>
            <tr>
                <th>N°</th>
                <th>Semestre</th>
                <th>Sigla</th>
                <th>Asignatura</th>
                <th>Campo</th>
                <th>Paralelo</th>
                <th>Auxiliatura</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($aperturas as $i => $apertura)
                <tr>
                    <td>{{ $i + 1}}</td>
                    <td>{{ $apertura['semestre'] }}</td>
                    <td>{{ $apertura['sigla'] }} {{mb_strtoupper($apertura['campo'], "UTF-8") == "LABORATORIO" ? "(L)":""}}</td>
                    <td>{{ $apertura['asignatura'] }} {{mb_strtoupper($apertura['campo'], "UTF-8") == "LABORATORIO" ? "(".strtoupper($apertura['campo']).")":""}}</td>
                    <td>{{ $apertura['campo'] }}
                        @if (($apertura['laboratorio'] == 1) && (mb_strtoupper($apertura['campo'], "UTF-8") == "TEORÍA"))
                            (L)
                        @endif
                    </td>
                    <td>
                        <ul class="collection">
                            @foreach ($apertura['paralelos'] as $i => $paralelo)
                                <li class="collection-item flex">
                                    <span>{{$paralelo['paralelo']}}</span>
                                    @if($apertura['inscripcion'] !== null && $apertura['estado'] === 1)
                                        @if ($i != 0)
                                            <a href="#modal-editar-paralelo" title="Editar paralelo" class="btn-celeste modal-editar-paralelo modal-trigger" data-id="{{ $paralelo['aperturaId']}}" data-paralelo="{{ $paralelo['paralelo']}}" data-sigla="{{ $apertura['sigla'] }} {{$apertura['campo'] == 'Laboratorio' ? "(L)":""}}" ><span class="contenedor-icono"><i class="material-icons">edit</i></span></a>
                                            <a href="#modal-eliminar-paralelo" title="Eliminar paralelo" class="btn-rojo modal-eliminar-paralelo modal-trigger" data-id="{{ $paralelo['aperturaId']}}" data-paralelo="{{ $paralelo['paralelo']}}" data-sigla="{{ $apertura['sigla'] }} {{$apertura['campo'] == 'Laboratorio' ? "(L)":""}}" ><span class="contenedor-icono"><i class="material-icons">delete</i></span></a>
                                        @endif
                                        @if (count($apertura['paralelos']) == $i+1)
                                            <a href="#modal-crear-paralelo" title="Crear paralelo" class="btn-verde modal-crear-paralelo modal-trigger" data-id="{{ $paralelo['aperturaId']}}" data-sigla="{{ $apertura['sigla'] }} {{$apertura['campo'] == 'Laboratorio' ? "(L)":""}}" ><span class="contenedor-icono"><i class="material-icons">add_circle</i></span></a>
                                        @endif
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td><i class="material-icons {{$apertura['auxiliatura'] == 1 ? "teal":"red"}}-text">{{$apertura['auxiliatura'] == 1 ? "check":"close"}}</i></td>
                    <td>
                        <div class="flex">
                            @if ($apertura['estado'] === 1)
                                <form action="{{route('administrador.aperturas.deshabilitar')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$apertura['aperturaId']}}" required >
                                    <input type="hidden" name="plan_estudios_id" value="{{$planEstudiosId}}" required >
                                    <input type="hidden" name="mencion_id" value="{{$mencionId}}" required >
                                    <input type="hidden" name="periodo" value="{{$periodo}}" required >
                                    <input type="hidden" name="gestion" value="{{$gestion}}" required >
                                    <input type="hidden" name="sigla" value="{{ $apertura['sigla'] }} {{$apertura['campo'] == 'Laboratorio' ? "(L)":""}}" required >
                                    <button class="sin-estilo btn-verde" title="Deshabilitar apertura"><i class="material-icons">toggle_on</i></button>
                                </form>
                            @else
                                <form action="{{route('administrador.aperturas.habilitar')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$apertura['aperturaId']}}" required >
                                    <input type="hidden" name="plan_estudios_id" value="{{$planEstudiosId}}" required >
                                    <input type="hidden" name="mencion_id" value="{{$mencionId}}" required >
                                    <input type="hidden" name="periodo" value="{{$periodo}}" required >
                                    <input type="hidden" name="gestion" value="{{$gestion}}" required >
                                    <input type="hidden" name="sigla" value="{{ $apertura['sigla'] }} {{$apertura['campo'] == 'Laboratorio' ? "(L)":""}}" required >
                                    <button class="sin-estilo btn-gris" title="Habilitar apertura"><i class="material-icons">toggle_off</i></button>
                                </form>
                            @endif
                            
                            @if ($apertura['extraordinario'] === 1)
                            <a href="#modal-eliminar-laboratorio" title="Eliminar Laboratorio extraordinario"  class="btn-rojo modal-eliminar-laboratorio modal-trigger" 
                                data-id="{{ $paralelo['aperturaId']}}" 
                                data-sigla="{{ $apertura['sigla'] }} {{$apertura['campo'] == 'Laboratorio' ? "(L)":""}}" 
                                >
                                <span class="contenedor-icono"><i class="material-icons">delete</i></span></a>
                            @endif
                        </div>
                        
                        @if($apertura['inscripcion'] === null)
                            {{-- <span class="mensaje-alerta-error m5 p2">Deshabilitado</span> --}}
                            <a href="#modal-laboratorio-independiente" class="laboratorio-independiente modal-trigger" title="Cambiar a Independiente" 
                                data-id="{{ $apertura['aperturaId']}}" 
                                data-sigla="{{ $apertura['sigla']}}" 
                                >
                                <span class="mensaje-alerta-informacion m5 p2 btn-celeste">Lab. Dependiente</span></a>
                        @else
                            {{-- <span class="mensaje-alerta-exito m5 p2">Habilitado</span> --}}
                            @if (strtoupper($apertura['campo']) == "LABORATORIO")
                                <a href="#modal-laboratorio-dependiente" class="laboratorio-dependiente modal-trigger" title="Cambiar a Dependiente" 
                                    data-id="{{ $apertura['aperturaId']}}" 
                                    data-sigla="{{ $apertura['sigla']}}" 
                                    >
                                    <span class="mensaje-alerta-informacion m5 p2 btn-azul">Lab. Independiente</span></a>
                            @else
                                @if ($apertura['inscripcion'] === 0 && $apertura['laboratorio'] === 0 && $apertura['extraordinario'] === null)
                                    <a href="#modal-crear-laboratorio" class="crear-laboratorio modal-trigger" title="Crear Laboratorio" 
                                        data-id="{{ $apertura['aperturaId']}}" 
                                        data-sigla="{{ $apertura['sigla']}}" 
                                        >
                                        <span class="mensaje-alerta-error m5 p2 btn-rojo">Crear Lab.</span></a>
                                @endif
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<x-usuario.administrador.inscripcion.aperturas.editar-paralelo :planEstudiosId=$planEstudiosId :mencionId=$mencionId :periodo=$periodo :gestion=$gestion />
<x-usuario.administrador.inscripcion.aperturas.eliminar-paralelo :planEstudiosId=$planEstudiosId :mencionId=$mencionId :periodo=$periodo :gestion=$gestion />
<x-usuario.administrador.inscripcion.aperturas.crear-paralelo :planEstudiosId=$planEstudiosId :mencionId=$mencionId :periodo=$periodo :gestion=$gestion />
<x-usuario.administrador.inscripcion.aperturas.laboratorio-independiente :planEstudiosId=$planEstudiosId :mencionId=$mencionId :periodo=$periodo :gestion=$gestion />
<x-usuario.administrador.inscripcion.aperturas.crear-laboratorio :planEstudiosId=$planEstudiosId :mencionId=$mencionId :periodo=$periodo :gestion=$gestion />
<x-usuario.administrador.inscripcion.aperturas.eliminar-laboratorio :planEstudiosId=$planEstudiosId :mencionId=$mencionId :periodo=$periodo :gestion=$gestion />
<x-usuario.administrador.inscripcion.aperturas.laboratorio-dependiente :planEstudiosId=$planEstudiosId :mencionId=$mencionId :periodo=$periodo :gestion=$gestion />