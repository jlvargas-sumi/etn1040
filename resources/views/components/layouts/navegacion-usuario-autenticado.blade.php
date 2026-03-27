<nav>
    @auth
        <ul>
            <x-layouts.usuario.navegacion-usuario-administrador/>
            <x-layouts.usuario.navegacion-usuario-administrativo/>
            <x-layouts.usuario.navegacion-usuario-auxiliar/>
            <x-layouts.usuario.navegacion-usuario-docente/>
            <x-layouts.usuario.navegacion-usuario-estudiante/>
        </ul>
    @endauth  
    <ul class="navegacion-global">
        <x-layouts.navegacion-global/>
    </ul>
</nav>
