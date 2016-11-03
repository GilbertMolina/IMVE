/**
 * Sistema para la Iglesia Manantiales de Vida Eterna
 * Desarrollado por: Gilberth Molina
 * Fecha creación: 03/11/16
 */

// Función que se ejecuta al cargar la pagina de categorias
function CategoriasGruposOnLoad(){
    CategoriasGruposCargarCategoriasGruposActivasListado();
}

// Función para obtener todas las categorias grupos activas
function CategoriasGruposCargarCategoriasGruposActivasListado()
{
    // Se define el action que será consultado desde la clase de acceso a datos
    var d = "action=obtenerListadoCategoriasGruposActivas";

    // Enviar por Ajax a categoriasGruposCAD.php
    $.ajax({
        type: "POST"
        , data: d
        , url: "../../../IMVE/Datos/Mantenimientos/categoriasGruposCAD.php"
        , success: function(a) {
            $("#listaCategoriasGrupos").html(a).listview("refresh");
        }
    })
}

// Función para registrar una categoria grupo
function CategoriasGruposRegistrarCategoriaGrupo()
{
    var descripcion = $('#txtDescripcionCategoriaGrupo').val();

    if(descripcion == "")
    {
        $.alert({
            theme: 'material'
            , animationBounce: 1.5
            , animation: 'rotate'
            , closeAnimation: 'rotate'
            , title: 'Datos incompletos'
            , content: 'Debe de ingresar la descripción de la categoría de grupo.'
            , confirmButton: 'Aceptar'
            , confirmButtonClass: 'btn-warning'
        });
    }
    else
    {
        // Se define el action que será consultado desde la clase de acceso a datos
        var d = "action=registrarCategoriaGrupo&descripcion=" + descripcion;

        // Enviar por Ajax a categoriasGruposCAD.php
        $.ajax({
            type: "POST"
            , data: d
            , url: "../../../IMVE/Datos/Mantenimientos/categoriasGruposCAD.php"
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
                        , content: 'La categoría de grupo se agregó satisfactoriamente.'
                        , confirmButton: 'Aceptar'
                        , confirmButtonClass: 'btn-success'
                        , confirm: function(){
                            RedireccionPagina('categoriasGrupos.php');
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