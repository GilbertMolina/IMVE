/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 27/10/16
 */

// Función para obtener todas las provincias del sistema filtradas por el País desde la base de datos
function cargarProvincias()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerProvincias";

    // Enviar por Ajax a provinciasCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../IMVE/Datos/Mantenimientos/provinciasCAD.php"
        , success: function(a) {
            $("#cboIdProvincia").html(a);
        }
    })
}