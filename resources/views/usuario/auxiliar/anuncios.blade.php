<x-layouts.plantilla titulo="Anuncios" meta-descripcion="Meta descipción de Anuncios de Auxiliares" nombre-pagina="auxiliar-anuncios">
    <span class="titulo">Anuncios</span>
    <x-usuario.auxiliar.anuncios.publicar />
    <x-usuario.auxiliar.anuncios.mostrar :anuncios=$anuncios/>
</x-layouts.plantilla>