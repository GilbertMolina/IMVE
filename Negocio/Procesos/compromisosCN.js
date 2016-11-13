/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 13/11/16
 */

// Función que se ejecuta al cargar la pagina de compromisos
function CompromisosOnLoad() {

}

// Función que se ejecuta al cargar la pagina de compromisos detalle
function CompromisosDetalleOnLoad() {
    CompromisosCambiarBarraNavegacionFooter();
    CompromisosCambiarTipoReponsable();
    CompromisosCargarCompromisoPorId();
}

// Función que cambia la barra navegación del footer dependiendo de la pantalla de donde se ejecute
function CompromisosCambiarBarraNavegacionFooter() {
    var IdGrupo = ObtenerParametroPorNombre('IdGrupo');

    if(IdGrupo != ''){
        $('#DesdeListaCompromisos').hide();
    }
    else{
        $('#DesdeGrupos').hide();
    }
}

// Función para cargar un compromiso por su id
function CompromisosCargarCompromisoPorId() {
    var IdCompromiso = ObtenerParametroPorNombre('IdCompromiso');

    if(IdCompromiso != ''){

        // // Se define el action que será consultado desde la clase de acceso a datos
        // var d = "action=cargarGrupo&IdGrupo=" + IdGrupo;
        //
        // // Enviar por Ajax a usuariosCAD.php
        // $.ajax({
        //     type: "POST"
        //     , data: d
        //     , url: "../../../IMVE/Datos/Procesos/gruposCAD.php"
        //     , success: function(a) {
        //         $("#gruposDetalle").html(a).trigger("create");
        //     }
        // });
    }
    else
    {
        CompromisosAsignarFechaInicioFinal();
        CompromisosCargarMinisteriosComboBox();
        CompromisosCargarTiposCompromisosComboBox();
        CompromisosCargarPersonasResponsables();
        CompromisosCargarGruposResponsables();
        CompromisosCargarPersonasParticipantes();
    }
}

// Función para cambiar el tipo de responsable del compromiso
function CompromisosCambiarTipoReponsable(){
    var tipoResposable = ObtenerValorRadioButtonPorNombre('tipoResponsable');
    
    if(tipoResposable == 'P'){
        $('#divCompromisosPersonasResponsables').show();
        $('#divCompromisosGruposResponsables').hide();
    }
    else{
        $('#divCompromisosPersonasResponsables').hide();
        $('#divCompromisosGruposResponsables').show();
    }

    // Al cambiar el tipo de integrante se vuelven a cargar los select de personas y grupos responsables para limpiar los valores selecccionados
    CompromisosCargarPersonasResponsables();
    CompromisosCargarGruposResponsables();
}

// Función que carga la fecha actual en el campo de fecha de inicio y fecha final
function CompromisosAsignarFechaInicioFinal()
{
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth() + 1;
    var a = date.getFullYear();
    var h = date.getHours();
    var mi = date.getMinutes();
    var fechaCompleta = d + '/' + m + '/' + a + 'T' + h + mi;

    document.getElementById("txtFechaInicio").defaultValue = fechaCompleta;
    document.getElementById("txtFechaFinal").defaultValue = fechaCompleta;
}

// Función para obtener todos los ministerios activos
function CompromisosCargarMinisteriosComboBox()
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

// Función para obtener todos los tipos compromisos activos
function CompromisosCargarTiposCompromisosComboBox()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoTiposCompromisosActivosCombobox";

    // Enviar por Ajax a tiposCompromisosCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Mantenimientos/tiposCompromisosCAD.php"
        , success: function(a) {
            $("#cboIdTiposCompromisos").html(a).trigger("create");
        }
    })
}

// Función para obtener todas las personas activos y mostrarlas al usuarios para que seleccione cual de ellas son responsables
function CompromisosCargarPersonasResponsables()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerPersonasLideresListado";

    // Limpiar el valor del select cuando se hace el cambio del tipo de integrante
    $("#CompromisosPersonasResponsables").html("<option>Seleccione</option>").selectmenu('refresh');

    // Enviar por Ajax a gruposCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Procesos/personasCAD.php"
        , success: function(a) {
            $("#CompromisosPersonasResponsables").html(a).selectmenu('refresh');
        }
    })
}

// Función para obtener todos los grupos activos y mostrarlos al usuarios para que seleccione cual de ellos son responsables
function CompromisosCargarGruposResponsables()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerGruposParticipantesListado";

    // Limpiar el valor del select cuando se hace el cambio del tipo de integrante
    $("#CompromisosGruposResponsables").html("<option>Seleccione</option>").selectmenu('refresh');

    // Enviar por Ajax a gruposCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Procesos/gruposCAD.php"
        , success: function(a) {
            $("#CompromisosGruposResponsables").html(a).selectmenu('refresh');
        }
    })
}

// Función para obtener todas las personas activos y mostrarlas al usuarios para que seleccione cual de ellas son participantes
function CompromisosCargarPersonasParticipantes()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerPersonasLideresListado";

    // Enviar por Ajax a gruposCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Procesos/personasCAD.php"
        , success: function(a) {
            $("#CompromisosPersonasParticipantes").html(a).selectmenu('refresh');
        }
    })
}