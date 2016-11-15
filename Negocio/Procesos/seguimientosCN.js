/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 13/11/16
 */

// Función que se ejecuta al cargar la pagina de seguimientos
function SeguimientosOnLoad() {
    SeguimientosCargarSeguimientosListado();
}

// Función que se ejecuta al cargar la pagina de seguimientos detalle
function SeguimientosDetalleOnLoad() {
    SeguimientosCargarTiposSeguimientosComboBox();
    SeguimientosAsignarFechaPropuesta();
    GruposCambiarBarraNavegacionFooter();
}

// Función que cambia la barra navegación del footer dependiendo de la pantalla de donde se ejecute
function GruposCambiarBarraNavegacionFooter() {
    var IdVisita = ObtenerParametroPorNombre('IdVisita');

    if(IdVisita != ''){
        $('#NuevoSeguimiento').hide();
    }
    else{
        $('#DetalleSeguimiento').hide();
    }
}

// Función que carga la fecha actual mas 7 días del seguimiento en el campo de fecha propuesta
function SeguimientosAsignarFechaPropuesta(){
    var fechaPropuesta = SumarRestaFecha(7);
    $("#txtFechaPropuesta").attr("value", fechaPropuesta);
}

// Función para obtener todos los seguimientos activos o inactivos para la visita seleccionada
function SeguimientosCargarSeguimientosListado() {
    var IdVisita = ObtenerParametroPorNombre('IdVisita');
    var estado   = ObtenerValorRadioButtonPorNombre('estadoSeguimientos');

    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoSeguimientosPorVisitaEstado&IdVisita=" + IdVisita + "&estado=" + estado;

    // Enviar por Ajax a seguimientosCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Procesos/seguimientosCAD.php"
        , success: function(a) {
            $("#listaSeguimientos").html(a).listview("refresh");
        }
    })
}

// Función para obtener todos los ministerios activos
function SeguimientosCargarTiposSeguimientosComboBox()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoTiposSeguimientosActivosCombobox";

    // Enviar por Ajax a tiposSeguimientosCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Mantenimientos/tiposSeguimientosCAD.php"
        , success: function(a) {
            $("#cboIdTipoSeguimiento").html(a).trigger("create");
        }
    })
}