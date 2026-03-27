<x-layouts.plantilla titulo="Anuncios" meta-descripcion="Meta descipción de Anuncios de Docentes" nombre-pagina="docente-anuncios">
    <span class="titulo">Anuncios</span>
    <x-usuario.docente.anuncios.publicar />
    <x-usuario.docente.anuncios.mostrar :anuncios=$anuncios/>
</x-layouts.plantilla>