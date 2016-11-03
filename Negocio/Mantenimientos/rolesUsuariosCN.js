/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 03/11/16
 */

// Función que se ejecuta al cargar la pagina de categorias
function RolesUsuarioOnLoad(){
    RolesUsuarioCargarRolesUsuarioActivosListado();
}

// Función para obtener todos los roles de usuarios activos
function RolesUsuarioCargarRolesUsuarioActivosListado()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoRolesActivos";

    // Enviar por Ajax a rolesUsuariosCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Mantenimientos/rolesUsuariosCAD.php"
        , success: function(a) {
            $("#listaRolesUsuario").html(a).listview("refresh");
        }
    })
}
