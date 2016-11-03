/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 03/11/16
 */

// Función que se ejecuta al cargar la pagina de categorias
function TiposRelacionesOnLoad(){
    TiposRelacionesCargarTiposRelacionesListado();
}

// Función para obtener todos los tipos de relaciones
function TiposRelacionesCargarTiposRelacionesListado()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoRelaciones";

    // Enviar por Ajax a tiposRelacionesCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Mantenimientos/tiposRelacionesCAD.php"
        , success: function(a) {
            $("#listaTiposRelaciones").html(a).listview("refresh");
        }
    })
}
