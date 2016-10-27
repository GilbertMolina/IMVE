/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Date: 26/10/16
 */
//Funcion para redireccionar pagina
function redireccionPagina(url)
{
    window.location.href = url;
}

// Función que permite ingresar solamente números
function soloNumeros(e)
{
    var key = window.Event ? e.which : e.keyCode;
    return (key >= 48 && key <= 57);
}