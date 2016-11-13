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
            $("#cboIdMinisterios").html(a).html(a).trigger("create");
        }
    })
}

// Función para obtener todos los grupos activos y mostralos al usuarios para que seleccione en los cuales es líder
function GruposCargarLideres()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerPersonasLideresListado";

    // Enviar por Ajax a gruposCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Procesos/personasCAD.php"
        , success: function(a) {
            $("#GrupoPersonasLideres").html(a).selectmenu('refresh');
        }
    })
}

// Función para obtener todos los grupos activos y mostralos al usuarios para que seleccione en los cuales es participante
function GruposCargarParticipantes()
{
// Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerPersonasParticipantesListado";

    // Enviar por Ajax a gruposCAD.php
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
            , content: 'Debe de seleccionar la categoría grupo y digitar la descripción.'
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
        var d = "action=modificarGrupo&idGrupo=" + idGrupo + "&idCategoriaGrupo=" + idCategoriaGrupo + "&idMinisterio=" + idMinisterio + "&descripcion=" + descripcion + "&estado=" + estado;

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