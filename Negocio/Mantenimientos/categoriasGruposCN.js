/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 03/11/16
 */

// Función que se ejecuta al cargar la pagina de categorias
function CategoriasGruposOnLoad(){
    CategoriasGruposCargarCategoriasGruposActivasListado();
}

// Función para obtener todas las categorias grupos activas
function CategoriasGruposCargarCategoriasGruposActivasListado()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoCategoriasGruposActivas";

    // Enviar por Ajax a categoriasGruposCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Mantenimientos/categoriasGruposCAD.php"
        , success: function(a) {
            $("#listaCategoriasGrupos").html(a).listview("refresh");
        }
    })
}
