<div id="modal-eliminar-plan-estudio" class="modal">
    <div class="modal-content flex">
        <span class="subtitulo">Eliminar mención "<strong></strong>" </span>
        <form action="{{route('administrador.planes-estudios.eliminar')}}" method="POST">
            @csrf
            <input type="hidden" name="id" class="validate" required>
            <input type="hidden" name="plan_estudio" class="validate" required>
            <button type="submit" class="btn waves-effect waves-light">Eliminar</button>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat red white-text hover-70">Salir</a>
    </div>
</div>