@foreach ($aperturas as $i => $apertura)
    @php
        if (mb_strtoupper($apertura->apertura_campo, "UTF-8") == "TEORÍA") {
            $tipo = "Examenes";
            $tipoEs = "Exámenes";
            $campo = "Teoría";
        } else {
            $tipo = "Laboratorios";
            $tipoEs = "Laboratorios";
            $campo = "Laboratorio";
        }
    @endphp
    <ul class="collection with-header">
        <li class="collection-header">
            <x-usuario.auxiliar.auxiliaturas.ponderaciones.actualizar-apertura 
                :asignatura=$asignatura
                :ponderacionPrincipal="$apertura->auxiliatura_ponderacion['ponderacionPrincipal']"
                :ponderacionSecundaria="$apertura->auxiliatura_ponderacion['ponderacionSecundaria']"
                :auxiliaturaId="$apertura->auxiliatura_id"
                :aperturaId=$aperturaId :periodo=$periodo :gestion=$gestion 
                tipo="{{ $tipo }}" tipoEs="{{ $tipoEs }}" campo="{{ $campo }}" 
                />
        </li>
        <li class="collection-item fondo-principal-3">
            <div class="flex f-jcse f-w">
                <x-usuario.auxiliar.auxiliaturas.ponderaciones.actualizar 
                    :asignatura=$asignatura
                    :ponderaciones="$apertura->auxiliatura_ponderacion['ponderacionesPrincipal']"
                    :auxiliaturaId="$apertura->auxiliatura_id"
                    :aperturaId=$aperturaId :periodo=$periodo :gestion=$gestion 
                    tipo="{{ $tipo }}" tipoEs="{{ $tipoEs }}"
                    />
                <x-usuario.auxiliar.auxiliaturas.ponderaciones.actualizar 
                    :asignatura=$asignatura
                    :ponderaciones="$apertura->auxiliatura_ponderacion['ponderacionesSecundaria']"
                    :auxiliaturaId="$apertura->auxiliatura_id"
                    :aperturaId=$aperturaId :periodo=$periodo :gestion=$gestion 
                    tipo="Actividades" tipoEs="Actividades"
                    />
            </div>
        </li>
    </ul>
@endforeach

<x-usuario.auxiliar.auxiliaturas.ponderaciones.eliminar :asignatura=$asignatura :aperturaId=$aperturaId :periodo=$periodo :gestion=$gestion />
<x-usuario.auxiliar.auxiliaturas.ponderaciones.crear :asignatura=$asignatura :aperturaId=$aperturaId :periodo=$periodo :gestion=$gestion />