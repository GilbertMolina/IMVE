/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 03/11/16
 */

// Función que se ejecuta al cargar la pagina de categorias
function TiposSeguimientosOnLoad(){
    TiposSeguimientosCargarTiposSeguimientosActivosListado();
}

// Función para obtener todos los tipos de seguimientos activos
function TiposSeguimientosCargarTiposSeguimientosActivosListado()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoTiposSeguimientosActivos";

    // Enviar por Ajax a tiposSeguimientosCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Mantenimientos/tiposSeguimientosCAD.php"
        , success: function(a) {
            $("#listaTiposSeguimientos").html(a).listview("refresh");
        }
    })
}
