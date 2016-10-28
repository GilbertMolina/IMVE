/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Date: 27/10/16
 */

//Funcion para ingresar a la pantalla de index
function indexRegresar()
{
    redireccionPagina('../index.php');
}

//Funcion que se ejecuta al cargar la pagina
function RegistrarseOnLoad(){
    cargarProvincias();
    
}

//Funcion que se ejecuta cuando cambia la provincia seleccionada
function onSelectedChangeProvincias(){
    $('div#cboIdCanton-button').children('span').html('Seleccione');
    $('div#cboIdDistrito-button').children('span').html('Seleccione');

    cargarCantones();
    cargarDistritos();
}

//Funcion que se ejecuta cuando cambia el cantón seleccionada
function onSelectedChangeCantones(){
    $('div#cboIdDistrito-button').children('span').html('Seleccione');

    cargarDistritos();
}

//Funcion para registrar usuario en el sistema
function registrarUsuario()
{
    var identificacion = $('#txtIdentificacion').val().trim();
    var nombre = $('#txtNombre').val().trim();
    var apellido1 = $('#txtApellido1').val().trim();
    var apellido2 = $('#txtApellido2').val().trim();
    var fechaNacimiento = $('#txtFechaNacimiento').val();
    var distrito = $('#cboIdDistrito').val();
    var direccionDomicilio = $('#txtDireccionDomicilio').val().trim();
    var telefono = $('#txtTelefono').val().trim();
    var celular = $('#txtCelular').val().trim();
    var sexo = $('#cboSexo').val();
    var contrasena = $('#txtContrasena').val();
    var confirmarContrasena = $('#txtConfirmarContrasena').val();

    if(identificacion == ""
       || nombre == ""
       || apellido1 == ""
       || apellido2 == ""
       || fechaNacimiento == ""
       || distrito == ""
       || direccionDomicilio == ""
       || telefono == ""
       || celular == ""
       || sexo == ""
       || contrasena == ""
       || confirmarContrasena == "")
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Datos incompletos'
            , content: 'Debe de ingresar todos los datos del formulario.'
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
        }
        else
        {
            var contrasenaEncriptada = SHA1(contrasena);

            //Enviar por ajax a RegistrarseCN.php
            var d = "action=registrarUsuario&identificacion=" + identificacion + "&nombre=" + nombre + "&apellido1=" + apellido1 + "&apellido2=" + apellido2 + "&fechaNacimiento=" + fechaNacimiento
                + "&distrito=" + distrito + "&direccionDomicilio=" + direccionDomicilio + "&telefono=" + telefono + "&celular=" + celular + "&sexo=" + sexo + "&contrasenaEncriptada=" + contrasenaEncriptada;

            $.ajax({
                type: "POST"
                , data: d
                , url: "../../IMVE/Datos/RegistrarseCAD.php"
                , success: function(a)
                {
                    // Se divide la variable separandola por comas.
                    var resultado = a.split(',');
                    console.log(a);
                    if(resultado[0] == 1)
                    {
                        $.alert({
                            theme: 'material'
                            , animationBounce: 1.5
                            , animation: 'rotate'
                            , closeAnimation: 'rotate'
                            , title: 'Registro de usuario'
                            , content: 'El registro se realizó satisfactoriamente'
                            , confirmButton: 'Aceptar'
                            , confirmButtonClass: 'btn-success'
                            , confirm: function(){
                                redireccionPagina('../index.php');
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
                            , content: 'No se pudo realizar el registro del usuario, intente de nuevo.'
                            , confirmButton: 'Aceptar'
                            , confirmButtonClass: 'btn-danger'
                        });
                    }
                }
            });
        }
    };
}