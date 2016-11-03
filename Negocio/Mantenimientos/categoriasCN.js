/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 03/11/16
 */

// Función que se ejecuta al cargar la pagina de categorias
function CategoriasOnLoad(){
    CategoriasCargarCategoriasActivasListado();
}

// Función para obtener todas las categorias activas
function CategoriasCargarCategoriasActivasListado()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoCategoriasActivas";

    // Enviar por Ajax a categoriasCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Mantenimientos/categoriasCAD.php"
        , success: function(a) {
            $("#listaCategorias").html(a).listview("refresh");
        }
    })
}
