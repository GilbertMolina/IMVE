/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 03/11/16
 */

// Función que se ejecuta al cargar la pagina de roles de usuario
function RolesUsuarioOnLoad(){
    RolesUsuarioCargarRolesUsuarioListado();
}

// Función que se ejecuta al cargar la pagina de roles de usuario detalle
function RolesUsuarioDetalleOnLoad(){
    RolesUsuarioCargarRolesUsuarioPorId();
}

// Función para obtener todos los roles de usuarios activos o inactivos
function RolesUsuarioCargarRolesUsuarioListado() {
    var estado = ObtenerValorRadioButtonPorNombre('estadoRolUsuario');

    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoRolesUsuarioPorEstado&estado=" + estado;

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
function RolesUsuarioRegistrarRolUsuario() {
    var descripcion = $('#txtDescripcionRolUsuario').val();

    if(descripcion == "")
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Advertencia'
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
                        , title: 'Información'
                        , content: 'El rol de usuario se agregó satisfactoriamente.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-success'
                        , confirm: function(){
                            RedireccionPagina('rolesUsuarios.php');
                        }
                    });
                }
                else if(resultado[0].includes("Duplicate"))
                {
                    $.alert({
                        theme: 'material'
                        , animationBounce: 1.5
                        , animation: 'rotate'
                        , closeAnimation: 'rotate'
                        , title: 'Advertencia'
                        , content: 'El rol de usuario ya se encuentra registrado.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-warning'
                    });
                }
                else
                {
                    $.alert({
                        theme: 'material'
                        , animationBounce: 1.5
                        , animation: 'rotate'
                        , closeAnimation: 'rotate'
                        , title: 'Error'
                        , content: 'No se pudo agregar el rol de usuario, intente de nuevo.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-danger'
                    });
                }
            }
        });
    };
}

// Función para cargar un rol de usuario por su id
function RolesUsuarioCargarRolesUsuarioPorId() {
    var idRolUsuario = ObtenerParametroPorNombre('IdRolUsuario');

    if(idRolUsuario != ''){

        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=cargarRolUsuario&idRolUsuario=" + idRolUsuario;

        // Enviar por Ajax a rolesUsuariosCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Mantenimientos/rolesUsuariosCAD.php"
            , success: function(a) {
                $("#rolesUsuarioDetalle").html(a).trigger( "create" );
            }
        });
    }
}

// Función para modificar un rol de usuario
function RolesUsuarioModificarRolesUsuario(p_idRolUsuario) {
    var idRolUsuario = p_idRolUsuario;
    var descripcion = $('#txtDescripcionRolUsuario').val();
    var estado = $('#cboEstadoRolUsuario').val();

    if(descripcion == ""
        || estado == "0")
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Advertencia'
            , content: 'Debe de ingresar la descripción y el estado del rol de usuario.'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });
    }
    else
    {
        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=modificarRolUsuario&idRolUsuario=" + idRolUsuario + "&descripcion=" + descripcion + "&estado=" + estado;

        // Enviar por Ajax a rolesUsuariosCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Mantenimientos/rolesUsuariosCAD.php"
            , success: function(a)
            {
                // Se obtiene el resultado.
                if (a == 1)
                {
                    $.alert({
                        theme: 'material'
                        , animationBounce: 1.5
                        , animation: 'rotate'
                        , closeAnimation: 'rotate'
                        , title: 'Información'
                        , content: 'El rol de usuario se modificó satisfactoriamente.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-success'
                        , confirm: function(){
                            RedireccionPagina('rolesUsuarios.php');
                        }
                    });
                }
                else if(a.includes("Duplicate"))
                {
                    $.alert({
                        theme: 'material'
                        , animationBounce: 1.5
                        , animation: 'rotate'
                        , closeAnimation: 'rotate'
                        , title: 'Advertencia'
                        , content: 'Un rol de usuario con la misma descripción ya se encuentra registrado.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-warning'
                    });
                }
                else
                {
                    $.alert({
                        theme: 'material'
                        , animationBounce: 1.5
                        , animation: 'rotate'
                        , closeAnimation: 'rotate'
                        , title: 'Error'
                        , content: 'No se pudo modificar el rol de usuario, intente de nuevo.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-danger'
                    });
                }
            }
        });
    };
}
