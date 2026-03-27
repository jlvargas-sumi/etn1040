<x-layouts.plantilla titulo="Pemsum" meta-descripcion="Meta descripción de Pemsum" nombre-pagina="pensum">
    <span class="titulo">Pensum actual</span>
    <ul class="collapsible">
        <li>
            <div class="collapsible-header"><i class="material-icons">memory</i>Mención: Control</div>
            <div class="collapsible-body">
                {{-- <x-pensum-control :pensumControl="$pensumControl"/> --}}
                <span class="subtitulo"></span>
                <iframe src="{{ asset('documentos/control.pdf') }}" frameborder="0"></iframe>
            </div>
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">terminal</i>Mención: Sistemas de Computación</div>
            <div class="collapsible-body">
                {{-- <x-pensum-sistemas :pensumSistemas="$pensumSistemas"/> --}}
                <span class="subtitulo"></span>
                <iframe src="{{ asset('documentos/sistemas.pdf') }}" frameborder="0"></iframe>
            </div>
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons">cell_tower</i>Mención: Telecomunicaciones</div>
            <div class="collapsible-body">
                {{-- <x-pensum-telecomunicaciones :pensumTelecomunicaciones="$pensumTelecomunicaciones"/> --}}
                <span class="subtitulo">Mención: Telecomunicaciones</span>
                <iframe src="{{ asset('documentos/telecomunicaciones.pdf') }}" frameborder="0"></iframe>
            </div>
        </li>
    </ul>
</x-layouts.plantilla>
