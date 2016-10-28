/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Date: 27/10/16
 */

//Funcion para obtener todas las provincias del sistema
function cargarProvincias()
{
    var data = "action=obtenerProvincias";

    $.ajax({
        type: "POST"
        , data: data
        , url: "../../IMVE/Datos/Mantenimientos/ProvinciasCAD.php"
        , success: function(a) {
            $("#cboIdProvincia").html(a);
        }
    })
}