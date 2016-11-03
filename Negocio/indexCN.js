/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 27/10/16
 */

// Función para ingresar a la pantalla de restablecerContrasena
function PaginaRestablecerContrasena()
{
    RedireccionPagina('UI/restablecerContrasena.php');
}

// Función para iniciar sesión en el sistema
function IniciarSesion()
{
    var identificacion = $('#txtIdentificacion').val();
    var contrasena = $('#txtContrasena').val();

    if(identificacion == ""
      || contrasena == "")
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Datos incompletos'
            , content: 'Debe de ingresar tanto la identificación como la contraseña.'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });
    }
    else
    {
        // Se encripta la contraseña por medio del algoritmo de encriptación SHA1
        var contrasenaEncriptada = SHA1(contrasena);

        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=iniciarSesion&identificacion=" + identificacion + "&contrasena=" + contrasenaEncriptada;

        // Enviar por Ajax a indexCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../IMVE/Datos/indexCAD.php"
            , success: function(a)
            {
                // Se divide la variable separandola por comas.
                var resultado = a.split(',');

                if(resultado[0] == 1)
                {
                    var nombreUsuario = resultado[1].split(' ')[0] + ' ' + resultado[1].split(' ')[1];
                    var sexo = resultado[2];
                    var mensajeInicioBienvenida = (sexo == 'F') ? 'Bienvenida ' : 'Bienvenido ';
                    var mensajeCompletoBienvenida = mensajeInicioBienvenida + 'de vuelta ' + nombreUsuario + '.';

                    $.alert({
                        theme: 'material'
                        , animationBounce: 1.5
                        , animation: 'rotate'
                        , closeAnimation: 'rotate'
                        , title: 'Inicio de sesión'
                        , content: mensajeCompletoBienvenida
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-success'
                        , confirm: function(){
                            RedireccionPagina('UI/bienvenida.php');
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
                        , title: 'Inicio de sesión'
                        , content: 'No se pudo realizar el inicio de sesión, verifique que tanto la identificación como la contraseña sean correctas.<br>Además recuerde que el usuario se debe de encontrar activo en el sistema.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-danger'
                    });
                }
            }
        });
    };
}
