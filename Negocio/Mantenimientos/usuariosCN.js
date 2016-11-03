/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 26/10/16
 */

// Función que se ejecuta al cargar la pagina de usuarios
function UsuariosOnLoad(){
    UsuariosCargarPersonasListado();
}

// Función que se ejecuta al cargar la pagina de usuarios detalle
function UsuariosDetalleOnLoad(){
    UsuariosCargarPersonasListadoComboBox();
    UsuariosCargarRolesComboBox();
}

// Función para obtener todos las personas
function UsuariosCargarPersonasListado()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoPersonas";

    // Enviar por Ajax a usuariosCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Mantenimientos/usuariosCAD.php"
        , success: function(a) {
            $("#listaUsuarios").html(a).listview("refresh");
        }
    })
}

// Función para obtener todos las personas
function UsuariosCargarPersonasListadoComboBox()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoPersonasCombobox";

    // Enviar por Ajax a usuariosCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Mantenimientos/usuariosCAD.php"
        , success: function(a) {
            $("#cboIdPersona").html(a);
        }
    })
}

// Función para obtener todos los roles activos
function UsuariosCargarRolesComboBox()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoRolesActivosCombobox";

    // Enviar por Ajax a rolesUsuariosCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Mantenimientos/rolesUsuariosCAD.php"
        , success: function(a) {
            $("#cboIdRol").html(a);
        }
    })
}

// Función para registrar usuario
function UsuariosRegistrarUsuario()
{
    var idPersona           = $('#cboIdPersona').val();
    var idRolUsuario        = $('#cboIdRol').val();
    var contrasena          = $('#txtContrasena').val();
    var confirmarContrasena = $('#txtConfirmarContrasena').val();

    if(idPersona == 0
        || idRolUsuario == 0
        || contrasena == ""
        || confirmarContrasena == "")
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Datos incompletos'
            , content: 'Debe de ingresar los datos que son necesarios del formulario.'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });
    }
    else
    {
        if(contrasena != confirmarContrasena)
        {
            $.alert({
                theme: 'material'
                , animationBounce: 1.5
                , animation: 'rotate'
                , closeAnimation: 'rotate'
                , title: 'Verifique la contraseña'
                , content: 'La contraseña no coincide, intente de nuevo.'
                , confirmButton: 'Aceptar'
                , confirmButtonClass: 'btn-warning'
            });
            return false;
        }
        else
        {
            // Se procede a encriptar la contraseña del usuario
            var contrasenaEncriptada = SHA1(contrasena);

            // Se define el action que será consultado desde la clase de acceso a datos
            var d = "action=registrarUsuario&idPersona=" + idPersona + "&idRolUsuario=" + idRolUsuario + "&contrasenaEncriptada=" + contrasenaEncriptada;

            // Enviar por Ajax a usuariosCAD.php
            $.ajax({
                type: "POST"
                , data: d
                , url: "../../../IMVE/Datos/Mantenimientos/usuariosCAD.php"
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
                            , title: 'Registro de usuario'
                            , content: 'El usuario se creó satisfactoriamente.'
                            , confirmButton: 'Aceptar'
                            , confirmButtonClass: 'btn-success'
                            , confirm: function(){
                                RedireccionPagina('usuarios.php');
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
                            , title: 'Registro de usuario'
                            , content: 'No se pudo crear del usuario, intente de nuevo.'
                            , confirmButton: 'Aceptar'
                            , confirmButtonClass: 'btn-danger'
                        });
                    }
                }
            });
        }
    };
}