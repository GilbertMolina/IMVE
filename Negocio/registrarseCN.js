/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 27/10/16
 */

// Variable para determinar si se debe de registar el usuario con el concentimiento de que no tendrá correo electrónico registrado
var registarSinCorreo = false;

// Función que se ejecuta al cargar la pagina
function OnLoadRegistrarse(){
    AsignarFechaActual();
    cargarProvincias();
}

// Función que se ejecuta cuando cambia la provincia seleccionada
function onSelectedChangeProvincias(){
    $('div#cboIdCanton-button').children('span').html('Seleccione');
    $('div#cboIdDistrito-button').children('span').html('Seleccione');

    cargarCantones();
    cargarDistritos();
}

// Función que se ejecuta cuando cambia el cantón seleccionada
function OnSelectedChangeCantones(){
    $('div#cboIdDistrito-button').children('span').html('Seleccione');

    cargarDistritos();
}

// Función que carga la fecha actual en el campo de fecha de nacimiento
function AsignarFechaActual()
{
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth() + 1;
    var a = date.getFullYear();
    var fechaCompleta = d + '/' + m + '/' + a;

    document.getElementById("txtFechaNacimiento").defaultValue = fechaCompleta;
}

// Función para registrar usuario en el sistema
function RegistrarUsuario()
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
    var correo = $('#txtCorreo').val().trim();
    var sexo = $('#cboSexo').val();
    var foto = '';
    var contrasena = $('#txtContrasena').val();
    var confirmarContrasena = $('#txtConfirmarContrasena').val();

    if(identificacion == ""
       || nombre == ""
       || apellido1 == ""
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
            , content: 'Debe de ingresar los datos que son necesarios del formulario.'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });
    }
    else
    {
        if(!ValidarCorreo())
        {
            return false;
        }
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
            if(correo == ''
               && registarSinCorreo == false)
            {
                $.confirm({
                    theme: 'material'
                    , animationBounce: 1.5
                    , animation: 'rotate'
                    , closeAnimation: 'rotate'
                    , title: 'Validación de correo'
                    , content: '<p>El correo electrónico es necesario posteriormente para recordar la contraseña, en caso de que la olvide. <br><br> ¿Desea continuar sin ingresar un correo electrónico?</p>'
                    , confirmButton: 'Acepto'
                    , confirmButtonClass: 'btn-success'
                    , cancelButton: 'No acepto'
                    , cancelButtonClass: 'btn-warning'
                    , confirm: function(){
                        registarSinCorreo = true;

                        IngresarUsuario(identificacion
                            , nombre
                            , apellido1
                            , apellido2
                            , fechaNacimiento
                            , distrito
                            , direccionDomicilio
                            , telefono
                            , celular
                            , correo
                            , sexo
                            , foto
                            , contrasena);
                    }
                    , cancel: function(){
                        registarSinCorreo = false;
                    }
                });
            }
            else
            {
                IngresarUsuario(identificacion
                    , nombre
                    , apellido1
                    , apellido2
                    , fechaNacimiento
                    , distrito
                    , direccionDomicilio
                    , telefono
                    , celular
                    , correo
                    , sexo
                    , foto
                    , contrasena);
            }
        }
    };
}

// Función que registra el usuario del usuario a la base de datos por medio de Ajax
function IngresarUsuario(p_Identificacion, p_Nombre, p_Apellido1, p_Apellido2, p_FechaNacimiento, p_Distrito , p_DireccionDomicilio, p_Telefono, p_Celular, p_Correo, p_Sexo, p_foto, p_Contrasena){
    var contrasenaEncriptada = SHA1(p_Contrasena);

    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=registrarUsuario&identificacion=" + p_Identificacion + "&nombre=" + p_Nombre + "&apellido1=" + p_Apellido1 + "&apellido2=" + p_Apellido2 + "&fechaNacimiento=" + p_FechaNacimiento + "&distrito=" + p_Distrito
        + "&direccionDomicilio=" + p_DireccionDomicilio + "&telefono=" + p_Telefono + "&celular=" + p_Celular + "&correo=" + p_Correo + "&sexo=" + p_Sexo + "&foto=" + p_foto + "&contrasenaEncriptada=" + contrasenaEncriptada;

    // Enviar por Ajax a registrarseCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../IMVE/Datos/registrarseCAD.php"
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
                    , content: 'El registro se realizó satisfactoriamente.'
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
                    , title: 'Registro de usuario'
                    , content: 'No se pudo realizar el registro del usuario, intente de nuevo.'
                    , confirmButton: 'Aceptar'
                    , confirmButtonClass: 'btn-danger'
                });
            }
        }
    });
};

// Función que valida si el correo eléctronico introducido es valido
function ValidarCorreo() {
    var correo = $('#txtCorreo').val().trim();
    var RegExp = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if(correo != "")
    {
        if (!RegExp.test(correo))
        {
            $.alert({
                theme: 'material'
                , animationBounce: 1.5
                , animation: 'rotate'
                , closeAnimation: 'rotate'
                , title: 'Validación de correo'
                , content: 'El correo "' + correo +'" no es válido, por favor verifíquelo.'
                , confirmButton: 'Aceptar'
                , confirmButtonClass: 'btn-warning'
            });
            return false;
        }
        else
        {
            return true;
        }
    }
    else
    {
        return true;
    }
}

// Función para ingresar a la pantalla de index
function IndexRegresar()
{
    RedireccionPagina('../index.php');
}