<x-layouts.plantilla titulo="Perfil de Usuario" meta-descripcion="Meta descripción de Perfil de Usuario" nombre-pagina="perfil">
    <section>
        <div class="row">
            <x-usuarios.foto-perfil/>
            <x-usuarios.datos-personales :informacionPersonal="$informacionPersonal"/>
            <x-usuarios.datos-contacto :informacionPersonal="$informacionPersonal"/>
            <x-usuarios.datos-universitarios/>
            <x-usuarios.actualizar-clave/>
        </div>
    </section>
</x-layouts.plantilla>