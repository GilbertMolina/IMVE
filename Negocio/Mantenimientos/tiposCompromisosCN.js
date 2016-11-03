/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 03/11/16
 */

// Función que se ejecuta al cargar la pagina de categorias
function TiposCompromisosOnLoad(){
    TiposCompromisosCargarTiposCompromisosActivosListado();
}

// Función para obtener todos los tipos de compromisos activos
function TiposCompromisosCargarTiposCompromisosActivosListado()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoTiposCompromisosActivos";

    // Enviar por Ajax a tiposCompromisosCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Mantenimientos/tiposCompromisosCAD.php"
        , success: function(a) {
            $("#listaTiposCompromisos").html(a).listview("refresh");
        }
    })
}
