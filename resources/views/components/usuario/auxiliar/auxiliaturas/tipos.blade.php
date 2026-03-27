@php
$colorPonderaciones = "grey";
$colorNotas = "grey";
$colorAsistencias = "grey";
$colorInscritos = "grey";
$colorCotizaciones = "grey";
    switch ($tipo) {
        case "Ponderaciones":
            $colorPonderaciones = "light-blue darken-4";
            break;
        case "Notas":
            $colorNotas = "light-blue darken-2";
            break;
        case "Inscritos":
            $colorInscritos = "red accent-3";
            break;
        // case "Inscritos":
        // $colorInscritos = "green";
        //     break;
        // case "Cotizaciones":
        // $colorCotizaciones = "cyan darken-4";
        //     break;
        
        default:
            ;
            break;
    }   
@endphp
  
<div>
    <a href="{{route('auxiliar.ponderaciones', [$aperturaId, $periodo, $gestion])}}" class="waves-effect waves-light btn-small {{ $colorPonderaciones }} col s12">Ponderaciones</a>
    <a href="{{route('auxiliar.notas', [$aperturaId, $periodo, $gestion])}}" class="waves-effect waves-light btn-small {{ $colorNotas }} col s12">Notas</a>
    <a href="{{route('auxiliar.inscritos', [$aperturaId, $periodo, $gestion])}}" class="waves-effect waves-light btn-small {{ $colorInscritos }} col s12">Inscritos</a>
    <a href="{{route('auxiliar.auxiliaturas', [$periodo, $gestion])}}" class="waves-effect waves-light btn-azul p-5 col s12" title="Volver a Auxiliaturas"><i class="material-icons left">keyboard_backspace</i>Volver</a>
</div>
