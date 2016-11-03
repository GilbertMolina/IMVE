/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 03/11/16
 */

// Función que se ejecuta al cargar la pagina de categorias
function TiposRelacionesOnLoad(){
    TiposRelacionesCargarTiposRelacionesListado();
}

// Función para obtener todos los tipos de relaciones
function TiposRelacionesCargarTiposRelacionesListado()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoRelaciones";

    // Enviar por Ajax a tiposRelacionesCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Mantenimientos/tiposRelacionesCAD.php"
        , success: function(a) {
            $("#listaTiposRelaciones").html(a).listview("refresh");
        }
    })
}

// Función para registrar un tipo de relacion
function TiposRelacionesRegistrarTipoRelacion()
{
    var nombreMasculino        = $('#txtNombreMasculino').val();
    var nombreFemenino         = $('#txtNombreFemenino').val();
    var nombreInversoMasculino = $('#txtNombreInversoMasculino').val();
    var nombreInversoFemenino  = $('#txtNombreInversoFemenino').val();

    if(nombreMasculino == ""
        ||nombreFemenino == ""
        ||nombreInversoMasculino == ""
        ||nombreInversoFemenino == "")
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Datos incompletos'
            , content: 'Debe de ingresar todos los campos del formulario'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });
    }
    else
    {
        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=registrarTipoRelacion&nombreMasculino=" + nombreMasculino + "&nombreFemenino=" + nombreFemenino + "&nombreInversoMasculino=" + nombreInversoMasculino + "&nombreInversoFemenino=" + nombreInversoFemenino;

        // Enviar por Ajax a tiposRelacionesCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Mantenimientos/tiposRelacionesCAD.php"
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
                        , title: 'Nuevo tipo de relación'
                        , content: 'El tipo de relación se agregó satisfactoriamente.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-success'
                        , confirm: function(){
                            RedireccionPagina('tiposRelaciones.php');
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
                        , title: 'Nuevo tipo de relación'
                        , content: 'No se pudo agregar el tipo de relación, intente de nuevo.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-danger'
                    });
                }
            }
        });
    };
}
