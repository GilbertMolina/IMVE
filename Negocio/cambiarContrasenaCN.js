/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 01/11/16
 */

// Función que cambia la contraseña del usuario
function CambiarContrasena()
{
    var contrasena          = $('#txtContrasenaNueva').val();
    var confirmarContrasena = $('#txtConfirmarContrasenaNueva').val();

    if(contrasena == ""
        || confirmarContrasena == "")
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Advertencia'
            , content: 'Debe de ingresar la contraseña y además confirmarla.'
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
                , title: 'Advertencia'
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
            var d = "action=cambiarContrasena&contrasenaEncriptada=" + contrasenaEncriptada;

            // Enviar por Ajax a cambiarContrasenaCAD.php
            $.ajax({
                type: "POST"
                , data: d
                , url: "../Datos/cambiarContrasenaCAD.php"
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
                            , content: 'Se cambió la contraseña satisfactoriamente.'
                            , confirmButton: 'Aceptar'
                            , confirmButtonClass: 'btn-success'
                            , confirm: function(){
                                RedireccionPagina('bienvenida.php');
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
                            , title: 'Error'
                            , content: 'No se pudo cambiar la contraseña del usuario, intente de nuevo.'
                            , confirmButton: 'Aceptar'
                            , confirmButtonClass: 'btn-danger'
                        });
                    }
                }
            });
        }
    };
}