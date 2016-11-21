/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 20/11/16
 */

// Función que se ejecuta al cargar la pagina de bienvenida
function BienvenidaOnLoad(){
    BienvenidaCargaCompromisosPendientes();
    BienvenidaCargaCompromisosDeHoy();
    BienvenidaCargaSeguimientosDeHoy();
    BienvenidaCargaSeguimientosPendientes();
}

// Función para obtener el listado de los compromisos de hoy
function BienvenidaCargaCompromisosDeHoy() {
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoCompromisosDeHoy";

    // Enviar por Ajax a compromisosCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Procesos/compromisosCAD.php"
        , success: function(a) {
            $("#compromisosDeHoy").html(a).trigger("create");
        }
    })
}

// Función para obtener el listado de los últimos tres compromisos pendientes
function BienvenidaCargaCompromisosPendientes() {
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoCompromisosPendientes";

    // Enviar por Ajax a compromisosCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Procesos/compromisosCAD.php"
        , success: function(a) {
            $("#compromisosPendientes").html(a).trigger("create");
        }
    })
}

// Función para obtener el listado de los seguimientos de hoy
function BienvenidaCargaSeguimientosDeHoy() {
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoSeguimientosDeHoy";

    // Enviar por Ajax a seguimientosCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Procesos/seguimientosCAD.php"
        , success: function(a) {
            $("#seguimientosDeHoy").html(a).trigger("create");
        }
    })
}

// Función para obtener el listado de los últimos tres seguimientos pendientes
function BienvenidaCargaSeguimientosPendientes() {
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoSeguimientosPendientes";

    // Enviar por Ajax a seguimientosCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Procesos/seguimientosCAD.php"
        , success: function(a) {
            $("#seguimientosPendientes").html(a).trigger("create");
        }
    })
}

// Función para cerrar el seguimiento
function BienvenidaCerrarSeguimiento(p_IdSeguimiento) {
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=cerrarSeguimiento&idSeguimiento=" + p_IdSeguimiento;

    // Enviar por Ajax a seguimientosCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Procesos/seguimientosCAD.php"
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
                    , content: 'El seguimiento se cerró satisfactoriamente.'
                    , confirmButton: 'Aceptar'
                    , confirmButtonClass: 'btn-success'
                    , confirm: function(){
                        RedireccionPagina('bienvenida.php');
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
                    , content: 'No se pudo cerrar el seguimiento, intente de nuevo.'
                    , confirmButton: 'Aceptar'
                    , confirmButtonClass: 'btn-danger'
                });
            }
        }
    });
}