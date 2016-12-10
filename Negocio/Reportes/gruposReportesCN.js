/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 17/11/16
 */

// Función que se ejecuta al cargar la pagina de reportes de grupos
function GruposReportesOnLoad() {
    GruposReportesCargarTiposCompromisos();
    GruposReportesCargarMinisterios();
}

// Función que carga los tipos de compromiso
function GruposReportesCargarMinisterios(){
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoMinisteriosUtilizadosCombobox";

    // Enviar por Ajax a compromisosCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Procesos/compromisosCAD.php"
        , success: function(a) {
            $("#cboIdMinisteriosGruposReporte1").html(a).trigger("create");
        }
    })
}

// Función que carga los ministerios
function GruposReportesCargarTiposCompromisos() {
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoTiposCompromisosUtilizadosCombobox";

    // Enviar por Ajax a compromisosCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Procesos/compromisosCAD.php"
        , success: function(a) {
            $("#cboIdTiposCompromisosGruposReporte1").html(a).trigger("create");
        }
    })
}

// Función que genera el reporte de actividades de los grupos
function GruposReportesGenerarReporte1OnClick(){
    var fechaInicio = $('#txtFechaInicioGruposReporte1').val();
    var fechaFin = $('#txtFechaFinGruposReporte1').val();
    var idTipoCompromiso = $('#cboIdTiposCompromisosGruposReporte1').val();
    var idMinisterio     = $('#cboIdMinisteriosGruposReporte1').val();
    var fechaFinParaEnviar = '';

    if (fechaFin == "")
    {
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth() + 1;
        var a = date.getFullYear();
        var fechaHoy = a + '-' + m + '-' + d + 'T23:59';

        fechaFinParaEnviar = fechaHoy;
    }
    else
    {
        fechaFinParaEnviar = fechaFin;
    }

    if(fechaInicio == "")
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Advertencia'
            , content: 'Debe de ingresar la fecha y hora de inicio.'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });

        return false;
    }

    var url = '../../Datos/Reportes/gruposCAD.php?reporte=1&fechaInicio=' + fechaInicio + '&fechaFin=' + fechaFinParaEnviar + '&tipoCompromiso=' + idTipoCompromiso + '&ministerio=' + idMinisterio;
    
    // Se redirecciona a la pagina que mostrará el reporte
    RedireccionPaginaNuevaVentana(url);
};

// Función que genera el reporte de integrantes por grupo
function GruposReportesGenerarReporte2OnClick(){
    var url = '../../Datos/Reportes/gruposCAD.php?reporte=2';

    // Se redirecciona a la pagina que mostrará el reporte
    RedireccionPaginaNuevaVentana(url);
};

// Función que genera el reporte de integrantes por grupo histórico
function GruposReportesGenerarReporte3OnClick(){
    var url = '../../Datos/Reportes/gruposCAD.php?reporte=3';

    // Se redirecciona a la pagina que mostrará el reporte
    RedireccionPaginaNuevaVentana(url);
};

