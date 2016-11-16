/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 16/11/16
 */

// Función que registra el usuario del usuario a la base de datos por medio de Ajax
function PersonasReportesGenerarOnClick(){
    var fechaInicio = '';
    var fechaFin = '';
    var fechaFinParaEnviar = '';

    fechaInicio = $('#txtFechaInicioPersonasReporte').val();
    fechaFin = $('#txtFechaFinPersonasReporte').val();

    if (fechaFin == "")
    {
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth() + 1;
        var a = date.getFullYear();
        var fechaHoy = a + '-' + m + '-' + d;

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
            , content: 'Debe de ingresar la fecha de inicio.'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });

        return false;
    }

    var url = '../../Datos/Reportes/personasCAD.php?fechaInicio=' + fechaInicio + '&fechaFin=' + fechaFinParaEnviar;

    // Se redirecciona a la pagina que mostrará el reporte
    RedireccionPaginaNuevaVentana(url);
    
};