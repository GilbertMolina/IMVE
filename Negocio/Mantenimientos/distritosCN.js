/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 27/10/16
 */

// Función para obtener todas los distritos del sistema filtrados por el Id de Provincia y el Id de Cantón
function CargarDistritos()
{
    var idProvincia = $("#cboIdProvincia").val();
    var idCanton = $("#cboIdCanton").val();

    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerDistritos&idProvincia=" + idProvincia + "&idCanton=" + idCanton;

    // Enviar por Ajax a distritosCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Mantenimientos/distritosCAD.php"
        , success: function(a) {
            $("#cboIdDistrito").html(a);
        }
    })
}
