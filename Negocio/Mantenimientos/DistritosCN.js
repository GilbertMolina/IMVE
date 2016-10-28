/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Date: 27/10/16
 */

//Funcion para obtener todas los distritos del sistema
function cargarDistritos()
{
    var idProvincia = $("#cboIdProvincia").val();
    var idCanton = $("#cboIdCanton").val();

    var data = "action=obtenerDistritos&idProvincia=" + idProvincia + "&idCanton=" + idCanton;

    $.ajax({
        type: "POST"
        , data: data
        , url: "../../IMVE/Datos/Mantenimientos/DistritosCAD.php"
        , success: function(a) {
            $("#cboIdDistrito").html(a);
        }
    })
}
