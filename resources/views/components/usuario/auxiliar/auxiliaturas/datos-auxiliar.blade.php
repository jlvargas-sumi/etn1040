<form class="row datos-formales">
    <div class="input-field col  s6 m4 l4">
        <input type="text" value="{{ $auxiliar->persona_primer_apellido }}" disabled>
        <label>Primer Apellido</label>
    </div>
    <div class="input-field col  s6 m4 l4">
        <input type="text" value="{{ $auxiliar->persona_segundo_apellido }}" disabled>
        <label>Segundo Apellido</label>
    </div>
    <div class="input-field col  s6 m4 l4">
        <input type="text" value="{{ $auxiliar->persona_nombres }}" disabled>
        <label>Nombres</label>
    </div>
    <div class="input-field col  s6 m4 l4">
        <input type="text" value="{{ $auxiliar->estudiante_ru }}" disabled>
        <label>R.U.</label>
    </div>
    <div class="input-field col  s6 m4 l4">
        <input type="text" value="{{ $periodo }}" disabled>
        <label>Periodo</label>
    </div>
    <div class="input-field col  s6 m4 l4">
        <input type="text" value="{{ $gestion }}" disabled>
        <label>Gestión</label>
    </div>
</form>