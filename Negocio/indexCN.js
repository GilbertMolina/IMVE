/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollador por: Gilberth Molina
 * Date: 26/10/16
 */

//Funcion para iniciar sesión en el sistema
function inicioSesion()
{
    var identificacion=$('#txtIdentificacion').val();
    var contrasena=$('#txtContrasena').val();

    console.log('identificacion: ' + identificacion);
    console.log('contrasena: ' + contrasena);

    if(identificacion=="" || contrasena=="")
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Faltan datos'
            , content: 'Debe de ingresar la identificación y la contraseña.'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-primary'
        });
    }
    else
    {
        //Enviar por ajax a IndexCN.php
        var d = "action=iniciarSesion&identificacion=" + identificacion + "&contrasena=" + contrasena;
        $.ajax({
            type: "POST"
            , data: d
            , url: "../IMVE/Datos/IndexCAD.php"
            , success: function(a)
            {
                // Se divide la variable separandola por comas.
                var resultado=a.split(',');
                console.log(resultado);
                if(resultado[0] == 1)
                {
                    var nombreUsuario = resultado[1].split(' ')[0] + ' ' + resultado[1].split(' ')[1];
                    $.alert({
                        theme: 'material'
                        , animationBounce: 1.5
                        , animation: 'rotate'
                        , closeAnimation: 'rotate'
                        , title: 'Inicio de sesión'
                        , content: 'Bienvenido de vuelta ' + nombreUsuario + '.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-success'
                        , confirm: function(){
                            redireccionPagina('UI/bienvenida.php');
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
                        , content: 'No se pudo realizar el inicio de sesión, verifique que tanto la identificación como la contraseña sean correctas.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-danger'
                    });
                }
            }
        });
    };
}

//Funcion para cerrar sesión en el sistema
function cerrarSesion()
{
    $.confirm({
        theme: 'material'
        , animationBounce: 1.5
        , animation: 'rotate'
        , closeAnimation: 'rotate'
        , title: 'Cerrar sesión'
        , content: '¿Esta seguro que desea cerrar la sesión?'
        , confirmButton: 'Aceptar'
        , confirmButtonClass: 'btn-success'
        , cancelButton: 'Cancelar'
        , cancelButtonClass: 'btn-danger'
        , confirm: function(){
            //Enviar por ajax a IndexCN.php
            var d = "action=cerrarSesion";
            $.ajax({
                type: "POST"
                , data: d
                , url: "../Datos/IndexCAD.php"
                , success: function(a)
                {
                    $.alert({
                        title: 'Ha cerrado la sesión'
                        , content: 'Esperamos que vuelva pronto.'
                        , theme: 'material'
                        , animationBounce: 1.5
                        , animation: 'rotate'
                        , closeAnimation: 'rotate'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-success'
                        , confirm: function(){
                            redireccionPagina('../index.php');
                        }
                    });
                }
            });
        }
    });
}