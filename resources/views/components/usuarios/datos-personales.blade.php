@php
    $rolActivoUsuario = session('rolActivoUsuario');
    $informacionPersonal = $informacionPersonal ?? null; // Asegurar que no sea null
@endphp

<div class="datos-personales col s12 m8 push-m2 l8 push-l2">
    @if($informacionPersonal)
        <h4>{{ $informacionPersonal->persona_nombres ?? '' }} {{ $informacionPersonal->persona_primer_apellido ?? '' }} {{ $informacionPersonal->persona_segundo_apellido ?? '' }}</h4>
        <span>C.I.: {{ $informacionPersonal->persona_ci ?? '' }}</span>
    @else
        <h4>Información no disponible</h4>
        <span>C.I.: No disponible</span>
    @endif
    
    <p class="texto">{{ $rolActivoUsuario->rol_nombre ?? 'Rol no disponible' }} de la carrera de Ingeniería Electrónica.</p>
</div>