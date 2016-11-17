/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 17/11/16
 */

// Función que se ejecuta al cargar la pagina de compromisos
function CompromisosReportesOnLoad() {

}

// Función que registra el usuario del usuario a la base de datos por medio de Ajax
function CompromisosReportesGenerarOnClick(){
    var tipoCompromisoReporteResposable = ObtenerValorRadioButtonPorNombre('tipoCompromisoReporteResponsable');
    var fechaInicio = $('#txtFechaInicioCompromisosReporte').val();
    var fechaFin = $('#txtFechaFinCompromisosReporte').val();
    var fechaFinParaEnviar = '';

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

    if(tipoCompromisoReporteResposable == 'P'){
        var url = '../../Datos/Reportes/compromisosCAD.php?fechaInicio=' + fechaInicio + '&fechaFin=' + fechaFinParaEnviar + '&tipoResponsable=P';
    }
    else if(tipoCompromisoReporteResposable == 'G'){
        var url = '../../Datos/Reportes/compromisosCAD.php?fechaInicio=' + fechaInicio + '&fechaFin=' + fechaFinParaEnviar + '&tipoResponsable=G';
    }
    else{
        var url = '../../Datos/Reportes/compromisosCAD.php?fechaInicio=' + fechaInicio + '&fechaFin=' + fechaFinParaEnviar + '&tipoResponsable=T';
    }

    // Se redirecciona a la pagina que mostrará el reporte
    RedireccionPaginaNuevaVentana(url);
};