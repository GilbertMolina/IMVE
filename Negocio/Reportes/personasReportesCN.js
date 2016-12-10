/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 16/11/16
 */

// Función que genera el reporte de visitas por persona
function PersonasReportesGenerarOnClick(){
    var fechaInicio = $('#txtFechaInicioPersonasReporte').val();
    var fechaFin = $('#txtFechaFinPersonasReporte').val();
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

    var url = '../../Datos/Reportes/personasCAD.php?fechaInicio=' + fechaInicio + '&fechaFin=' + fechaFinParaEnviar;

    // Se redirecciona a la pagina que mostrará el reporte
    RedireccionPaginaNuevaVentana(url);
};