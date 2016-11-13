/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 11/11/16
 */

// Variable que se utiliza para mostrar u ocultar las acciones masivas de los grupos
var mostrarAccionesGrupos = false;

// Función que se ejecuta al cargar la pagina de grupos
function GruposOnLoad() {
    GruposCargarGruposListado();
    GruposCargarPersonasGrupoAccionesSeleccion();

    $('#menuAccionesGrupos').hide();

    $('#btnGruposEnviarSMS').hide();
    $('#btnGruposEnviarCorreo').hide();
}

// Función que se ejecuta al cargar la pagina de grupos detalle
function GruposDetalleOnLoad() {
    GruposCargarGrupoPorId();
    GruposCambiarBarraNavegacionFooter();
}

// Función que cambia la barra navegación del footer dependiendo de la pantalla de donde se ejecute
function GruposCambiarBarraNavegacionFooter() {
    var IdGrupo = ObtenerParametroPorNombre('IdGrupo');

    if(IdGrupo != ''){
        $('#NuevoGrupo').hide();
    }
    else{
        $('#DetalleGrupo').hide();
    }
}

// Función para obtener todos los grupos registradas
function GruposCargarGruposListado() {
    var estado = ObtenerValorRadioButtonPorNombre('estadoGrupo');

    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoGruposPorEstado&estado=" + estado;

    // Enviar por Ajax a gruposCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Procesos/gruposCAD.php"
        , success: function(a) {
            $("#divListaGrupos").html(a).trigger("create");
        }
    })
}

// Función para obtener todas las categorías de grupos activas
function GruposCargarCategoriasGruposComboBox()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoCategoriasGruposActivasCombobox";

    // Enviar por Ajax a gruposCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Mantenimientos/categoriasGruposCAD.php"
        , success: function(a) {
            $("#cboIdCategoriasGrupos").html(a).html(a).trigger("create");
        }
    })
}

// Función para obtener todos los ministerios activos
function GruposCargarMinisteriosComboBox()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoMinisteriosActivosCombobox";

    // Enviar por Ajax a ministeriosCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Mantenimientos/ministeriosCAD.php"
        , success: function(a) {
            $("#cboIdMinisterios").html(a).trigger("create");
        }
    })
}

// Función para obtener todas las personas y mostralos al usuarios para que seleccione en los cuales son líderes
function GruposCargarLideres()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerPersonasLideresListado";

    // Enviar por Ajax a personasCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Procesos/personasCAD.php"
        , success: function(a) {
            $("#GrupoPersonasLideres").html(a).selectmenu('refresh');
        }
    })
}

// Función para obtener todas las personas y mostralos al usuarios para que seleccione en los cuales son participantes
function GruposCargarParticipantes()
{
// Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerPersonasParticipantesListado";

    // Enviar por Ajax a personasCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Procesos/personasCAD.php"
        , success: function(a) {
            $("#GrupoPersonasParticipantes").html(a).selectmenu('refresh');
        }
    })
}

// Función que muestra o oculta las accciones masivas de los grupos
function GruposMostrarAccionesMasivas(){
    if (mostrarAccionesGrupos == false)
    {
        mostrarAccionesGrupos = true;
        $("#menuAccionesGrupos").show();
    }
    else if (mostrarAccionesGrupos == true)
    {
        mostrarAccionesGrupos = false;
        $("#menuAccionesGrupos").hide();
    }
}

// Función para cargar un grupo por su id
function GruposCargarGrupoPorId() {
    var IdGrupo = ObtenerParametroPorNombre('IdGrupo');

    if(IdGrupo != ''){

        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=cargarGrupo&IdGrupo=" + IdGrupo;

        // Enviar por Ajax a usuariosCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Procesos/gruposCAD.php"
            , success: function(a) {
                $("#gruposDetalle").html(a).trigger("create");
            }
        });
    }
    else
    {
        GruposCargarCategoriasGruposComboBox();
        GruposCargarMinisteriosComboBox();
        GruposCargarLideres();
        GruposCargarParticipantes();
    }
}

// Función para obtener todos las personas con sus celulares y correos
function GruposCargarPersonasGrupoAccionesSeleccion() {
    var contacto = ObtenerValorRadioButtonPorNombre('filtroGruposContacto');
    var tipoIntegrante = ObtenerValorRadioButtonPorNombre('filtroGruposTipoIntegrante');
    var inicioHref = (contacto == "S") ? "sms:" : "mailto:";

    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoGruposPersonasEsLider&contacto=" + contacto + "&tipoIntegrante=" + tipoIntegrante;
    
    // Enviar por Ajax a gruposCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Procesos/gruposCAD.php"
        , success: function(a) {
            $("#GruposAccionesSeleccion").html(a).trigger("create");
        }
    });
    
    $('#btnGruposEnviarSMS').hide();
    $('#btnGruposEnviarSMS').attr("href", inicioHref);
    $('#btnGruposEnviarCorreo').hide();
    $('#btnGruposEnviarCorreo').attr("href", inicioHref);
}

// Función para el evento clic del botón btnGruposEnviarSMS
function GruposBtnEnviarSMS() {
    var valorHref = $('#btnGruposEnviarSMS').attr("href");

    if(valorHref == 'sms:'){
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Advertencia'
            , content: 'No ha seleccionado ninguna persona para enviarle un mensaje de texto.'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });

        return false;
    }
    else{
        return true;
    }
}

// Función para el evento clic del botón btnGruposEnviarCorreo
function GruposBtnEnviarCorreo() {
    var valorHref = $('#btnGruposEnviarCorreo').attr("href");

    if(valorHref == 'mailto:'){
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Advertencia'
            , content: 'No ha seleccionado ninguna persona para enviarle un correo electrónico.'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });

        return false;
    }
    else{
        return true;
    }
}

// Función para enviar un sms o un correo a las personas seleccionadas
function GruposAccionesSeleccionarIntegrantes() {
    var accion = ObtenerValorRadioButtonPorNombre('filtroGruposContacto');
    var arregloSeleccionMasiva = $('#accionesSeleccionGrupos').val();
    var inicioHref = (accion == "S") ? "sms:" : "mailto:";

    if(arregloSeleccionMasiva != null){
        var nuevoSeleccion = arregloSeleccionMasiva.toString().replace(",",";");
        var valorCompletoHref = inicioHref + nuevoSeleccion.replace(",",";");

        if(accion == 'S')
        {
            $('#btnGruposEnviarSMS').show();
            $('#btnGruposEnviarSMS').attr("href", valorCompletoHref);
        }
        else
        {
            $('#btnGruposEnviarCorreo').show();
            $('#btnGruposEnviarCorreo').attr("href", valorCompletoHref);
        }
    }
    else{
        if(accion == 'S')
        {
            $('#btnGruposEnviarSMS').hide();
            $('#btnGruposEnviarSMS').attr("href", inicioHref);
        }
        else
        {
            $('#btnGruposEnviarCorreo').hide();
            $('#btnGruposEnviarCorreo').attr("href", inicioHref);
        }
    }
}

// Función para registrar un grupo
function GruposRegistrarGrupo() {
    var idCategoriaGrupo = $('#cboIdCategoriasGrupos').val();
    var idMinisterio     = $('#cboIdMinisterios').val();
    var descripcion      = $('#txtDescripcionGrupo').val();

    var personasLideres = $('#GrupoPersonasLideres').val();
    var listaPersonasLideresJson = JSON.stringify(personasLideres);

    var personasParticipantes = $('#GrupoPersonasParticipantes').val();
    var listaPersonasParticipantesJson = JSON.stringify(personasParticipantes);

    if(idCategoriaGrupo == 0
        && descripcion == "")
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Advertencia'
            , content: 'Debe de seleccionar la categoría de grupo y digitar la descripción.'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });
    }
    else
    {
        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=registrarGrupo&idCategoriaGrupo=" + idCategoriaGrupo + "&idMinisterio=" + idMinisterio + "&descripcion=" + descripcion + "&listaPersonasLideres=" + listaPersonasLideresJson + "&listaPersonasParticipantes=" + listaPersonasParticipantesJson;

        // Enviar por Ajax a gruposCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Procesos/gruposCAD.php"
            , success: function(a)
            {
                // Se divide la variable separandola por comas.
                var resultado = a.split(',');

                if(resultado[0] == 1)
                {
                    $.alert({
                        theme: 'material'
                        , animationBounce: 1.5
                        , animation: 'rotate'
                        , closeAnimation: 'rotate'
                        , title: 'Información'
                        , content: 'El grupo se agregó satisfactoriamente.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-success'
                        , confirm: function(){
                            RedireccionPagina('grupos.php');
                        }
                    });
                }
                else if(resultado[0].includes("Duplicate"))
                {
                    $.alert({
                        theme: 'material'
                        , animationBounce: 1.5
                        , animation: 'rotate'
                        , closeAnimation: 'rotate'
                        , title: 'Advertencia'
                        , content: 'El grupo ya se encuentra registrado.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-warning'
                    });
                }
                else
                {
                    $.alert({
                        theme: 'material'
                        , animationBounce: 1.5
                        , animation: 'rotate'
                        , closeAnimation: 'rotate'
                        , title: 'Error'
                        , content: 'No se pudo agregar el grupo, intente de nuevo.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-danger'
                    });
                }
            }
        });
    };
}

// Función para modificar un grupo
function GruposModificarGrupo(p_IdGrupo) {
    var idGrupo             = p_IdGrupo;
    var idCategoriaGrupo    = $('#cboIdCategoriasGrupos').val();
    var idMinisterio        = $('#cboIdMinisterios').val();
    var descripcion         = $('#txtDescripcionGrupo').val();
    var estado              = $('#cboEstadoGrupo').val();

    // Se obtiene la lista inicial de las personas que son lideres y/o participantes
    var listadoInicialGruposPersonaLider        = $('#hdfGruposPersonaLider').val();
    var listadoInicialGruposPersonaParticipante = $('#hdfGruposPersonaParticipante').val();

    // Se obtiene la lista actual de las personas que son lideres y/o participantes
    var personasLider = $('#GrupoPersonasLideres').val();
    var personasParticipante = $('#GrupoPersonasParticipantes').val();

    // Variables para obtener la lista de las personas lideres y/o participantes en los cuales se acaba de integrar la persona
    var listaPersonasLideresAgregado = [];
    var listaPersonasParticipantesAgregado = [];

    // Variables para obtener la lista de las personas lideres y/o participantes en los cuales ya no participa
    var listaPersonasLideresEliminados = [];
    var listaPersonasParticipantesEliminados = [];

    if(personasLider != null){
        // Se pregunta si la lista inicial tiene algun registro
        if(listadoInicialGruposPersonaLider.length > 0){
            // Se obtienen las personas que eran lideres
            for(var i = 0; i < listadoInicialGruposPersonaLider.length; i++){
                var busquedaEnArregloLideresEliminados = jQuery.inArray(listadoInicialGruposPersonaLider[i],personasLider);
                if(busquedaEnArregloLideresEliminados == -1){
                    listaPersonasLideresEliminados.push(listadoInicialGruposPersonaLider[i]);
                }
            }

            // Se obtienen las personas que ahora son lideres
            for(var i = 0; i < personasLider.length; i++){
                var busquedaEnArregloLideresAgregados = jQuery.inArray(personasLider[i],listadoInicialGruposPersonaLider);
                if(busquedaEnArregloLideresAgregados == -1){
                    listaPersonasLideresAgregado.push(personasLider[i]);
                }
            }
        }
        else
        {
            // Se obtienen las personas que ahora son lideres
            for(var i = 0; i < personasLider.length; i++){
                listaPersonasLideresAgregado.push(personasLider[i]);
            }
        }
    }

    // Si la lista de lideres actual es nula y la lista inicial de lideres no esta vacia quiere decir que todos los que habian en la lista inicial, fueron eliminados
    if(personasLider == null
        && listadoInicialGruposPersonaLider.length > 0){
        // Se obtienen las personas que eran lideres
        for(var i = 0; i < listadoInicialGruposPersonaLider.length; i++){
            listaPersonasLideresEliminados.push(listadoInicialGruposPersonaLider[i]);
        }
    }

    if(personasParticipante != null){
        // Se pregunta si la lista inicial tiene algun registro
        if(listadoInicialGruposPersonaParticipante.length > 0){
            // Se obtienen las personas que eran participantes
            for(var i = 0; i < listadoInicialGruposPersonaParticipante.length; i++){
                var busquedaEnArregloParticipantesEliminados = jQuery.inArray(listadoInicialGruposPersonaParticipante[i],personasParticipante);
                if(busquedaEnArregloParticipantesEliminados == -1){
                    listaPersonasParticipantesEliminados.push(listadoInicialGruposPersonaParticipante[i]);
                }
            }

            // Se obtienen las personas que ahora son participantes
            for(var i = 0; i < personasParticipante.length; i++){
                var busquedaEnArregloParticipantesAgregadoss = jQuery.inArray(personasParticipante[i],listadoInicialGruposPersonaParticipante);
                if(busquedaEnArregloParticipantesAgregadoss == -1){
                    listaPersonasParticipantesAgregado.push(personasParticipante[i]);
                }
            }
        }
        else
        {
            // Se obtienen las personas que ahora son participantes
            for(var i = 0; i < personasParticipante.length; i++){
                listaPersonasParticipantesAgregado.push(personasParticipante[i]);
            }
        }
    }

    // Si la lista de participantes actual es nula y la lista inicial de participantes no esta vacia quiere decir que todos los que habian en la lista inicial, fueron eliminados
    if(personasParticipante == null
        && listadoInicialGruposPersonaParticipante.length > 0){
        // Se obtienen las personas que eran participantes
        for(var i = 0; i < listadoInicialGruposPersonaParticipante.length; i++){
            listaPersonasParticipantesEliminados.push(listadoInicialGruposPersonaParticipante[i]);
        }
    }

    // Se convierten a formato JSON las listas
    var listaPersonasLideresAgregadoJson = JSON.stringify(listaPersonasLideresAgregado);
    var listaPersonasLideresEliminadosJson = JSON.stringify(listaPersonasLideresEliminados);
    var listaPersonasParticipantesAgregadoJson = JSON.stringify(listaPersonasParticipantesAgregado);
    var listaPersonasParticipantesEliminadosJson = JSON.stringify(listaPersonasParticipantesEliminados);

    if(idCategoriaGrupo == 0
        || descripcion == ""
        || estado == "0")
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Advertencia'
            , content: 'Debe de seleccionar la categoría de grupo, digitar la descripción, y seleccionar el estado.'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });
    }
    else
    {
        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=modificarGrupo&idGrupo=" + idGrupo + "&idCategoriaGrupo=" + idCategoriaGrupo + "&idMinisterio=" + idMinisterio + "&descripcion=" + descripcion + "&estado=" + estado
            + "&listaPersonasLideresAgregado=" + listaPersonasLideresAgregadoJson + "&listaPersonasLideresEliminados=" + listaPersonasLideresEliminadosJson
            + "&listaPersonasParticipantesAgregado=" + listaPersonasParticipantesAgregadoJson + "&listaPersonasParticipantesEliminados=" + listaPersonasParticipantesEliminadosJson;

        // Enviar por Ajax a gruposCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Procesos/gruposCAD.php"
            , success: function(a)
            {
                // Se obtiene el resultado.
                if (a == 1)
                {
                    $.alert({
                        theme: 'material'
                        , animationBounce: 1.5
                        , animation: 'rotate'
                        , closeAnimation: 'rotate'
                        , title: 'Información'
                        , content: 'El grupo se modificó satisfactoriamente.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-success'
                        , confirm: function(){
                            RedireccionPagina('grupos.php');
                        }
                    });
                }
                else
                {
                    $.alert({
                        theme: 'material'
                        , animationBounce: 1.5
                        , animation: 'rotate'
                        , closeAnimation: 'rotate'
                        , title: 'Error'
                        , content: 'No se pudo modificar el grupo, intente de nuevo.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-danger'
                    });
                }
            }
        });
    };
}