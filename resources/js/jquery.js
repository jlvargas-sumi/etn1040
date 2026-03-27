$(document).ready(function () {
    if (window.location.protocol === "https:") {
        //   var miUrl = "https://35.193.53.55/";
        //   var miUrl = "https://162.214.79.47";
        //   var miUrl = "https://ststigo-fo.com";
          var miUrl = 'https://localhost:8000';
    } else {
        // var miUrl = "http://35.193.53.55/";
        // var miUrl = "http://162.214.79.47";
        // var miUrl = "http://ststigo-fo.com";
        var miUrl = 'http://localhost:8000';
    }
    /*MATERIALIZE GENERAL*/
    $('.sidenav').sidenav();
    $('.modal').modal();
    $('.parallax').parallax();
    $('.scrollspy').scrollSpy();
    $('select').formSelect();
    $('.docente-ponderaciones .collapsible').collapsible({
        'accordion': false
    });
    $('.pensum .collapsible').collapsible({
        'accordion': false
    });
    $('.horarios .collapsible').collapsible({
        'accordion': false
    });
    $('.administrador-usuarios .collapsible').collapsible({
        'accordion': false
    });
    /*DATATABLES GENERAL*/
    $('#tabla').DataTable({
        language: {
            url: miUrl+"/idiomas.json" // Ruta del archivo JSON local
            // url: "http://localhost:8000/idiomas.json" // Ruta del archivo JSON local
            // url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
        },
        pageLength: 25
    });
    $('#example').DataTable({
        language: {
            // url: "http://localhost:8000/idiomas.json" // Ruta del archivo JSON local
            url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
        },
        pageLength: 25
    });
    
    /*USUARIOS EN GENERAL */
    /*NAV: BOTON MENU RESPONSIVE*/
    var ctn1 = 1;
    $('.menu').click(function () {
        if (ctn1 == 1) {
            $('aside').animate({
                left: '0'
            });
            ctn1 = 0;
        } else {
            ctn1 = 1;
            $('aside').animate({
                left: '-240'
            });
        }
    });
    /*NAV: BOTON SUBMENU*/
    $('aside .sub-menu-global').click(function () {
        var icono = $(this).find('i.derecha').html();
        if (icono == 'arrow_drop_down') {
            $(this).find('i.derecha').html('arrow_drop_up');
        } else {
            $(this).find('i.derecha').html('arrow_drop_down');
        }
        $(this).find('ul').slideToggle();
    });
    /*ANUNCIOS: BUSCAR SEGÚN PARÁMETRO*/
    $('.anuncios #seleccionar-parametro').on('change', function () {
        var valorSeleccionado = $(this).val();
        if (valorSeleccionado === 'tipo') {
            $('#valor-parametro').attr('type', 'text');
            $('#valor-parametro').attr('placeholder', 'Ej. Pasantía');
            $('.valor-parametro').text('Tipo');
        } else if (valorSeleccionado === 'descripcion') {
            $('#valor-parametro').attr('type', 'text');
            $('#valor-parametro').attr('placeholder', 'Pasantía Instituto ETN');
            $('.valor-parametro').text('Desripción');
        } else if (valorSeleccionado === 'fecha') {
            $('#valor-parametro').attr('type', 'date');
            $('#valor-parametro').removeAttr('placeholder');
            $('.valor-parametro').text('Fecha');
        }
    });
    /*COMUNICADOS: BUSCAR SEGÚN PARÁMETRO*/
    $('.comunicados #seleccionar-parametro').on('change', function () {
        var valorSeleccionado = $(this).val();
        if (valorSeleccionado === 'numero') {
            $('#valor-parametro').attr('type', 'text');
            $('#valor-parametro').attr('placeholder', 'Ej. 003-2023');
            $('.valor-parametro').text('Número');
        } else if (valorSeleccionado === 'descripcion') {
            $('#valor-parametro').attr('type', 'text');
            $('#valor-parametro').attr('placeholder', 'Comunicado auxiliares 10');
            $('.valor-parametro').text('Desripción');
        } else if (valorSeleccionado === 'fecha') {
            $('#valor-parametro').attr('type', 'date');
            $('#valor-parametro').removeAttr('placeholder');
            $('.valor-parametro').text('Fecha');
        }
    });
    /*CONVOCATORIAS: BUSCAR SEGÚN PARÁMETRO*/
    $('.convocatorias #seleccionar-parametro').on('change', function () {
        var valorSeleccionado = $(this).val();
        if (valorSeleccionado === 'numero') {
            $('#valor-parametro').attr('type', 'text');
            $('#valor-parametro').attr('placeholder', 'Ej. 003-2023');
            $('.valor-parametro').text('Número');
        } else if (valorSeleccionado === 'descripcion') {
            $('#valor-parametro').attr('type', 'text');
            $('#valor-parametro').attr('placeholder', 'Convocatoria auxiliares 10');
            $('.valor-parametro').text('Desripción');
        } else if (valorSeleccionado === 'fecha') {
            $('#valor-parametro').attr('type', 'date');
            $('#valor-parametro').removeAttr('placeholder');
            $('.valor-parametro').text('Fecha');
        }
    });
    /*ANUNCIOS, CONVOCATORIAS Y COMUNICADOS: VER ARCHIVO*/
    $('.ver-archivo').on('click', function(){
        var modal = $(this).data('modal');

        if (!($(modal).hasClass('activado')))
        {
            $(modal).addClass('activado');
            var recursoArchivo = $(modal + ' input[name="recurso_archivo"]').val();
            $(modal + ' iframe').attr('src', recursoArchivo);
        }
    });
    /*HORARIOS: BUSCAR HORARIOS SEGÚN PARÁMETRO*/
    $('.horarios .switch #parametro').on('change', function () {
        if($(this).prop("checked")) {
            $('.horarios .parametro-semestre').css('color', 'rgba(0,0,0,0.25)');
            $('.horarios .parametro-aula').css('color', 'rgba(0,0,0,0.87)');
            $('.horarios .semestres').css('display', 'none');
            $('.horarios .aulas').css('display', 'block');
        } else {
            $('.horarios .parametro-aula').css('color', 'rgba(0,0,0,0.25)');
            $('.horarios .parametro-semestre').css('color', 'rgba(0,0,0,0.87)');
            $('.horarios .aulas').css('display', 'none');
            $('.horarios .semestres').css('display', 'block');
        }
    });
    /*HORARIOS: SEMESTRES->VER ARCHIVO*/
    $('.semestres .ver-archivo').on('click', function(){
        var plegable = '.semestres ' + $(this).data('plegable');

        if (!($(plegable).hasClass('activado'))) {
            $(plegable).addClass('activado');
            var recursoArchivo = $(plegable + ' input[name="recurso_archivo"]').val();
            $(plegable + ' iframe').attr('src', recursoArchivo);
        }
    });
    /*HORARIOS: AULAS->VER ARCHIVO*/
    $('.aulas .ver-archivo').on('click', function(){
        var plegable = '.aulas ' + $(this).data('plegable');

        if (!($(plegable).hasClass('activado'))) {
            $(plegable).addClass('activado');
            var recursoArchivo = $(plegable + ' input[name="recurso_archivo"]').val();
            $(plegable + ' iframe').attr('src', recursoArchivo);
        }
    });
    /*USUARIOS AUTENTICADOS */
    /*NAV: MENU PARA USUARIOS AUTENTICADOS*/
    var ctn2 = 1;
    $('#usuario').click(function () {
        if (ctn2 == 1) {
            $('.navegacion-usuario').removeClass('navegacion-usuario-inactivo');
            $('.navegacion-usuario').addClass('navegacion-usuario-activo');
            ctn2 = 0;
        } else {
            ctn2 = 1;
            $('.navegacion-usuario').removeClass('navegacion-usuario-activo');
            $('.navegacion-usuario').addClass('navegacion-usuario-inactivo');
        }
    });
    /*PERFIL: SUBIR O ACTUALIZAR FOTO*/
    $('#foto-perfil img').click(function () {
        $('#subir-foto-perfil').addClass('modal-activa');
        $('.contenedor-modal').addClass('modal-activa');
        $('#subir-foto-perfil i').click(function () {
            $('#subir-foto-perfil').removeClass('modal-activa');
            $('.contenedor-modal').removeClass('modal-activa');
        });
    });
    /*PERFIL: ACTUALIZAR CELULAR*/
    var ctn3 = 1;
    $('#boton-habilitar-celular').click(function () {
        if (ctn3 == 1) {
            $('#formulario-actualizar-celular :input').removeAttr('disabled');
            $('#boton-actualizar-celular').css('display', 'flex');
            $('#boton-habilitar-celular i').html('cancel');
            $('#boton-habilitar-celular > span > span').html('Cancelar');
            ctn3 = 0;
        } else {
            ctn3 = 1;
            $('#formulario-actualizar-celular :input').attr('disabled', 'disabled');
            $('#boton-actualizar-celular').css('display', 'none');
            var codigoActual = $('#formulario-actualizar-celular input[name="codigo_actual"]').val();
            $('#formulario-actualizar-celular input[name="code"]').val(codigoActual);
            var celularActual = $('#formulario-actualizar-celular input[name="celular_actual"]').val();
            $('#formulario-actualizar-celular input[name="celular"]').val(celularActual);
            $('#boton-habilitar-celular i').html('edit');
            $('#boton-habilitar-celular > span > span').html('Editar');
        }
    });
    /*PERFIL: ACTUALIZAR CORREO*/
    var ctn4 = 1;
    $('#boton-habilitar-correo').click(function () {
        if (ctn4 == 1) {
            $('#formulario-actualizar-correo :input').removeAttr('disabled');
            $('#boton-actualizar-correo').css('display', 'flex');
            $('#boton-habilitar-correo i').html('cancel');
            $('#boton-habilitar-correo > span > span').html('Cancelar');
            ctn4 = 0;
        } else {
            ctn4 = 1;
            $('#formulario-actualizar-correo :input').attr('disabled', 'disabled');
            $('#boton-actualizar-correo').css('display', 'none');
            var correoActual = $('#formulario-actualizar-correo input[name="correo_actual"]').val();
            $('#formulario-actualizar-correo input[name="correo"]').val(correoActual);
            $('#boton-habilitar-correo i').html('edit');
            $('#boton-habilitar-correo > span > span').html('Editar');
        }
    });
    /*PERFIL: ACTUALIZAR DOMICILIO*/
    var ctn5 = 1;
    $('#boton-habilitar-domicilio').click(function () {
        if (ctn5 == 1) {
            $('#formulario-actualizar-domicilio :input').removeAttr('disabled');
            $('#boton-actualizar-domicilio').css('display', 'flex');
            $('#boton-habilitar-domicilio i').html('cancel');
            $('#boton-habilitar-domicilio > span > span').html('Cancelar');
            ctn5 = 0;
        } else {
            ctn5 = 1;
            $('#formulario-actualizar-domicilio :input').attr('disabled', 'disabled');
            $('#boton-actualizar-domicilio').css('display', 'none');
            var domicilioActual = $('#formulario-actualizar-domicilio input[name="domicilio_actual"]').val();
            $('#formulario-actualizar-domicilio input[name="domicilio"]').val(domicilioActual);
            $('#boton-habilitar-domicilio i').html('edit');
            $('#boton-habilitar-domicilio > span > span').html('Editar');
        }
    });
    /*ADMINISTRADOR-X: VERIFICAR PERSONAL*/
    $('#verificar-personal').click(function () {
        $('#verificar-personal i').removeClass('green-text');
        $('#verificar-personal i').removeClass('grey-text');
        $('#verificar-personal i').addClass('grey-text');
        let ci = $('#agregar-ci').val();

        $.ajax({
            url: miUrl+'/datos/personal/'+ci,
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
            success: function(response) {
                if ($.isEmptyObject(response)) {
                    $('#modal-verificar-personal #ci').html('S/R');
                    $('#modal-verificar-personal #primer-apellido').html('S/R');
                    $('#modal-verificar-personal #segundo-apellido').html('S/R');
                    $('#modal-verificar-personal #nombres').html('S/R');
                } else {
                    let ci = response.persona_ci;
                    let primerApellido = response.persona_primer_apellido;
                    let segundoApellido = response.persona_segundo_apellido;
                    let nombres = response.persona_nombres;

                    $('#modal-verificar-personal #ci').html(ci);
                    $('#modal-verificar-personal #primer-apellido').html(primerApellido);
                    $('#modal-verificar-personal #segundo-apellido').html(segundoApellido);
                    $('#modal-verificar-personal #nombres').html(nombres);

                    $('#verificar-personal i').removeClass('grey-text');
                    $('#verificar-personal i').removeClass('green-text');
                    $('#verificar-personal i').addClass('green-text');
                }
            }
        });
    });
    /*ADMINISTRADOR-X: VERIFICAR ESTUDIANTE*/
    $('#verificar-estudiante').click(function () {
        $('#verificar-estudiante i').removeClass('green-text');
        $('#verificar-estudiante i').removeClass('grey-text');
        $('#verificar-estudiante i').addClass('grey-text');
        let ru = $('#agregar-ru').val();

        $.ajax({
            url: miUrl+'/datos/estudiante/'+ru,
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
            success: function(response) {
                if ($.isEmptyObject(response)) {
                    $('#modal-verificar-estudiante #ru').html('S/R');
                    $('#modal-verificar-estudiante #ci').html('S/R');
                    $('#modal-verificar-estudiante #primer-apellido').html('S/R');
                    $('#modal-verificar-estudiante #segundo-apellido').html('S/R');
                    $('#modal-verificar-estudiante #nombres').html('S/R');
                } else {
                    let ru = response.estudiante_ru;
                    let ci = response.persona_ci;
                    let primerApellido = response.persona_primer_apellido;
                    let segundoApellido = response.persona_segundo_apellido;
                    let nombres = response.persona_nombres;

                    $('#modal-verificar-estudiante #ru').html(ru);
                    $('#modal-verificar-estudiante #ci').html(ci);
                    $('#modal-verificar-estudiante #primer-apellido').html(primerApellido);
                    $('#modal-verificar-estudiante #segundo-apellido').html(segundoApellido);
                    $('#modal-verificar-estudiante #nombres').html(nombres);

                    $('#verificar-estudiante i').removeClass('grey-text');
                    $('#verificar-estudiante i').removeClass('green-text');
                    $('#verificar-estudiante i').addClass('green-text');
                }
            }
        });
    });
    /*ADMINISTRADOR-USUARIOS: ACTUALIZAR DATOS DE USUARIO*/
    $('.editar-datos-usuario').click(function () {
        let id = $(this).data('id');
        let ci = $(this).data('ci');
        let ru = $(this).data('ru');
        let primerApellido = $(this).data('primer_apellido');
        let segundoApellido = $(this).data('segundo_apellido');
        let nombres = $(this).data('nombres');
        let celular = $(this).data('celular');
        let correo = $(this).data('correo');
        $('#modal-editar-datos-usuario input[name="id"]').val(id);
        $('#modal-editar-datos-usuario #ci-actual').html(ci);
        $('#modal-editar-datos-usuario input[name="ci"]').val(ci);
        $('#modal-editar-datos-usuario #ru-actual').html(ru);
        $('#modal-editar-datos-usuario input[name="ru"]').val(ru);
        $('#modal-editar-datos-usuario #primer-apellido-actual').html(primerApellido);
        $('#modal-editar-datos-usuario input[name="primer_apellido"]').val(primerApellido);
        $('#modal-editar-datos-usuario #segundo-apellido-actual').html(segundoApellido);
        $('#modal-editar-datos-usuario input[name="segundo_apellido"]').val(segundoApellido);
        $('#modal-editar-datos-usuario #nombres-actual').html(nombres);
        $('#modal-editar-datos-usuario input[name="nombres"]').val(nombres);
        $('#modal-editar-datos-usuario #celular-actual').html(celular);
        $('#modal-editar-datos-usuario input[name="celular"]').val(celular);
        $('#modal-editar-datos-usuario #correo-actual').html(correo);
        $('#modal-editar-datos-usuario input[name="correo"]').val(correo);
    });
    /*ADMINISTRADOR-USUARIOS: ELIMINAR USUARIO*/
    $('.eliminar-usuario').click(function () {
        let id = $(this).data('id');
        let ci = $(this).data('ci');
        let primerApellido = $(this).data('primer_apellido');
        let segundoApellido = $(this).data('segundo_apellido');
        let nombres = $(this).data('nombres');
        $('#modal-eliminar-usuario input[name="id"]').val(id);
        $('#modal-eliminar-usuario input[name="ci"]').val(ci);
        $('#modal-eliminar-usuario #ci').html(ci);
        $('#modal-eliminar-usuario #primer-apellido').html(primerApellido);
        $('#modal-eliminar-usuario #segundo-apellido').html(segundoApellido);
        $('#modal-eliminar-usuario #nombres').html(nombres);
    });
    /*ADMINISTRADOR-USUARIOS: REINICIAR CONTRASEÑA*/
    $('.reiniciar-clave').click(function () {
        let id = $(this).data('id');
        let ci = $(this).data('ci');
        let primerApellido = $(this).data('primer_apellido');
        let segundoApellido = $(this).data('segundo_apellido');
        let nombres = $(this).data('nombres');
        $('#modal-reiniciar-clave input[name="id"]').val(id);
        $('#modal-reiniciar-clave input[name="ci"]').val(ci);
        $('#modal-reiniciar-clave #ci').html(ci);
        $('#modal-reiniciar-clave #primer-apellido').html(primerApellido);
        $('#modal-reiniciar-clave #segundo-apellido').html(segundoApellido);
        $('#modal-reiniciar-clave #nombres').html(nombres);
    });
    /*ADMINISTRADOR-ADMINISTRATIVOS: ACTUALIZAR DATOS DE ADMINISTRATIVO*/
    $('.editar-datos-administrativo').click(function () {
        let id = $(this).data('id');
        let ci = $(this).data('ci');
        let primerApellido = $(this).data('primer_apellido');
        let segundoApellido = $(this).data('segundo_apellido');
        let nombres = $(this).data('nombres');
        let celular = $(this).data('celular');
        let correo = $(this).data('correo');
        let cargo = $(this).data('cargo');
        let cargoId = $(this).data('cargo_id');
        $('#modal-editar-datos-administrativo input[name="id"]').val(id);
        $('#modal-editar-datos-administrativo #ci-actual').html(ci);
        $('#modal-editar-datos-administrativo input[name="ci"]').val(ci);
        $('#modal-editar-datos-administrativo #primer-apellido-actual').html(primerApellido);
        $('#modal-editar-datos-administrativo input[name="primer_apellido"]').val(primerApellido);
        $('#modal-editar-datos-administrativo #segundo-apellido-actual').html(segundoApellido);
        $('#modal-editar-datos-administrativo input[name="segundo_apellido"]').val(segundoApellido);
        $('#modal-editar-datos-administrativo #nombres-actual').html(nombres);
        $('#modal-editar-datos-administrativo input[name="nombres"]').val(nombres);
        $('#modal-editar-datos-administrativo #celular-actual').html(celular);
        $('#modal-editar-datos-administrativo input[name="celular"]').val(celular);
        $('#modal-editar-datos-administrativo #correo-actual').html(correo);
        $('#modal-editar-datos-administrativo input[name="correo"]').val(correo);
        $('#modal-editar-datos-administrativo #cargo-actual').html(cargo);
        $('#modal-editar-datos-administrativo select[name="cargo_id"] option[value="'+cargoId+'"]').prop('selected', true);
    });
    /*ADMINISTRADOR-ADMINISTRATIVOS: ELIMINAR ADMINISTRATIVO*/
    $('.eliminar-administrativo').click(function () {
        let id = $(this).data('id');
        let ci = $(this).data('ci');
        let primerApellido = $(this).data('primer_apellido');
        let segundoApellido = $(this).data('segundo_apellido');
        let nombres = $(this).data('nombres');
        $('#modal-eliminar-administrativo input[name="id"]').val(id);
        $('#modal-eliminar-administrativo input[name="ci"]').val(ci);
        $('#modal-eliminar-administrativo #ci').html(ci);
        $('#modal-eliminar-administrativo #primer-apellido').html(primerApellido);
        $('#modal-eliminar-administrativo #segundo-apellido').html(segundoApellido);
        $('#modal-eliminar-administrativo #nombres').html(nombres);
    });
    /*ADMINISTRADOR-AUXILIARES: ACTUALIZAR DATOS DE AUXILIAR*/
    $('.editar-datos-auxiliar').click(function () {
        let id = $(this).data('id');
        let ci = $(this).data('ci');
        let ru = $(this).data('ru');
        let primerApellido = $(this).data('primer_apellido');
        let segundoApellido = $(this).data('segundo_apellido');
        let nombres = $(this).data('nombres');
        let celular = $(this).data('celular');
        let correo = $(this).data('correo');
        $('#modal-editar-datos-auxiliar input[name="id"]').val(id);
        $('#modal-editar-datos-auxiliar #ci-actual').html(ci);
        $('#modal-editar-datos-auxiliar input[name="ci"]').val(ci);
        $('#modal-editar-datos-auxiliar #ru-actual').html(ru);
        $('#modal-editar-datos-auxiliar input[name="ru"]').val(ru);
        $('#modal-editar-datos-auxiliar #primer-apellido-actual').html(primerApellido);
        $('#modal-editar-datos-auxiliar input[name="primer_apellido"]').val(primerApellido);
        $('#modal-editar-datos-auxiliar #segundo-apellido-actual').html(segundoApellido);
        $('#modal-editar-datos-auxiliar input[name="segundo_apellido"]').val(segundoApellido);
        $('#modal-editar-datos-auxiliar #nombres-actual').html(nombres);
        $('#modal-editar-datos-auxiliar input[name="nombres"]').val(nombres);
        $('#modal-editar-datos-auxiliar #celular-actual').html(celular);
        $('#modal-editar-datos-auxiliar input[name="celular"]').val(celular);
        $('#modal-editar-datos-auxiliar #correo-actual').html(correo);
        $('#modal-editar-datos-auxiliar input[name="correo"]').val(correo);
    });
    /*ADMINISTRADOR-AUXILIARES: ELIMINAR AUXILIAR*/
    $('.eliminar-auxiliar').click(function () {
        let id = $(this).data('id');
        let ci = $(this).data('ci');
        let primerApellido = $(this).data('primer_apellido');
        let segundoApellido = $(this).data('segundo_apellido');
        let nombres = $(this).data('nombres');
        $('#modal-eliminar-auxiliar input[name="id"]').val(id);
        $('#modal-eliminar-auxiliar input[name="ci"]').val(ci);
        $('#modal-eliminar-auxiliar #ci').html(ci);
        $('#modal-eliminar-auxiliar #primer-apellido').html(primerApellido);
        $('#modal-eliminar-auxiliar #segundo-apellido').html(segundoApellido);
        $('#modal-eliminar-auxiliar #nombres').html(nombres);
    });
    /*ADMINISTRADOR-DOCENTES: ACTUALIZAR DATOS DE DOCENTE*/
    $('.editar-datos-docente').click(function () {
        let id = $(this).data('id');
        let ci = $(this).data('ci');
        let primerApellido = $(this).data('primer_apellido');
        let segundoApellido = $(this).data('segundo_apellido');
        let nombres = $(this).data('nombres');
        let celular = $(this).data('celular');
        let correo = $(this).data('correo');
        let grado = $(this).data('grado');
        let categoria = $(this).data('categoria');
        let categoriaId = $(this).data('categoria_id');
        $('#modal-editar-datos-docente input[name="id"]').val(id);
        $('#modal-editar-datos-docente #ci-actual').html(ci);
        $('#modal-editar-datos-docente input[name="ci"]').val(ci);
        $('#modal-editar-datos-docente #primer-apellido-actual').html(primerApellido);
        $('#modal-editar-datos-docente input[name="primer_apellido"]').val(primerApellido);
        $('#modal-editar-datos-docente #segundo-apellido-actual').html(segundoApellido);
        $('#modal-editar-datos-docente input[name="segundo_apellido"]').val(segundoApellido);
        $('#modal-editar-datos-docente #nombres-actual').html(nombres);
        $('#modal-editar-datos-docente input[name="nombres"]').val(nombres);
        $('#modal-editar-datos-docente #celular-actual').html(celular);
        $('#modal-editar-datos-docente input[name="celular"]').val(celular);
        $('#modal-editar-datos-docente #correo-actual').html(correo);
        $('#modal-editar-datos-docente input[name="correo"]').val(correo);
        $('#modal-editar-datos-docente #grado-actual').html(grado);
        $('#modal-editar-datos-docente select[name="grado"] option[value="'+grado+'"]').prop('selected', true);
        $('#modal-editar-datos-docente #categoria-actual').html(categoria);
        $('#modal-editar-datos-docente select[name="categoria_id"] option[value="'+categoriaId+'"]').prop('selected', true);
    });
    /*ADMINISTRADOR-DOCENTES: ELIMINAR DOCENTE*/
    $('.eliminar-docente').click(function () {
        let id = $(this).data('id');
        let ci = $(this).data('ci');
        let primerApellido = $(this).data('primer_apellido');
        let segundoApellido = $(this).data('segundo_apellido');
        let nombres = $(this).data('nombres');
        $('#modal-eliminar-docente input[name="id"]').val(id);
        $('#modal-eliminar-docente input[name="ci"]').val(ci);
        $('#modal-eliminar-docente #ci').html(ci);
        $('#modal-eliminar-docente #primer-apellido').html(primerApellido);
        $('#modal-eliminar-docente #segundo-apellido').html(segundoApellido);
        $('#modal-eliminar-docente #nombres').html(nombres);
    });
    /*ADMINISTRADOR-ESTUDIANTES: ACTUALIZAR DATOS DE ESTUDIANTE*/
    $('.editar-datos-estudiante').click(function () {
        let id = $(this).data('id');
        let ci = $(this).data('ci');
        let ru = $(this).data('ru');
        let primerApellido = $(this).data('primer_apellido');
        let segundoApellido = $(this).data('segundo_apellido');
        let nombres = $(this).data('nombres');
        let celular = $(this).data('celular');
        let correo = $(this).data('correo');
        $('#modal-editar-datos-estudiante input[name="id"]').val(id);
        $('#modal-editar-datos-estudiante #ci-actual').html(ci);
        $('#modal-editar-datos-estudiante input[name="ci"]').val(ci);
        $('#modal-editar-datos-estudiante #ru-actual').html(ru);
        $('#modal-editar-datos-estudiante input[name="ru"]').val(ru);
        $('#modal-editar-datos-estudiante #primer-apellido-actual').html(primerApellido);
        $('#modal-editar-datos-estudiante input[name="primer_apellido"]').val(primerApellido);
        $('#modal-editar-datos-estudiante #segundo-apellido-actual').html(segundoApellido);
        $('#modal-editar-datos-estudiante input[name="segundo_apellido"]').val(segundoApellido);
        $('#modal-editar-datos-estudiante #nombres-actual').html(nombres);
        $('#modal-editar-datos-estudiante input[name="nombres"]').val(nombres);
        $('#modal-editar-datos-estudiante #celular-actual').html(celular);
        $('#modal-editar-datos-estudiante input[name="celular"]').val(celular);
        $('#modal-editar-datos-estudiante #correo-actual').html(correo);
        $('#modal-editar-datos-estudiante input[name="correo"]').val(correo);
    });
    /*ADMINISTRADOR-ESTUDIANTES: ELIMINAR ESTUDIANTE*/
    $('.eliminar-estudiante').click(function () {
        let id = $(this).data('id');
        let ci = $(this).data('ci');
        let primerApellido = $(this).data('primer_apellido');
        let segundoApellido = $(this).data('segundo_apellido');
        let nombres = $(this).data('nombres');
        $('#modal-eliminar-estudiante input[name="id"]').val(id);
        $('#modal-eliminar-estudiante input[name="ci"]').val(ci);
        $('#modal-eliminar-estudiante #ci').html(ci);
        $('#modal-eliminar-estudiante #primer-apellido').html(primerApellido);
        $('#modal-eliminar-estudiante #segundo-apellido').html(segundoApellido);
        $('#modal-eliminar-estudiante #nombres').html(nombres);
    });
    /*ADMINISTRADOR-USUARIOS: ACTUALIZAR CARGO DE ADMINISTRATIVO*/
    $('#editar-cargo').click(function () {
        $('.datos-administrativo form .cargo-vista').css('display', 'none');
        $('.datos-administrativo form .cargo').css('display', 'inline-block');
        $('#editar-cargo').css('display', 'none');
        $('#actualizar-cargo').css('display', 'inline-block');
        $('#cancelar-cargo').css('display', 'inline-block');
    });
    $('#cancelar-cargo').click(function () {
        $('.datos-administrativo form .cargo').css('display', 'none');
        $('.datos-administrativo form .cargo-vista').css('display', 'inline-block');
        $('#editar-cargo').css('display', 'inline-block');
        $('#actualizar-cargo').css('display', 'none');
        $('#cancelar-cargo').css('display', 'none');
    });
    /*ADMINISTRADOR-USUARIOS: ACTUALIZAR CATEGORIA DE DOCENTE*/
    $('#editar-categoria').click(function () {
        $('.datos-docente form .categoria-vista').css('display', 'none');
        $('.datos-docente form .categoria').css('display', 'inline-block');
        $('#editar-categoria').css('display', 'none');
        $('#actualizar-categoria').css('display', 'inline-block');
        $('#cancelar-categoria').css('display', 'inline-block');
    });
    $('#cancelar-categoria').click(function () {
        $('.datos-docente form .categoria').css('display', 'none');
        $('.datos-docente form .categoria-vista').css('display', 'inline-block');
        $('#editar-categoria').css('display', 'inline-block');
        $('#actualizar-categoria').css('display', 'none');
        $('#cancelar-categoria').css('display', 'none');
    });
    /*ADMINISTRADOR-USUARIOS: ACTUALIZAR GRADO DE DOCENTE*/
    $('#editar-grado').click(function () {
        $('.datos-docente form .grado-vista').css('display', 'none');
        $('.datos-docente form .grado').css('display', 'inline-block');
        $('#editar-grado').css('display', 'none');
        $('#actualizar-grado').css('display', 'inline-block');
        $('#cancelar-grado').css('display', 'inline-block');
    });
    $('#cancelar-grado').click(function () {
        $('.datos-docente form .grado').css('display', 'none');
        $('.datos-docente form .grado-vista').css('display', 'inline-block');
        $('#editar-grado').css('display', 'inline-block');
        $('#actualizar-grado').css('display', 'none');
        $('#cancelar-grado').css('display', 'none');
    });
    /*ADMINISTRADOR-USUARIOS: ACTUALIZAR MENCIÓN DE ESTUDIANTE*/
    $('#editar-mencion').click(function () {
        $('.datos-estudiante form .mencion-vista').css('display', 'none');
        $('.datos-estudiante form .mencion').css('display', 'inline-block');
        $('#editar-mencion').css('display', 'none');
        $('#actualizar-mencion').css('display', 'inline-block');
        $('#cancelar-mencion').css('display', 'inline-block');
    });
    $('#cancelar-mencion').click(function () {
        $('.datos-estudiante form .mencion').css('display', 'none');
        $('.datos-estudiante form .mencion-vista').css('display', 'inline-block');
        $('#editar-mencion').css('display', 'inline-block');
        $('#actualizar-mencion').css('display', 'none');
        $('#cancelar-mencion').css('display', 'none');
    });
    /*ADMINISTRADOR-USUARIOS: ACTUALIZAR R.U. DE ESTUDIANTE*/
    $('#editar-ru').click(function () {
        $('.datos-estudiante form.ru :input').removeAttr('disabled');
        $('#editar-ru').css('display', 'none');
        $('#actualizar-ru').css('display', 'inline-block');
        $('#cancelar-ru').css('display', 'inline-block');
    });
    $('#cancelar-ru').click(function () {
        $('.datos-estudiante form.ru :input').attr('disabled', 'disabled');
        $('#editar-ru').css('display', 'inline-block');
        $('#actualizar-ru').css('display', 'none');
        $('#cancelar-ru').css('display', 'none');
        var ru_actual = $('.ru form input[name="ru_actual"]').val();
        $('.ru form input[name="ru"]').val(ru_actual);
    });
    /*ADMINISTRADOR-USUARIOS: ACTUALIZAR INFORMACIÓN NOMBRE COMPLETO DE ESTUDIANTE*/
    $('#editar-nombre-completo').click(function () {
        $('.datos-personales form.nombres :input').removeAttr('disabled');
        $('#editar-nombre-completo').css('display', 'none');
        $('#actualizar-nombre-completo').css('display', 'inline-block');
        $('#cancelar-nombre-completo').css('display', 'inline-block');
    });
    $('#cancelar-nombre-completo').click(function () {
        $('.datos-personales form.nombres :input').attr('disabled', 'disabled');
        $('#editar-nombre-completo').css('display', 'inline-block');
        $('#actualizar-nombre-completo').css('display', 'none');
        $('#cancelar-nombre-completo').css('display', 'none');
        var primerApellidoActual = $('.datos-personales form.nombres input[name="primer_apellido_actual"]').val();
        var segundoApellidoActual = $('.datos-personales form.nombres input[name="segundo_apellido_actual"]').val();
        var nombresActual = $('.datos-personales form.nombres input[name="nombres_actual"]').val();
        $('.datos-personales form.nombres input[name="primer_apellido"]').val(primerApellidoActual);
        $('.datos-personales form.nombres input[name="segundo_apellido"]').val(segundoApellidoActual);
        $('.datos-personales form.nombres input[name="nombres"]').val(nombresActual);
    });
    /*ADMINISTRADOR-USUARIOS: ACTUALIZAR C.I. DE ESTUDIANTE*/
    $('#editar-ci').click(function () {
        $('.datos-personales form.ci :input').removeAttr('disabled');
        $('#editar-ci').css('display', 'none');
        $('#actualizar-ci').css('display', 'inline-block');
        $('#cancelar-ci').css('display', 'inline-block');
    });
    $('#cancelar-ci').click(function () {
        $('.datos-personales form.ci :input').attr('disabled', 'disabled');
        $('#editar-ci').css('display', 'inline-block');
        $('#actualizar-ci').css('display', 'none');
        $('#cancelar-ci').css('display', 'none');
        var ciActual = $('.datos-personales form.ci input[name="ci_actual"]').val();
        $('.datos-personales form.ci input[name="ci"]').val(ciActual);
    });
    /*ADMINISTRADOR-USUARIOS: ACTUALIZAR CELULAR DE USUARIO*/
    $('#editar-celular').click(function () {
        $('.datos-contacto form.celular :input').removeAttr('disabled');
        $('#editar-celular').css('display', 'none');
        $('#actualizar-celular').css('display', 'inline-block');
        $('#cancelar-celular').css('display', 'inline-block');
    });
    $('#cancelar-celular').click(function () {
        $('.datos-contacto form.celular :input').attr('disabled', 'disabled');
        $('#editar-celular').css('display', 'inline-block');
        $('#actualizar-celular').css('display', 'none');
        $('#cancelar-celular').css('display', 'none');
        var codigoActual = $('.datos-contacto form.celular input[name="codigo_actual"]').val();
        var celularActual = $('.datos-contacto form.celular input[name="celular_actual"]').val();
        $('.datos-contacto form input[name="code"]').val(codigoActual);
        $('.datos-contacto form input[name="celular"]').val(celularActual);
    });
    /*ADMINISTRADOR-USUARIOS: ACTUALIZAR CORREO DE USUARIO*/
    $('#editar-correo').click(function () {
        $('.datos-contacto form.correo :input').removeAttr('disabled');
        $('#editar-correo').css('display', 'none');
        $('#actualizar-correo').css('display', 'inline-block');
        $('#cancelar-correo').css('display', 'inline-block');
    });
    $('#cancelar-correo').click(function () {
        $('.datos-contacto form.correo :input').attr('disabled', 'disabled');
        $('#editar-correo').css('display', 'inline-block');
        $('#actualizar-correo').css('display', 'none');
        $('#cancelar-correo').css('display', 'none');
        var correoActual = $('.datos-contacto form.correo input[name="correo_actual"]').val();
        $('.datos-contacto form input[name="correo"]').val(correoActual);
    });
    /*ADMINISTRADOR-USUARIOS: CREAR USUARIO*/
    $('.modal-confirmar-crear-usuario').on('click', function () {
        let valorSeleccionado =  $('#seleccionar-rol').val();

        if (valorSeleccionado == 2) {
            $('#cargo').css('display', 'block');
            $('#categoria').css('display', 'none');
            $('#_grado').css('display', 'none');
            $('#_auxiliar').css('display', 'none');
            $('#_ru').css('display', 'none');
            $('#ru').removeAttr('required')
        } else if (valorSeleccionado == 4) {
            $('#cargo').css('display', 'none');
            $('#categoria').css('display', 'block');
            $('#_grado').css('display', 'block');
            $('#_auxiliar').css('display', 'none');
            $('#_ru').css('display', 'none');
            $('#ru').removeAttr('required')
        } else if (valorSeleccionado == 5) {
            $('#cargo').css('display', 'none');
            $('#categoria').css('display', 'none');
            $('#_grado').css('display', 'none');
            $('#_auxiliar').css('display', 'block');
            $('#_ru').css('display', 'block');
            $('#ru').prop("required", true);
        }
        else {
            $('#cargo').css('display', 'none');
            $('#categoria').css('display', 'none');
            $('#_grado').css('display', 'none');
            $('#_auxiliar').css('display', 'none');
            $('#_ru').css('display', 'none');
            $('#ru').removeAttr('required')
        }
    });
    /*ADMINISTRADOR-USUARIOS: CREAR USUARIO - CAMBIAR DE ROL*/
    $('.administrador-usuarios #seleccionar-rol').on('change', function () {
        let valorSeleccionado = $(this).val();
        
        if (valorSeleccionado == 2) {
            $('#cargo').css('display', 'block');
            $('#categoria').css('display', 'none');
            $('#_grado').css('display', 'none');
            $('#_auxiliar').css('display', 'none');
            $('#_ru').css('display', 'none');
            $('#ru').removeAttr('required')
        } else if (valorSeleccionado == 4) {
            $('#cargo').css('display', 'none');
            $('#categoria').css('display', 'block');
            $('#_grado').css('display', 'block');
            $('#_auxiliar').css('display', 'none');
            $('#_ru').css('display', 'none');
            $('#ru').removeAttr('required')
        } else if (valorSeleccionado == 5) {
            $('#cargo').css('display', 'none');
            $('#categoria').css('display', 'none');
            $('#_grado').css('display', 'none');
            $('#_auxiliar').css('display', 'block');
            $('#_ru').css('display', 'block');
            $('#ru').prop("required", true);
        }
        else {
            $('#cargo').css('display', 'none');
            $('#categoria').css('display', 'none');
            $('#_grado').css('display', 'none');
            $('#_auxiliar').css('display', 'none');
            $('#_ru').css('display', 'none');
            $('#ru').removeAttr('required')
        }
    });
    /*ADMINISTRADOR-CARRERA: CREAR ASIGNATURA*/
    $('#modal-crear-asignatura').on('click', function () {
        // Se excluye a los eventos seleccionar-mencion y prerrequisito, ya que son eventos independientes
    });
    $('.seleccionar-mencion').on('click', function () {
        var id = $(this).attr('id').split('mencion-')[1];
        let idForm = $(this).closest('form').attr('id');
        console.log(idForm);
        if($(this).prop("checked")) {
            $('#'+idForm+' #prerrequisito-'+id).removeAttr('disabled');
            $('#'+idForm+' #semestre-'+id).removeAttr('disabled');
            $('#'+idForm+' #semestre-'+id).prop("required", true);
            if($('#'+idForm+' #prerrequisito-'+id).prop("checked")) {
                $('#'+idForm+' #asignatura-id-prerrequisito-'+id).attr('disabled', 'disabled');
                $('#'+idForm+' #asignatura-id-prerrequisito-'+id).removeAttr('required');
                $('#'+idForm+' #asignatura-id-prerrequisito-'+id).parent().css('display', 'none');
                $('#'+idForm+' #comentario-prerrequisito-'+id).removeAttr('disabled');
                $('#'+idForm+' #comentario-prerrequisito-'+id).prop("required", true);
                $('#'+idForm+' #comentario-prerrequisito-'+id).parent().css('display', 'block');
            } else {
                $('#'+idForm+' #asignatura-id-prerrequisito-'+id).removeAttr('disabled');
                $('#'+idForm+' #asignatura-id-prerrequisito-'+id).prop("required", true);
                $('#'+idForm+' #asignatura-id-prerrequisito-'+id).parent().css('display', 'block');
                $('#'+idForm+' #comentario-prerrequisito-'+id).attr('disabled', 'disabled');
                $('#'+idForm+' #comentario-prerrequisito-'+id).removeAttr('required');
                $('#'+idForm+' #comentario-prerrequisito-'+id).parent().css('display', 'none');
            }
        } else {
            $('#'+idForm+' #prerrequisito-'+id).attr('disabled', 'disabled');
            $('#'+idForm+' #semestre-'+id).attr('disabled', 'disabled');
            $('#'+idForm+' #semestre-'+id).removeAttr('required');
            $('#'+idForm+' #asignatura-id-prerrequisito-'+id).attr('disabled', 'disabled');
            $('#'+idForm+' #asignatura-id-prerrequisito-'+id).removeAttr('required');
            $('#'+idForm+' #comentario-prerrequisito-'+id).attr('disabled', 'disabled');
            $('#'+idForm+' #comentario-prerrequisito-'+id).removeAttr('required');
        }
    });
    $(document).on('click', '.prerrequisito', function (event) {
    // $('.prerrequisito').on('click', function () {
        let idForm = $(this).closest('form').attr('id');
        let id = $(this).attr('id');
        console.log(idForm);
        if($(this).prop("checked")) {
            $('#'+idForm+' #asignatura-id-'+id).attr('disabled', 'disabled');
            $('#'+idForm+' #asignatura-id-'+id).removeAttr('required');
            $('#'+idForm+' #asignatura-id-'+id).parent().css('display', 'none');
            $('#'+idForm+' #comentario-'+id).removeAttr('disabled');
            $('#'+idForm+' #comentario-'+id).prop("required", true);
            $('#'+idForm+' #comentario-'+id).parent().css('display', 'block');
        } else {
            $('#'+idForm+' #asignatura-id-'+id).removeAttr('disabled');
            $('#'+idForm+' #asignatura-id-'+id).prop("required", true);
            $('#'+idForm+' #asignatura-id-'+id).parent().css('display', 'block');
            $('#'+idForm+' #comentario-'+id).attr('disabled', 'disabled');
            $('#'+idForm+' #comentario-'+id).removeAttr('required');
            $('#'+idForm+' #comentario-'+id).parent().css('display', 'none');
        }
    });
    // $(document).on('click', '._prerrequisito', function (event) {
    //     let id = $(this).attr('id');
    //     if($(this).prop("checked")) {
    //         console.log(id);
    //         $('#_asignatura-id-'+id).attr('disabled', 'disabled');
    //         $('#_asignatura-id-'+id).removeAttr('required');
    //         $('#_asignatura-id-'+id).parent().css('display', 'none');
    //         $('#_comentario-'+id).removeAttr('disabled');
    //         $('#_comentario-'+id).prop("required", true);
    //         $('#_comentario-'+id).parent().css('display', 'block');
    //     } else {
    //         $('#_asignatura-id-'+id).removeAttr('disabled');
    //         $('#_asignatura-id-'+id).prop("required", true);
    //         $('#_asignatura-id-'+id).parent().css('display', 'block');
    //         $('#_comentario-'+id).attr('disabled', 'disabled');
    //         $('#_comentario-'+id).removeAttr('required');
    //         $('#_comentario-'+id).parent().css('display', 'none');
    //     }
    // });
    /*ADMINISTRADOR-CARRERA: ACTUALIZAR ASIGNATURA*/
    $(document).on('click', '.editar-asignatura', function (event) {
    // $('.editar-asignatura').click(function () {
        let id = $(this).data('id');
        let sigla = $(this).data('sigla');
        let asignatura = $(this).data('asignatura');
        let laboratorio = $(this).data('laboratorio');
        let auxiliatura = $(this).data('auxiliatura');
        $('#modal-editar-asignatura input[name="id"]').val(id);
        $('#modal-editar-asignatura input[name="sigla"]').val(sigla);
        $('#modal-editar-asignatura input[name="asignatura"]').val(asignatura);
        $('#modal-editar-asignatura input[name="laboratorio"]').attr("checked", laboratorio == 1 ? true:false);
        $('#modal-editar-asignatura input[name="auxiliatura"]').attr("checked", auxiliatura == 1 ? true:false);
        $('#modal-editar-asignatura #sigla-actual').html(sigla);
        $('#modal-editar-asignatura #asignatura-actual').html(asignatura);
        $('#modal-editar-asignatura #laboratorio-actual i').removeClass("teal-text");
        $('#modal-editar-asignatura #laboratorio-actual i').removeClass("red-text");
        $('#modal-editar-asignatura #laboratorio-actual i').html(laboratorio == 1 ? "check":"close");
        $('#modal-editar-asignatura #laboratorio-actual i').addClass(laboratorio == 1 ? "teal-text":"red-text");
        $('#modal-editar-asignatura #auxiliatura-actual i').removeClass("teal-text");
        $('#modal-editar-asignatura #auxiliatura-actual i').removeClass("red-text");
        $('#modal-editar-asignatura #auxiliatura-actual i').html(auxiliatura == 1 ? "check":"close");
        $('#modal-editar-asignatura #auxiliatura-actual i').addClass(auxiliatura == 1 ? "teal-text":"red-text");
        $('#modal-editar-asignatura table tbody .nueva-fila').empty();
        
        $.ajax({
            url: miUrl+'/datos/pensum-asignatura-completo/'+id,
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
            success: function(response) {
                let pensum = response.pensum;
                let semestres = response.semestres;
                let asignaturas = response.asignaturas;
                if ($.isEmptyObject(response)) {
                    let nuevaFila =  `
                        <tr class="nueva-fila">
                            <td colspan="4" class="center"><strong class="red-text">SIN DATOS</strong></td>
                        </tr>
                    `;
                    $('#modal-editar-asignatura table tbody').append(nuevaFila);
                } else {
                    pensum.forEach(function(pensum) {
                        let prerrequisito = pensum.vista_asignatura_sigla;
                        let asignaturaId = pensum.vista_asignatura_id;
                        let semestreId = pensum.semestre_id;
                        let prerrequisitoChecked = "";
                        let requiredComentario = "";
                        let disabledComentario = "disabled";
                        let displayComentario = "none";
                        let requiredSelect = "required";
                        let disabledSelect = "";
                        let displaySelect = "block";
                        if (prerrequisito === null) {
                            prerrequisito = pensum.vista_comentario;
                            prerrequisitoChecked = "checked";
                            requiredComentario = "required";
                            disabledComentario = "";
                            displayComentario = "block";
                            requiredSelect = "";
                            disabledSelect = "disabled";
                            displaySelect = "none";
                        }
                        let nuevaFilaA =  `
                            <tr class="nueva-fila">
                                <td rowspan="2">${pensum.mencion_nombre}</td>
                                <td>Semestre</td>
                                <td>${pensum.semestre_numerico}</td>
                                <td>
                                    <div class="col s3">
                                        <select id="semestre-${pensum.mencion_id}" name="semestres_id[${pensum.mencion_id}]" class="browser-default" required>
                            `;
                        // $('#modal-editar-asignatura table tbody').append(nuevaFilaA);
                        
                        semestres.forEach(function(semestre) {
                            let selected;
                            if (semestreId == semestre.semestre_id) {
                                selected = "selected";
                            } else {
                                selected = "";
                            }
                            let nuevaOpcion =  `
                                <option ${selected} value="${semestre.semestre_id}">${semestre.semestre_numerico}</option>
                            `;
                            nuevaFilaA = nuevaFilaA + nuevaOpcion;
                            // $('#modal-editar-asignatura table tbody #_semestre-'+pensum.mencion_id).append(nuevaOpcion);
                        });
                        
                        let nuevaFilaB =  `
                                        </select>
                                    </div>
                                </td>
                            </tr>   
                            <tr class="nueva-fila">
                                <td>Prerrequisito</td>
                                <td>${prerrequisito}</td>
                                <td>
                                    <div class="input-field col s5 comentario-prerrequisito" style="display:${displayComentario}">
                                        <input type="text" name="comentarios_prerrequisito[${pensum.mencion_id}]" id="comentario-prerrequisito-${pensum.mencion_id}" value="${prerrequisito}" placeholder="Aprobar 5 materias" class="validate"  ${disabledComentario} ${requiredComentario} >
                                    </div>
                                    <div class="col s5" style="display:${displaySelect}">
                                        <select id="asignatura-id-prerrequisito-${pensum.mencion_id}" class="browser-default" name="asignaturas_id_prerrequisito[${pensum.mencion_id}]" ${disabledSelect} ${requiredSelect} >
                         `;
                        // $('#modal-editar-asignatura table tbody').append(nuevaFilaB);
                        
                        asignaturas.forEach(function(asignatura) {
                            let selected;
                            if (asignaturaId == asignatura.asignatura_id) {
                                selected = "selected";
                            } else {
                                selected = "";
                            }
                            let nuevaOpcion =  `
                                <option ${selected} value="${asignatura.asignatura_id}">(Sem. ${asignatura.semestre_numerico}) ${asignatura.asignatura_sigla}</option>
                            `;
                            nuevaFilaB = nuevaFilaB + nuevaOpcion;
                            // $('#modal-editar-asignatura table tbody #_asignatura-id-prerrequisito-'+pensum.mencion_id).append(nuevaOpcion);
                        });
                        
                        let nuevaFilaC =  `
                                        </select>
                                    </div>
                                    <div class="input-field col s4">
                                        <p>
                                            <label>
                                                <input ${prerrequisitoChecked} type="checkbox" class="prerrequisito validate" id="prerrequisito-${pensum.mencion_id}" name="prerrequisitos[${pensum.mencion_id}]" />
                                                <span>Solo texto</span>
                                            </label>
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        `;
                        let nuevaFila = nuevaFilaA+nuevaFilaB+nuevaFilaC;
                        $('#modal-editar-asignatura table tbody').append(nuevaFila);
                    });
                }
            }
        });
    });
    /*ADMINISTRADOR-CARRERA: ELIMINAR ASIGNATURA*/
    $('.eliminar-asignatura').click(function () {
        let id = $(this).data('id');
        let sigla = $(this).data('sigla');
        let asignatura = $(this).data('asignatura');
        $('#modal-eliminar-asignatura input[name="id"]').val(id);
        $('#modal-eliminar-asignatura input[name="sigla"]').val(sigla);
        $('#modal-eliminar-asignatura input[name="asignatura"]').val(asignatura);
        $('#modal-eliminar-asignatura #sigla').html(sigla);
        $('#modal-eliminar-asignatura #asignatura').html(asignatura);
    });
    /*ADMINISTRADOR-CARRERA: ACTUALIZAR AULA*/
    $('.editar-aula').click(function () {
        let id = $(this).data('id');
        let aula = $(this).data('aula');
        let capacidad = $(this).data('capacidad');
        $('#modal-editar-aula input[name="id"]').val(id);
        $('#modal-editar-aula #aula-actual').html(aula);
        $('#modal-editar-aula input[name="aula"]').val(aula);
        $('#modal-editar-aula #capacidad-actual').html(capacidad);
        $('#modal-editar-aula input[name="capacidad"]').val(capacidad);
    });
    /*ADMINISTRADOR-CARRERA: ELIMINAR AULA*/
    $('.eliminar-aula').click(function () {
        let id = $(this).data('id');
        let aula = $(this).data('aula');
        $('#modal-eliminar-aula input[name="id"]').val(id);
        $('#modal-eliminar-aula input[name="aula"]').val(aula);
        $('#modal-eliminar-aula strong').html(aula);
    });
    /*ADMINISTRADOR-CARRERA: ACTUALIZAR MENCIÓN*/
    $('.editar-mencion').click(function () {
        let id = $(this).data('id');
        let mencion = $(this).data('mencion');
        $('#modal-editar-mencion input[name="id"]').val(id);
        $('#modal-editar-mencion #mencion-actual').html(mencion);
        $('#modal-editar-mencion input[name="mencion"]').val(mencion);
    });
    /*ADMINISTRADOR-CARRERA: ELIMINAR MENCIÓN*/
    $('.eliminar-mencion').click(function () {
        let id = $(this).data('id');
        let mencion = $(this).data('mencion');
        $('#modal-eliminar-mencion input[name="id"]').val(id);
        $('#modal-eliminar-mencion input[name="mencion"]').val(mencion);
        $('#modal-eliminar-mencion strong').html(mencion);
    });
    /*ADMINISTRADOR-CARRERA: ACTUALIZAR PLAN DE ESTUDIO*/
    $('.editar-plan-estudio').click(function () {
        let id = $(this).data('id');
        let planEstudio = $(this).data('plan_estudio');
        $('#modal-editar-plan-estudio input[name="id"]').val(id);
        $('#modal-editar-plan-estudio #plan-estudio-actual').html(planEstudio);
        $('#modal-editar-plan-estudio input[name="plan_estudio"]').val(planEstudio);
    });
    /*ADMINISTRADOR-CARRERA: ELIMINAR PLAN DE ESTUDIO*/
    $('.eliminar-plan-estudio').click(function () {
        let id = $(this).data('id');
        let planEstudio = $(this).data('plan_estudio');
        $('#modal-eliminar-plan-estudio input[name="id"]').val(id);
        $('#modal-eliminar-plan-estudio input[name="plan_estudio"]').val(planEstudio);
        $('#modal-eliminar-plan-estudio strong').html(planEstudio);
    });
    /*ADMINISTRADOR-INSCRIPCION: EDITAR PARALELO*/
    $('.modal-editar-paralelo').click(function () {
        let id = $(this).data('id');
        let sigla = $(this).data('sigla');
        let paralelo = $(this).data('paralelo');
        $('#modal-editar-paralelo input[name="id"]').val(id);
        $('#modal-editar-paralelo input[name="sigla"]').val(sigla);
        $('#modal-editar-paralelo input[name="paralelo"]').val(paralelo);
        $('#modal-editar-paralelo #sigla').html(sigla);
        $('#modal-editar-paralelo #paralelo-actual').html(paralelo);
    });
    /*ADMINISTRADOR-INSCRIPCION: ELIMINAR PARALELO*/
    $('.modal-eliminar-paralelo').click(function () {
        let id = $(this).data('id');
        let sigla = $(this).data('sigla');
        let paralelo = $(this).data('paralelo');
        $('#modal-eliminar-paralelo input[name="id"]').val(id);
        $('#modal-eliminar-paralelo input[name="sigla"]').val(sigla);
        $('#modal-eliminar-paralelo input[name="paralelo"]').val(paralelo);
        $('#modal-eliminar-paralelo #sigla').html(sigla);
        $('#modal-eliminar-paralelo #paralelo').html(paralelo);
    });
    /*ADMINISTRADOR-INSCRIPCION: CREAR PARALELO*/
    $('.modal-crear-paralelo').click(function () {
        let id = $(this).data('id');
        let sigla = $(this).data('sigla');
        $('#modal-crear-paralelo input[name="id"]').val(id);
        $('#modal-crear-paralelo strong').html(sigla);
        $('#modal-crear-paralelo input[name="sigla"]').val(sigla);
    });
    /*ADMINISTRADOR-INSCRIPCION: HABILITAR LABORATORIO*/
    $('.laboratorio-independiente').click(function () {
        let id = $(this).data('id');
        let sigla = $(this).data('sigla');
        console.log(id);
        $('#modal-laboratorio-independiente input[name="id"]').val(id);
        $('#modal-laboratorio-independiente input[name="sigla"]').val(sigla);
        $('#modal-laboratorio-independiente #sigla').html(sigla);
    });
    /*ADMINISTRADOR-INSCRIPCION: DESHABILITAR LABORATORIO*/
    $('.laboratorio-dependiente').click(function () {
        let id = $(this).data('id');
        let sigla = $(this).data('sigla');
        $('#modal-laboratorio-dependiente input[name="id"]').val(id);
        $('#modal-laboratorio-dependiente input[name="sigla"]').val(sigla);
        $('#modal-laboratorio-dependiente #sigla').html(sigla);
    });
    /*ADMINISTRADOR-INSCRIPCION: CREAR LABORATORIO*/
    $('.crear-laboratorio').click(function () {
        let id = $(this).data('id');
        let sigla = $(this).data('sigla');
        $('#modal-crear-laboratorio input[name="id"]').val(id);
        $('#modal-crear-laboratorio strong').html(sigla);
        $('#modal-crear-laboratorio input[name="sigla"]').val(sigla);
    });
    /*ADMINISTRADOR-INSCRIPCION: ELIMINAR LABORATORIO*/
    $('.modal-eliminar-laboratorio').click(function () {
        let id = $(this).data('id');
        let sigla = $(this).data('sigla');
        $('#modal-eliminar-laboratorio input[name="id"]').val(id);
        $('#modal-eliminar-laboratorio input[name="sigla"]').val(sigla);
        $('#modal-eliminar-laboratorio #sigla').html(sigla);
        $('#modal-eliminar-laboratorio #laboratorio').html(paralelo);
    });
    /*ADMINISTRADOR-INSCRIPCION: CREAR GRUPO AUXILIATURA*/
    $('.modal-crear-grupo').click(function () {
        let id = $(this).data('id');
        let paralelo = $(this).data('paralelo');
        let sigla = $(this).data('sigla')+" (paralelo "+paralelo+")";
        $('#modal-crear-grupo input[name="id"]').val(id);
        $('#modal-crear-grupo strong').html(sigla);
        $('#modal-crear-grupo input[name="sigla"]').val(sigla);
    });
    /*ADMINISTRADOR-INSCRIPCION: EDITAR GRUPO AUXILIATURA*/
    $('.modal-editar-grupo').click(function () {
        let id = $(this).data('id');
        let grupo = $(this).data('grupo');
        let paralelo = $(this).data('paralelo');
        let sigla = $(this).data('sigla')+" (paralelo "+paralelo+")";
        $('#modal-editar-grupo input[name="id"]').val(id);
        $('#modal-editar-grupo input[name="sigla"]').val(sigla);
        $('#modal-editar-grupo input[name="grupo"]').val(grupo);
        $('#modal-editar-grupo input[name="grupo_actual"]').val(grupo);
        $('#modal-editar-grupo #sigla').html(sigla);
        $('#modal-editar-grupo #grupo-actual').html(grupo);
    });
    /*ADMINISTRADOR-INSCRIPCION: ELIMINAR GRUPO AUXILIATURA*/
    $('.modal-eliminar-grupo').click(function () {
        let id = $(this).data('id');
        let grupo = $(this).data('grupo');
        let paralelo = $(this).data('paralelo');
        let sigla = $(this).data('sigla')+" (paralelo "+paralelo+")";
        $('#modal-eliminar-grupo input[name="id"]').val(id);
        $('#modal-eliminar-grupo input[name="sigla"]').val(sigla);
        $('#modal-eliminar-grupo input[name="grupo"]').val(grupo);
        $('#modal-eliminar-grupo #sigla').html(sigla);
        $('#modal-eliminar-grupo #grupo').html(grupo);
    });
    /*ADMINISTRADOR-INSCRIPCION: CREAR CLASE DOCENCIA*/
    $('.modal-crear-clase').click(function () {
        let id = $(this).data('id');
        let paralelo = $(this).data('paralelo');
        let sigla = $(this).data('sigla')+" (paralelo "+paralelo+")";
        $('#modal-crear-clase input[name="id"]').val(id);
        $('#modal-crear-clase strong').html(sigla);
        $('#modal-crear-clase input[name="sigla"]').val(sigla);
    });
    /*ADMINISTRADOR-INSCRIPCION: EDITAR CLASE DOCENCIA*/
    $('.modal-editar-clase').click(function () {
        let id = $(this).data('id');
        let clase = $(this).data('clase');
        let paralelo = $(this).data('paralelo');
        let sigla = $(this).data('sigla')+" (paralelo "+paralelo+")";
        $('#modal-editar-clase input[name="id"]').val(id);
        $('#modal-editar-clase input[name="sigla"]').val(sigla);
        $('#modal-editar-clase input[name="clase"]').val(clase);
        $('#modal-editar-clase input[name="clase_actual"]').val(clase);
        $('#modal-editar-clase #sigla').html(sigla);
        $('#modal-editar-clase #clase-actual').html(clase);
    });
    /*ADMINISTRADOR-INSCRIPCION: ELIMINAR CLASE DOCENCIA*/
    $('.modal-eliminar-clase').click(function () {
        let id = $(this).data('id');
        let clase = $(this).data('clase');
        let paralelo = $(this).data('paralelo');
        let sigla = $(this).data('sigla')+" (paralelo "+paralelo+")";
        $('#modal-eliminar-clase input[name="id"]').val(id);
        $('#modal-eliminar-clase input[name="sigla"]').val(sigla);
        $('#modal-eliminar-clase input[name="clase"]').val(clase);
        $('#modal-eliminar-clase #sigla').html(sigla);
        $('#modal-eliminar-clase #clase').html(clase);
    });
    /*ADMINISTRATIVO-PUBLICACIONES: BUSCAR SEGÚN PARÁMETRO*/
    $('.administrativo-publicaciones #seleccionar-parametro').on('change', function () {
        var valorSeleccionado = $(this).val();
        if (valorSeleccionado === 'numero') {
            $('#valor-parametro').attr('type', 'text');
            $('#valor-parametro').attr('placeholder', 'Ej. 003-2023');
            $('.valor-parametro').text('Número');
        } else if (valorSeleccionado === 'tipo') {
            $('#valor-parametro').attr('type', 'text');
            $('#valor-parametro').attr('placeholder', 'Ej. Pasantía');
            $('.valor-parametro').text('Tipo');
        } else if (valorSeleccionado === 'descripcion') {
            $('#valor-parametro').attr('type', 'text');
            $('#valor-parametro').attr('placeholder', 'Comunicado auxiliares 10');
            $('.valor-parametro').text('Desripción');
        } else if (valorSeleccionado === 'fecha') {
            $('#valor-parametro').attr('type', 'date');
            $('#valor-parametro').removeAttr('placeholder');
            $('.valor-parametro').text('Fecha');
        }
    });
    /*ADMINISTRATIVO-PUBLICACIONES: ACTUALIZAR PUBLICACIÓN*/
    $('.administrativo-publicaciones .switch #otro-archivo').on('change', function () {
        var modal = $(this).data('modal');
        if($(this).prop("checked")) {
            $('.administrativo-publicaciones  '+modal+' .otro-archivo').css('display', 'block');
        } else {
            $('.administrativo-publicaciones  '+modal+' .otro-archivo').css('display', 'none');
        }
    });
    /*AUXILIAR-ANUNCIOS: ACTUALIZAR ANUNCIO*/
    $('.auxiliar-anuncios .switch #otro-archivo').on('change', function () {
        var modal = $(this).data('modal');
        if($(this).prop("checked")) {
            $('.auxiliar-anuncios '+modal+' .otro-archivo').css('display', 'block');
        } else {
            $('.auxiliar-anuncios '+modal+' .otro-archivo').css('display', 'none');
        }
    });
    /*DOCENTE-ANUNCIOS: ACTUALIZAR ANUNCIO*/
    $('.docente-anuncios .switch #otro-archivo').on('change', function () {
        var modal = $(this).data('modal');
        if($(this).prop("checked")) {
            $('.docente-anuncios '+modal+' .otro-archivo').css('display', 'block');
        } else {
            $('.docente-anuncios '+modal+' .otro-archivo').css('display', 'none');
        }
    });
    /*DOCENTE-PONDERACIONES: AGREGAR PONDERACIÓN*/
    $('.docente-ponderaciones .crear-ponderacion, .auxiliar-ponderaciones .crear-ponderacion').on('click', function () {
        var tipo = $(this).data('tipo');
        var tipoEs = $(this).data('tipo_es');
        var id = $(this).data('id');
        $('#modal-crear-ponderacion strong').html(tipoEs);
        $('#modal-crear-ponderacion input[name="tipo"]').val(tipo);
        $('#modal-crear-ponderacion input[name="tipo_es"]').val(tipoEs);
        $('#modal-crear-ponderacion input[name="id"]').val(id);
    });
    /*DOCENTE-PONDERACIONES: ELIMINAR PONDERACIÓN*/
    $('.docente-ponderaciones .eliminar-ponderacion, .auxiliar-ponderaciones .eliminar-ponderacion').on('click', function () {
        var tipo = $(this).data('tipo');
        var tipoEs = $(this).data('tipo_es');
        var id = $(this).data('id');
        var indice = $(this).data('indice');
        var ponderacion = $(this).data('ponderacion');
        $('#modal-eliminar-ponderacion strong').html(tipoEs);
        $('#modal-eliminar-ponderacion input[name="tipo"]').val(tipo);
        $('#modal-eliminar-ponderacion input[name="tipo_es"]').val(tipoEs);
        $('#modal-eliminar-ponderacion input[name="indice"]').val(indice);
        $('#modal-eliminar-ponderacion input[name="id"]').val(id);
        $('#modal-eliminar-ponderacion #indice').html(indice);
        $('#modal-eliminar-ponderacion #ponderacion').html(ponderacion);
    });
    /*ESTUDIANTE-INSCRIPCIONES: ELIMINAR MATERIA INSCRITA*/
    $('.estudiante-inscripciones .eliminar-inscripcion').on('click', function () {
        let sigla = $(this).data('sigla');
        let id = $(this).data('id');
        
        $('#inscripciones-eliminar strong').html(sigla);
        $('#inscripciones-eliminar input[name="id"]').val(id);
    });



});
