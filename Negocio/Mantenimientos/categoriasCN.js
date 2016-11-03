/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 03/11/16
 */

// Función que se ejecuta al cargar la pagina de categorias
function CategoriasOnLoad(){
    CategoriasCargarCategoriasActivasListado();
}

// Función para obtener todas las categorias activas
function CategoriasCargarCategoriasActivasListado()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoCategoriasActivas";

    // Enviar por Ajax a categoriasCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Mantenimientos/categoriasCAD.php"
        , success: function(a) {
            $("#listaCategorias").html(a).listview("refresh");
        }
    })
}

// Función para registrar una categoria persona
function CategoriasRegistrarCategoria()
{
    var descripcion = $('#txtDescripcionCategoria').val();

    if(descripcion == "")
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Datos incompletos'
            , content: 'Debe de ingresar la descripción de la categoría de persona.'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });
    }
    else
    {
        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=registrarCategoria&descripcion=" + descripcion;

        // Enviar por Ajax a categoriasCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Mantenimientos/categoriasCAD.php"
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
                        , title: 'Nueva categoría de persona'
                        , content: 'La categoría de persona se agregó satisfactoriamente.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-success'
                        , confirm: function(){
                            RedireccionPagina('categorias.php');
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
                        , title: 'Nueva categoría de persona'
                        , content: 'No se pudo agregar la categoría, intente de nuevo.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-danger'
                    });
                }
            }
        });
    };
}