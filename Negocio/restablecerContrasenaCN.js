/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 29/10/16
 */

// Función para restablecer la contraseña en el sistema
function RestablecerContrasena()
{
    var identificacion = $('#txtIdentificacionRestablecer').val();

    if(identificacion == "")
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Datos incompletos'
            , content: 'Debe de ingresar la identificación para poder restablecer su contraseña.'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });
    }
    else
    {
        $.confirm({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: '<span class="jconfirmCustomize">Restablecer contraseña</span>' //Se aplica este estilo a los .confirm, puesto que estos los suele colocar en negrita.
            , content: '<span class="jconfirmCustomize">¿Esta seguro que desea restablecer la contraseña?</span>' //Se aplica este estilo a los .confirm, puesto que estos los suele colocar en negrita.
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-success'
            , cancelButton: 'Cancelar'
            , cancelButtonClass: 'btn-danger'
            , confirm: function(){
                // Se define el action que será consultado desde la clase de acceso a datos
                var d = "action=restablecerContrasena&identificacion=" + identificacion;

                // Enviar por Ajax a restablecerContrasenaCAD.php
                $.ajax({
                    type: "POST"
                    , data: d
                    , url: "../../IMVE/Datos/restablecerContrasenaCAD.php"
                    , success: function(a)
                    {
                        // Se divide la variable separandola por comas.
                        var resultado = a.split(',');

                        // No existe un correo electrónico asociado para el usuario, por lo que no se puede enviar la nueva contraseña
                        if(resultado[0] == 1)
                        {
                            // Se produjo un error al tratar de restablecer la contraseña en la base de datos
                            if(resultado[1] == 1)
                            {
                                // El correo fue enviado correctamente
                                if(resultado[2] == 1)
                                {
                                    $.alert({
                                        theme: 'material'
                                        , animationBounce: 1.5
                                        , animation: 'rotate'
                                        , closeAnimation: 'rotate'
                                        , title: 'Restablecer contraseña'
                                        , content: 'La nueva contraseña fue enviada a su correo electrónico.'
                                        , confirmButton: 'Aceptar'
                                        , confirmButtonClass: 'btn-success'
                                        , confirm: function(){
                                            RedireccionPagina('../index.php');
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
                                        , title: 'Restablecer contraseña'
                                        , content: 'Se produjo un error al intentar enviar el correo electrónico.'
                                        , confirmButton: 'Aceptar'
                                        , confirmButtonClass: 'btn-danger'
                                    });
                                }
                            }
                            else
                            {
                                $.alert({
                                    theme: 'material'
                                    , animationBounce: 1.5
                                    , animation: 'rotate'
                                    , closeAnimation: 'rotate'
                                    , title: 'Restablecer contraseña'
                                    , content: 'Se produjo un error al intentar restablecer la contraseña.'
                                    , confirmButton: 'Aceptar'
                                    , confirmButtonClass: 'btn-danger'
                                });
                            }
                        }
                        else
                        {
                            $.alert({
                                theme: 'material'
                                , animationBounce: 1.5
                                , animation: 'rotate'
                                , closeAnimation: 'rotate'
                                , title: 'Restablecer contraseña'
                                , content: 'No existe un correo asociado, al cual se pueda enviar la nueva contraseña.<br>Además recuerde que el usuario se debe de encontrar activo en el sistema.'
                                , confirmButton: 'Aceptar'
                                , confirmButtonClass: 'btn-danger'
                            });
                        }
                    }
                });
            }
        });
    };
}