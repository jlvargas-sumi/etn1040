<x-layouts.plantilla titulo="Nosotros" meta-descripcion="Meta descripción de Nosotros" nombre-pagina="nosotros">
    <div class="row">
        <div class="col s12 m9 l10">
            <div id="introduccion" class="section scrollspy">
                <x-introduccion/>
            </div>
          
            <div id="historia" class="section scrollspy">
                <x-historia/>
            </div>

            <div id="plantel-administrativo" class="section scrollspy">
                <x-plantel-administrativo :administrativos="$administrativos"/>
            </div>

            <div id="plantel-docente" class="section scrollspy">
                <x-plantel-docente :docentes="$docentes"/>
            </div>

            <div id="plantel-auxiliar" class="section scrollspy">
                <x-plantel-auxiliar :auxiliares="$auxiliares"/>
            </div>
        </div>
        <div class="col hide-on-small-only m3 l2">
            <ul class="section table-of-contents">
                <li><a href="#introduccion">Misión, Visión y Objetivos</a></li>
                <li><a href="#historia">Historia</a></li>
                <li><a href="#plantel-administrativo">Plantel Administrativo</a></li>
                <li><a href="#plantel-docente">Plantel Docente</a></li>
                <li><a href="#plantel-auxiliar">Plantel Auxiliar</a></li>
            </ul>
        </div>
    </div>
</x-layouts.plantilla>
