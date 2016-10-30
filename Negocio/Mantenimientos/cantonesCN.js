/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 27/10/16
 */

// Función para obtener todas los cantones del sistema filtrados por el Id de Provincia
function cargarCantones()
{
    var idProvincia = $("#cboIdProvincia").val();

    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerCantones&idProvincia=" + idProvincia;

    // Enviar por Ajax a cantonesCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../IMVE/Datos/Mantenimientos/cantonesCAD.php"
        , success: function(a) {
            $("#cboIdCanton").html(a);
        }
    })
}
