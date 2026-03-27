@php
$colorComunicados = "grey";
$colorConvocatorias = "grey";
$colorAnuncios = "grey";
    switch ($tipo) {
        case "Comunicado":
            $colorComunicados = "light-blue darken-4";
            break;
        case "Convocatoria":
            $colorConvocatorias = "light-blue darken-2";
            break;
        case "Anuncio":
            $colorAnuncios = "red accent-3";
            break;
        default:
            ;
            break;
    }   
@endphp
  
<div>
    <a href="{{route('administrativo.publicaciones', ['Comunicado'])}}" class="waves-effect waves-light btn-small {{ $colorComunicados }} col s12">Comunicados</a>
    <a href="{{route('administrativo.publicaciones', ['Convocatoria'])}}" class="waves-effect waves-light btn-small {{ $colorConvocatorias }} col s12">Convocatorias</a>
    <a href="{{route('administrativo.publicaciones', ['Anuncio'])}}" class="waves-effect waves-light btn-small {{ $colorAnuncios }} col s12">Anuncios</a>
</div>
