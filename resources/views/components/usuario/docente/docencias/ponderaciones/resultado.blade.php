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
            <x-usuario.docente.docencias.ponderaciones.actualizar-apertura 
                :asignatura=$asignatura
                :ponderacionPrincipal="$apertura->docencia_ponderacion['ponderacionPrincipal']"
                :ponderacionSecundaria="$apertura->docencia_ponderacion['ponderacionSecundaria']"
                :docenciaId="$apertura->docencia_id"
                :aperturaId=$aperturaId :periodo=$periodo :gestion=$gestion 
                tipo="{{ $tipo }}" tipoEs="{{ $tipoEs }}" campo="{{ $campo }}" 
                />
        </li>
        <li class="collection-item fondo-principal-3">
            <div class="flex f-jcse f-w">
                <x-usuario.docente.docencias.ponderaciones.actualizar 
                    :asignatura=$asignatura
                    :ponderaciones="$apertura->docencia_ponderacion['ponderacionesPrincipal']"
                    :docenciaId="$apertura->docencia_id"
                    :aperturaId=$aperturaId :periodo=$periodo :gestion=$gestion 
                    tipo="{{ $tipo }}" tipoEs="{{ $tipoEs }}"
                    />
                <x-usuario.docente.docencias.ponderaciones.actualizar 
                    :asignatura=$asignatura
                    :ponderaciones="$apertura->docencia_ponderacion['ponderacionesSecundaria']"
                    :docenciaId="$apertura->docencia_id"
                    :aperturaId=$aperturaId :periodo=$periodo :gestion=$gestion 
                    tipo="Actividades" tipoEs="Actividades"
                    />
            </div>
        </li>
    </ul>
@endforeach

<x-usuario.docente.docencias.ponderaciones.eliminar :asignatura=$asignatura :aperturaId=$aperturaId :periodo=$periodo :gestion=$gestion />
<x-usuario.docente.docencias.ponderaciones.crear :asignatura=$asignatura :aperturaId=$aperturaId :periodo=$periodo :gestion=$gestion />