/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Date: 27/10/16
 */

//Funcion para obtener todas los cantones del sistema
function cargarCantones()
{
    var idProvincia = $("#cboIdProvincia").val();

    var data = "action=obtenerCantones&idProvincia=" + idProvincia;

    $.ajax({
        type: "POST"
        , data: data
        , url: "../../IMVE/Datos/Mantenimientos/CantonesCAD.php"
        , success: function(a) {
            $("#cboIdCanton").html(a);
        }
    })
}