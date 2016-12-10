/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 17/11/16
 */

// Función que genera el reporte de compromisos por grupo
function CompromisosReportesGenerarOnClick(){
    var tipoCompromisoReporteResposable = ObtenerValorRadioButtonPorNombre('tipoCompromisoReporteResponsable');
    var fechaInicio = $('#txtFechaInicioCompromisosReporte').val();
    var fechaFin = $('#txtFechaFinCompromisosReporte').val();
    var fechaFinParaEnviar = '';

    if (fechaFin == "")
    {
        var date = new Date();
        var d = (date.getDate().toString().length == 1) ? '0' + date.getDate() : date.getDate();
        var m = ((date.getMonth() + 1).toString().length == 1) ? '0' + date.getMonth() + 1: date.getMonth() + 1;
        // var m = date.getMonth() + 1;
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

    var url = '../../Datos/Reportes/compromisosCAD.php?fechaInicio=' + fechaInicio + '&fechaFin=' + fechaFinParaEnviar + '&tipoResponsable=' + tipoCompromisoReporteResposable;

    // Se redirecciona a la pagina que mostrará el reporte
    RedireccionPaginaNuevaVentana(url);
};