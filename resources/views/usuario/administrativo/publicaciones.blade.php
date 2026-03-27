<x-layouts.plantilla titulo="Publicaciones" meta-descripcion="Meta descipción de Publicaciones de Administrativos" nombre-pagina="administrativo-publicaciones">
    <span class="titulo">Publicaciones</span>
    <x-usuario.administrativo.publicaciones.tipos :tipo=$tipo />
    <x-usuario.administrativo.publicaciones.publicar :tipo=$tipo />
    <x-usuario.administrativo.publicaciones.mostrar :tipo=$tipo :publicaciones=$publicaciones />
</x-layouts.plantilla>