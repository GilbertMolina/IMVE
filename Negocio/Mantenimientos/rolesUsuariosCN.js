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

// Función para registrar un rol de usuario
function RolesUsuarioRegistrarRolUsuario()
{
    var descripcion = $('#txtDescripcionRolUsuario').val();

    if(descripcion == "")
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Datos incompletos'
            , content: 'Debe de ingresar la descripción del rol de usuario.'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });
    }
    else
    {
        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=registrarRolUsuario&descripcion=" + descripcion;

        // Enviar por Ajax a rolesUsuariosCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Mantenimientos/rolesUsuariosCAD.php"
            , success: function(a)
            {
                // Se divide la variable separandola por comas.
                var resultado = a.split(',');

                if(resultado[0] == 1)
                {
                    $.alert({
                        theme: 'material'
                        , animationBounce: 1.5
                        , animation: 'rotate'
                        , closeAnimation: 'rotate'
                        , title: 'Nuevo rol de usuario'
                        , content: 'El rol de usuario se agregó satisfactoriamente.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-success'
                        , confirm: function(){
                            RedireccionPagina('rolesUsuarios.php');
                        }
                    });
                }
                else
                {
                    $.alert({
                        theme: 'material'
                        , animationBounce: 1.5
                        , animation: 'rotate'
                        , closeAnimation: 'rotate'
                        , title: 'Nuevo rol de usuario'
                        , content: 'No se pudo agregar el rol de usuario, intente de nuevo.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-danger'
                    });
                }
            }
        });
    };
}
